<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 0);

require_once 'functions.php';

$output = null;
$retval = null;
$randString = '';
$destinationRepoUrl = '';
$localRepoDir = 'repositories';

//$sourceRepoUrl = 'http://172.20.1.5/ir.simorgh.git/AutoWindowsUpdateDisabler.git';

try {
    $randString = generateRandomString();
//    $sourceDirName = explode('.', array_reverse(explode('/', $sourceRepoUrl))[0])[0];
    $sourceDirName = getSourceDirName($sourceRepoUrl); //array

//    $fullRepoDir = $localRepoDir . DIRECTORY_SEPARATOR . $sourceDirName;
    $fullRepoDir = getFullReposDir($localRepoDir, $sourceDirName); //array

    $destinationRepoUrl = getDestinationRepos($destinationGitUname, $sourceDirName); //array

//    var_dump($fullRepoDir, $sourceDirName);die;

//    cloneSourceRepo($localRepoDir, $sourceRepoUrl);
    cloneSourceRepos($localRepoDir, $sourceRepoUrl);

//    makeOnlineRepo($sourceDirName);
    makeOnlineRepos($sourceDirName);

//    transportRepo($fullRepoDir, $randString, $destinationRepoUrl);
    transportRepos($sourceDirName, $localRepoDir,$destinationGitUname, $randString, $destinationRepoUrl);

//    forceRemoveLocalRepo($localRepoDir, $sourceDirName);
    forceRemoveLocalRepos($localRepoDir, $sourceDirName);

//    var_dump($output, $retval);die();

} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}

