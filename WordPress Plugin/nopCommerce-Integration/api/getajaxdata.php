<?php

$url=$_REQUEST['url'];

include_once('../../../../wp-load.php');
$urlntl = str_replace("/api","",plugin_dir_url( __FILE__ ));

$sul = $urlntl.'googleoauth2/index.php';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$sul);
curl_setopt($ch, CURLOPT_POST, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
$access_token = $server_output;

$ch = curl_init();
$authorization = "Authorization: Bearer ".$access_token;
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, 0);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
$server_output = curl_exec ($ch);
print_r($server_output);die;
return($server_output);
curl_close ($ch);
//

?>