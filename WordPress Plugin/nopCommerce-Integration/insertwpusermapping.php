<?php 

include_once('../../../wp-load.php');
global $wpdb;
$wpuid= trim($_REQUEST['wpuid']);
$nopeuid= trim($_REQUEST['nopeuid']);

$table_name =  $wpdb->prefix.'usermapping';
if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
 $charset_collate = $wpdb->get_charset_collate();  
 $sql="CREATE TABLE `wp_usermapping` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `wpuid` varchar(200) NOT NULL,
  `nopuid` varchar(200) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql ); 
$wpdb->insert( 'wp_usermapping', array("nopuid" => $nopeuid, "wpuid" => $wpuid ));
		echo "User Mapped successfully";
}
else
{
	
	$wpdb->insert( 'wp_usermapping', array("nopuid" => $nopeuid, "wpuid" => $wpuid ));
		echo "User Mapped successfully";
}
?>