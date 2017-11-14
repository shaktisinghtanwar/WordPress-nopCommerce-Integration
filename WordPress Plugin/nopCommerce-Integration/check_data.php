<?php 

include_once('../../../wp-load.php');
global $wpdb;

$email= $_REQUEST['email'];
$username= $_REQUEST['username'];
$rsuser=$wpdb->get_results("select * from ".$wpdb->prefix.'users where user_login="'.$username.'"');
$rsemail=$wpdb->get_results("select * from ".$wpdb->prefix.'users where user_email="'.$email.'"');
if(count($rsuser)>0)
{
	echo "Username already exist";
}
else if(count($rsemail)>0)
{
	echo "email already exist";
}
else
	
	{
		echo "Create";
}
?>