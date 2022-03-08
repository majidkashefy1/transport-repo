<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 0);

require_once 'from.php';
require_once 'to.php';

//$sourceRepoUrl = 'git@github.com:majidkashefy1/from-repo.git';
$output = null;
$retval = null;

//$sourceRepoUrl = 'http://172.20.1.5/ir.simorgh.git/AutoWindowsUpdateDisabler.git';
$sourceRepoUrl = 'git@github.com:majidkashefy1/from-repo.git';
$sourceDirName = explode('.', array_reverse(explode('/', $sourceRepoUrl))[0])[0];

exec('curl -H "Content-Type:application/json" https://gitlab.com/api/v4/projects?private_token=glpat-FGakNP5qQeAB7dyzXimx -d "{ \"name\": \"'.$sourceDirName.'\" }"');

$destinationRepoUrl = 'git@gitlab.com:kashefsimorgh/'.$sourceDirName.'.git';
$randString= generateRandomString();


//clone repo
//exec('git clone '.$sourceRepoUrl.' || exit 1', $output, $retval);
if (!file_exists(__DIR__ . DIRECTORY_SEPARATOR . $sourceDirName)) {
    exec('git clone ' . $sourceRepoUrl);
}

//rmdir(__DIR__ . DIRECTORY_SEPARATOR . $sourceDirName);
//die('cd ' . $sourceDirName. ' && git remote add '.$randString .' '. $destinationRepoUrl. ' && git push '.$randString.' --tags "refs/remotes/origin/*:refs/heads/*"');
//exec('cd ' . $sourceDirName);
//exec('git push origin && git checkout develop && git pull origin main');
//exec('git remote add b ' . $destinationRepoUrl. ' || git status', $output, $retval);
exec('cd ' . $sourceDirName. ' && git remote add '.$randString .' '. $destinationRepoUrl. ' && git push '.$randString.' --tags "refs/remotes/origin/*:refs/heads/*"', $output, $retval);


var_dump($output, $retval);

//unlink(__DIR__ . DIRECTORY_SEPARATOR . $sourceDirName);