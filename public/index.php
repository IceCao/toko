<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$system_path = '../system';
$application_folder = '../application';

$system_path = realpath($system_path) ?: $system_path;
$system_path = rtrim($system_path, '/').'/';

define('BASEPATH', str_replace("\\", "/", $system_path));

if (is_dir($application_folder)) {
    define('APPPATH', $application_folder.'/');
} else {
    if (!is_dir(BASEPATH.$application_folder.'/')) {
        exit("Your application folder path does not appear to be set correctly.");
    }
    define('APPPATH', BASEPATH.$application_folder.'/');
}

require_once BASEPATH.'core/CodeIgniter.php';
