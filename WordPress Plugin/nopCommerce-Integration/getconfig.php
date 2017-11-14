<?php 

include_once('../../../wp-load.php');
global $wpdb;



 $user_data = $wpdb->get_var( "SELECT * FROM $wpdb->users");

print_r($user_data);
?>