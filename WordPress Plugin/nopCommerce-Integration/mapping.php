<?php 
header('Access-Control-Allow-Origin: *');  
include_once('../../../wp-load.php');
include_once('../../../wp-includes/user.php');
global $wpdb;

$wpid = get_current_user_id();
$nopuid=$wpdb->get_results("select * from ".$wpdb->prefix.'usermapping where wpuid="'.$wpid.'"');


if(count($nopuid) == 0)
{
echo "notlogin";
}
else
{

echo $nopuid[0]->nopuid;
}
?>