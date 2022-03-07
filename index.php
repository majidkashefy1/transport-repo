<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 0);

require_once 'from.php';
require_once 'to.php';

$sourceRepoUrl = 'git@github.com:majidkashefy1/from-repo.git';
$destinationRepoUrl = 'git@gitlab.com:majidkashef1/transport-repo2.git';

$sourceDirName = explode('.', array_reverse(explode('/', $sourceRepoUrl))[0])[0];

$output = null;
$retval = null;

//clone repo
//exec('git clone '.$sourceRepoUrl.' || exit 1', $output, $retval);
if (!file_exists(__DIR__.DIRECTORY_SEPARATOR.$sourceDirName)){
    exec('git clone '.$sourceRepoUrl);
}

exec('git clone '.$sourceRepoUrl.' && cd ' . $sourceDirName . ' && git checkout develop && git remote add b '.$destinationRepoUrl.' && git add . && git commit -m "from1 php" && git push b develop', $output, $retval);

echo "Returned with status $retval and output:\n";
//echo 'done.';
print_r($output);