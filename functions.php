<?php

require_once 'conf.php';

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function makeOnlineRepo($name)
{
    exec('curl -H "Content-Type:application/json" https://gitlab.com/api/v4/projects?private_token=glpat-FGakNP5qQeAB7dyzXimx -d "{ \"name\": \"' . $name . '\" }"');
}

function makeOnlineRepos($source_repos_name)
{
    foreach ($source_repos_name as $source_repo) {
        makeOnlineRepo($source_repo);
    }
}

function cloneSourceRepo($local_repo_dir, $repo)
{
    if (!file_exists(__DIR__ . DIRECTORY_SEPARATOR . $local_repo_dir . DIRECTORY_SEPARATOR . $repo)) {
        exec('cd ' . $local_repo_dir . ' && git clone ' . $repo);
    } else {
        die('has file');
//        forceRemoveDir(__DIR__ . DIRECTORY_SEPARATOR . $name);
    }
}

function cloneSourceRepos($local_repo_dir, $source_repos_url)
{
    foreach ($source_repos_url as $source_repo) {
        cloneSourceRepo($local_repo_dir, $source_repo);
    }
}

function destinationRepo($git_uname, $source_repo)
{
    return 'git@gitlab.com:' . $git_uname . '/' . $source_repo . '.git';
}


function getDestinationRepos($git_uname, $source_repos_url)
{
    $reposDestinations = [];
    foreach ($source_repos_url as $source_repo) {
        $reposDestinations[] = destinationRepo($git_uname, $source_repo);
    }
    return $reposDestinations;
}

function transportRepo($local_source_dir, $randString, $destinationRepoUrl)
{
    exec('cd ' . $local_source_dir . ' && git remote add ' . $randString . ' ' . $destinationRepoUrl . ' && git push ' . $randString . ' --tags "refs/remotes/origin/*:refs/heads/*"', $output, $retval);
}

function transportRepos($source_names, $local_repo_dir, $git_uname, $randString)
{
    foreach ($source_names as $source_repo) {
        $local_source_dir = $local_repo_dir . DIRECTORY_SEPARATOR . $source_repo;
        $destination_rep_url=destinationRepo($git_uname, $source_repo);
        transportRepo($local_source_dir, $randString, $destination_rep_url);
    }

}

function forceRemoveLocalRepo($repos_dir, $repo_name)
{
    exec('cd ' . $repos_dir . DIRECTORY_SEPARATOR . $repo_name . ' && rm -rf * .*', $o, $v);
    exec('cd ' . $repos_dir . ' && rm -rf ' . $repo_name, $o, $v);
}

function forceRemoveLocalRepos($repos_dir, $repos_name)
{
    foreach ($repos_name as $repo_name) {
        forceRemoveLocalRepo($repos_dir, $repo_name);
    }
}

function getSourceDirName($source_repos_url): array
{
    $sourceDirName = [];
    foreach ($source_repos_url as $source_repo) {
        $sourceDirName[] = explode('.', array_reverse(explode('/', $source_repo))[0])[0];
    }
    return $sourceDirName;
}

function action($source_repos_name, $localRepoDir, $source_repos_url, $destination_git_Uname , $rand_string){
    cloneSourceRepos($localRepoDir, $source_repos_url);

    makeOnlineRepos($source_repos_name);

    transportRepos($source_repos_name, $localRepoDir,$destination_git_Uname, $rand_string);

    forceRemoveLocalRepos($localRepoDir, $source_repos_name);

    echo 'done!';
}
//
//function getFullReposDir($local_repo_dir, $source_repos_url): array
//{
//    $sourceReposDirName = [];
//    foreach ($source_repos_url as $source_repo) {
//        $sourceReposDirName[] = $local_repo_dir . DIRECTORY_SEPARATOR . $source_repo;
//    }
//    return $sourceReposDirName;
//}

