<?php #!/usr/bin/env /usr/bin/php
/*
Script from http://www.tegdesign.com/git-webhook-php-post-receive-pull-method/ - Thank you.
*/


// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Set no time limit as some people report Github timing quickly
set_time_limit(0);


// Github can POST commit data etc, try and decode it
try {
 
  $payload = json_decode($_REQUEST['payload']);
 
}
catch(Exception $e) {
 
    //Log the error
    file_put_contents('/var/log/lumi/github.log', $e . ' ' . $payload, FILE_APPEND);
 
      exit(0);
}

// If request content matches expected then...
if ($payload->ref === 'refs/heads/master') {
 
    // Set dir
    $project_directory = '/var/lumi/test/';

    // Trigger Git pull script
    $output = shell_exec("/var/lumi/git-puller.sh");
 
    // Log the request
    file_put_contents('/var/log/lumi/github.log', $output, FILE_APPEND);
 
}
?>
