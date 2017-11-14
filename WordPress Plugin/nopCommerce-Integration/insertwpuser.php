<?php 

include_once('../../../wp-load.php');
global $wpdb;

$email= $_REQUEST['email'];
$username= $_REQUEST['username'];
$firstname= $_REQUEST['firstname'];
$lastname= $_REQUEST['lastname'];
$password= wp_hash_password($_REQUEST['password']);
$tblname = $wpdb->prefix.'users';
//var_dump($tblname,array("user_login" => $username, "user_email" => $email,"nickname"=>$firstname,"user_pass" => $password,"user_status"=>'1'));die;

$wpdb->insert( 
	$tblname, 
	array( 
		"user_login" => $username,
		 "user_email" => $email,
"user_nicename"=>$firstname,
"user_pass" => $password,
"user_status"=>'1',
"user_url"=>'',
"user_registered"=>'',
"user_activation_key"=>'',
"display_name"=>''
	));
		$lastid = $wpdb->insert_id;
$user = new \WP_User( $lastid );
	$user->set_role("subscriber");

$tblnameusmeta = $wpdb->prefix.'usermeta';
$wpdb->insert( 
$tblnameusmeta, 
	array( 
		"meta_key" => 'nickname',
		 "meta_value" => $firstname,
 		 "user_id" => $lastid
	));

$wpdb->insert( 
$tblnameusmeta, 
	array( 
		"meta_key" => 'first_name',
		 "meta_value" =>$firstname,
		 "user_id" => $lastid

	));
$wpdb->insert( 
$tblnameusmeta, 
	array( 
		"meta_key" => 'last_name',
		 "meta_value" => $lastname,
		"user_id" => $lastid

	));

echo $lastid.'-User registered successfully.'; 
?>