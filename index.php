<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 0);

require_once 'functions.php';

$output = null;
$retval = null;
$randString = '';
$destinationRepoUrl = '';
$localRepoDir = 'repositories';


try {
    $randString = generateRandomString();
    $sourcesDirectory = getSourceDirName($sourceRepoUrl); //array

    $destinationRepoUrl = getDestinationRepos($destinationGitUname, $sourcesDirectory); //array

    action($sourcesDirectory, $localRepoDir, $sourceRepoUrl,$destinationGitUname, $randString);

} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}

