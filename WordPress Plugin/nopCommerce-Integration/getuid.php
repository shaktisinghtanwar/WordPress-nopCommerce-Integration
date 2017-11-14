<?php 

include_once('../../../wp-load.php');
global $wpdb;

$usrname= $_GET['usrname'];

$rsuser=$wpdb->get_results("select id from ".$wpdb->prefix.'users where user_login="'.$usrname.'"');

$wpid = $rsuser[0]->id;

$rsenopuid=$wpdb->get_results("select nopuid from ".$wpdb->prefix.'usermapping where wpuid="'.$wpid.'"');

echo $rsenopuid[0]->nopuid;die;

?>