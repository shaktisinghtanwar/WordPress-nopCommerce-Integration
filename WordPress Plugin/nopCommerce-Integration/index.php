<?php
/*
Plugin Name: nopCommerce Integration
Plugin URL: https://github.com/shaktisinghtanwar/WordPress-nopCommerce-Integration
Description: Integrate nopCommerce (a leading eCommerce platform) with the CMS capabilities of WordPress for your business. An easy way to add shopping cart to your WordPress site. Get products, categories, product search, user / customer data sync, shopping cart and order information from your nopCommerce store site.
Version: 1.0
Author: Striving Programmers and Techpro
Author URL: http://www.strivingprogrammers.com/overview-of-wordpress-and-nopcommerce-integration
 */

//error_reporting(0); 
global $wpdb;

$tblnamep = $wpdb->prefix.'apisettings';
	$result=$wpdb->get_results("select * from ".$tblnamep." where id='1'");
		$rg_enb=$result[0]->registration_enable;	
		if($rg_enb == "1"){
include_once 'register.php';
		}
function add_stylesheet_to_head() { 	
	echo "<link rel='stylesheet' href='".plugin_dir_url( __FILE__ )."style.css'>";	
	echo "<link rel='stylesheet' href='".plugin_dir_url( __FILE__ )."stylenew.css'>";	
}
 
add_action( 'wp_head', 'add_stylesheet_to_head' ); 
function hook_dirplugin() {
?>
<script>
function createCookie(name, value, days) {
    var expires;

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
	document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}

</script>

<?php
	global $wpdb;	
	$rs=$wpdb->get_results("select role_ids,api_url from ".$wpdb->prefix.'apisettings');
	
	$url = $rs[0]->api_url;
	
$wpuid = trim(get_current_user_id());
$result=$wpdb->get_results("select nopuid from wp_usermapping where wpuid=$wpuid");

$headers=get_headers($url);
 
$newheader=explode(';',$headers[4]);
$cookiesetup=explode(':',$newheader[0]);
$ncookie=explode('=',$cookiesetup[1]);

$cookie_name = "Nop.customer";
$cookie_value = $ncookie[1];
$ck =$_COOKIE;
if(!empty($ck["Nop_customer"])){
 
}
else
{
	//echo phpinfo();die;
	//$tm=time()+3600;
	?><script>
createCookie("<?php echo $cookie_name; ?>","<?php echo $cookie_value; ?>",20);
</script>

<?php

}
if(count($result)>0)
{
$current_nop_user = $result[0]->nopuid;
?>
<script>
createCookie("nopmeid","<?php echo $current_nop_user; ?>",20);
</script>
<?php
}
else
{
	$current_nop_user ='000';
	?>
	<script>
createCookie("nopmeid","000",20);
</script>

	<?php
}
	
    ?>
	
<div id="bar-notification" class="bar-notification success" style="display: none; line-height:8px;background:#4bb07a;position:fixed;left:0;top:0;width:100%;height:40px;color:#fff;z-index:100000;padding-left:10px;"><p class="content"><span>The product has been added to your shopping cart</span></div>
        <script>
            var cpurl="<?php echo plugin_dir_url( __FILE__ ) ?>";
			var myapurl="<?php echo $rs[0]->api_url; ?>";
		
        </script>
    <?php
}
add_action('wp_head', 'hook_dirplugin');

function admin_default_page() {
if ($_COOKIE['order']=='order')
{

//unset( $_COOKIE['order'] );
//setcookie( 'order', '', time() - ( 15 * 60 ) );
 
  return get_site_url().'/orders';
}
else
{


 return get_site_url().'/wp-admin/profile.php';
}
}
add_filter('login_redirect', 'admin_default_page');


function addtoprofile()
{

	global $wpdb;
		$rs=$wpdb->get_results("select role_ids,api_url,registration_enable from ".$wpdb->prefix.'apisettings');
$wpid = get_current_user_id();
$nopuid=$wpdb->get_results("select * from wp_usermapping where wpuid=".$wpid);
	?>
	<script>
	 var cpurl = "<?php echo plugin_dir_url( __FILE__ ) ?>";
			var myapurl = "<?php echo $rs[0]->api_url; ?>";
			var nopusrid = "<?php echo $nopuid[0]->nopuid; ?>";
			var enablereg = "<?php echo $rs[0]->registration_enable; ?>";
			</script>
	<?php
}
add_action( 'profile_personal_options', 'addtoprofile' ); 
function searchform( $att)
{
	echo '
	
	<style>
#loader {
  width: 50px;
    height: 40px;
    text-align: center;
    font-size: 10px;
    position: absolute;
    left: 0;
    right: 0;
    margin: auto;
    margin-top: 30%;
	z-index:10000;
}

#loader > div {
  background-color: #333;
  height: 100%;
  width: 6px;
  display: inline-block;
  
  -webkit-animation: sk-stretchdelay 1.2s infinite ease-in-out;
  animation: sk-stretchdelay 1.2s infinite ease-in-out;
}

#loader .rect2 {
  -webkit-animation-delay: -1.1s;
  animation-delay: -1.1s;
}

#loader .rect3 {
  -webkit-animation-delay: -1.0s;
  animation-delay: -1.0s;
}

#loader .rect4 {
  -webkit-animation-delay: -0.9s;
  animation-delay: -0.9s;
}

#loader .rect5 {
  -webkit-animation-delay: -0.8s;
  animation-delay: -0.8s;
}

@-webkit-keyframes sk-stretchdelay {
  0%, 40%, 100% { -webkit-transform: scaleY(0.4) }  
  20% { -webkit-transform: scaleY(1.0) }
}

@keyframes sk-stretchdelay {
  0%, 40%, 100% { 
    transform: scaleY(0.4);
    -webkit-transform: scaleY(0.4);
  }  20% { 
    transform: scaleY(1.0);
    -webkit-transform: scaleY(1.0);
  }
}
</style>
<div id="loader" style="display:block;"> <div class="rect1"></div>
  <div class="rect2"></div>
  <div class="rect3"></div>
  <div class="rect4"></div>
  <div class="rect5"></div></div>

	
	';
	if($att['id']=="")
	{
	echo '<div><form id="json_search_form" method="GET" action = "'.$SERVER["HTTP_HOST"].'//'.$_SERVER["SERVER_NAME"].'/search"><input type="text" name="q" id="search_form_input" style="width:70%;background:#fff;height:40px;vertical-align: top;"><input type="submit"  value="Search" class="button-1 search-box-button"></form><div class="productsearch"></div></div>';
	}
	else
	{
		echo '<div><form id="json_search_form" method="GET" action = "'.$SERVER["HTTP_HOST"].'//'.$_SERVER["SERVER_NAME"].'/search"><input type="text" name="q" id="search_form_input" style="width:70%;background:#fff;height:40px;vertical-align: top;"><input type="hidden" name="attid" value="'.$att["id"].'"><input type="submit"  value="Search" class="button-1 search-box-button"></form><div class="productsearch"></div></div>';
	}
}
add_shortcode("NOP_Search_Form", "searchform");

function searchformside( $att)
{
	
	if($att['id']=="")
	{
		$formside = '<form id="search_product" method="GET" action = "'.$SERVER["HTTP_HOST"].'//'.$_SERVER["SERVER_NAME"].'/search"><input type="text" placeholder="Enter keyword for search" id="search_form_input" name="q"  style="width:70%;"><input type="submit"  value="Search" class="button-1" style="height:36px;"></form>';
	}
	else
	{
	$formside = '<form id="search_product" method="GET" action = "'.$SERVER["HTTP_HOST"].'//'.$_SERVER["SERVER_NAME"].'/search"><input type="text" placeholder="Enter keyword for search" id="search_form_input" name="q"  style="width:70%;"><input type="hidden" name="attid" value="'.$att["id"].'"><input type="submit"  value="Search" class="button-1" style="height:36px;"></form>';
	}
	return $formside;
}
add_filter('widget_text', 'do_shortcode'); 
add_shortcode("NOP_Search_Form_Sidebar", "searchformside");
// Adding the custom js file and the jquery file for ajax call  
function wpb_adding_scripts() {
wp_register_script('jquery-3.2.1.min.js', plugins_url('jquery-3.2.1.min.js', __FILE__), array('jquery'),'3.2.1', true);
wp_enqueue_script('jquery-3.2.1.min.js');
wp_register_script('ajax.js', plugins_url('ajax.js', __FILE__), array('jquery'),'1.1', true);
wp_enqueue_script('ajax.js');
}
 
// this hook adding the js and ajax file in the head section on Frontend
add_action( 'wp_enqueue_scripts', 'wpb_adding_scripts' );


// this hook adding the js and ajax file in the wp-admin head section
add_action('admin_head', 'wpb_adding_scripts');


// function for fetching the configuration details of the plugin 
function api_config()
{
	global $wpdb;	
	$rs=$wpdb->get_results("select role_ids,api_url from ".$wpdb->prefix.'apisettings');
	$result=json_encode($rs);
	return $result;
}




// this function is used to display the form  in the frontend
 function registration_form( $username, $password, $email, $first_name, $last_name) {
  	
	
	// getting the api url from the database
	$api_config=api_config();
	$response_url=json_decode($api_config);
	$api_url=$response_url[0]->api_url;
	$role_ids=$response_url[0]->role_ids;
	
	
	
	if(is_admin())
	{
	 $class='theform';
	 //$heading='Add New User Registration'; 
	 $heading='<h1 id="add-new-user">Add New User Registration</h1>';
	 $email_field='email-custom-form-field';
	 $submit_class='admin-register';	
	 $aduserclass="frmuser";
	}
	else
	{
	 $class='myform';
     $submit_class='register';	 
	 $aduserclass="frmadmin";
	}
	
	echo '
    <style>
    div {
        margin-bottom:2px;
    }
     
    input{
        margin-bottom:4px;
    }
	
	.myform{   
	top: 37px;
    text-align: left;
    border: 1px solid #ccc;
    padding: 10px 10px 10px 10px;
    border-radius: 13px;
    right: 386px;
	}
	
	.error{
	color: red;
    font-size: 12px;
    position: relative
	}
	
	.theform{   
	position:relative;
	top: 37px;
    text-align: left;
    border: 1px solid #ccc;
    padding: 10px 10px 10px 10px;
    border-radius: 13px;
   	width: 40%;
	}
	
	.error{
	color: red;
    font-size: 12px;
    position: relative
	}
	
	.custom-form-field
	{
    width: 25em;
    padding: 8px 0px 8px 7px;
	}
	
	.email-custom-form-field
	{
	 width: 25em;
     padding: 8px 0px 8px 7px;
	 margin-left: 22px;
	}
	#registerform #user_login, #registerform #user_email, #registerform label[for="user_login"], #registerform label[for="user_email"], #wp-submit
	{
		display:none;
	}
	.login input[type=password] {
    font-size: 24px;
    width: 100%;
    padding: 3px;
    margin: 2px 6px 16px 0;
	}
	</style>
    ';	
	
	
	
	?>
	
	 <script>
            var cpurl="<?php echo plugin_dir_url( __FILE__ ) ?>";
			var myapurl="<?php echo $api_url; ?>";
		
        </script>
	<?php
	echo $heading;
	echo '<script src="'.plugin_dir_url( __FILE__ ).'jquery-3.2.1.min.js"></script><script src="'.plugin_dir_url( __FILE__ ).'js/custom-script.js"></script>

    <form id="reg_form" style="border: 1px solid#ccc; padding: 35px; margin: 0; width: 32%; border-radius: 13px;" action="'.get_site_url() .''. $_SERVER['REQUEST_URI'] . '" method="post" class="'.$class.' '.$aduserclass.'">
	<input type="hidden" id="url" name="url" value="'.$api_url.'">
	<input type="hidden" id="userlast" name="userlast" value="">
	<input type="hidden" id="wpurl-main" name="wpurl-main" value="'.plugin_dir_url( __FILE__ ).'">
	<input type="hidden" id="role_id" name="roleid" value="['.$role_ids.']">
	<input type="hidden" id="nopc_id" name="roleid" value="' . ( isset( $_POST['nopc_id'] ) ? $username : null ) . '">
	<div class="cct-1">
	<div class="error_msg_custom" style="display:none;color:red;"></div>	
    <label style="margin-right:21px;line-height:50px;" for="username">Username <strong>*</strong></label>
    <input type="text" class="custom-form-field" name="username" id="username" value="' . ( isset( $_POST['username'] ) ? $username : null ) . '">
	</div>
    
    <div class="cct-1">
    <label style="margin-right:24px;line-height:50px;" for="password">Password <strong>*</strong></label>
    <input type="password" class="custom-form-field" name="password" id="password" value="' . ( isset( $_POST['password'] ) ? $password : null ) . '">    
	</div>	 
    
	<div class="cct-1">
    <label style="margin-right:26px;line-height:50px;" for="firstname">First Name</label>
    <input type="text" class="custom-form-field" name="fname" id="fname" value="' . ( isset( $_POST['fname']) ? $first_name : null ) . '">
    </div>
     
    <div class="cct-1">
    <label style="margin-right:27px;line-height:50px;" for="website">Last Name</label>
    <input type="text" class="custom-form-field" name="lname" id="lname" value="' . ( isset( $_POST['lname']) ? $last_name : null ) . '">
    </div>    
    <div class="cct-1">
    <label style="margin-right:28px;line-height:50px;" for="email">Email <strong>*</strong></label>
    <input type="text" class="'.$email_field.'" name="email" id="email" value="' . ( isset( $_POST['email']) ? $email : null ) . '">
    </div>    
    
    <div style="text-align:center;"><input style="width: 110px; line-height: 30px; height: 35px; margin-top: 10px; margin-bottom: 18px; font-size: 15px;" type="button" name="submit" class="button button-primary '. $submit_class .'" value="Register"/></div>
    </form>
    ';
}

// function for validation of  Custom Registration form
function registration_validation( $username, $password,$email,$first_name, $last_name)  {
global $reg_errors;

$reg_errors = new WP_Error;

 if ( empty( $username ) || empty( $password ) || empty( $email ) ) {
    $reg_errors->add('field', 'Required form field is missing');
 }	 
   
   if ( 4 > strlen( $username ) ) {
    $reg_errors->add( 'username_length', 'Username too short. At least 4 characters is required' );
 }
   if( username_exists( $username ) ){
    $reg_errors->add('user_name', 'Sorry, that username already exists!');
 }

 if ( ! validate_username( $username ) ) {
    $reg_errors->add( 'username_invalid', 'Sorry, the username you entered is not valid' );
}
if ( 5 > strlen( $password ) ) {
        $reg_errors->add( 'password', 'Password length must be greater than 5' );
    }
	
if ( !is_email( $email ) ) {
    $reg_errors->add( 'email_invalid', 'Email is not valid' );
}
 if ( email_exists( $email ) ) {
    $reg_errors->add( 'email', 'Email Already in use' );
}
if ( is_wp_error( $reg_errors ) ) {
 
 
    foreach ( $reg_errors->get_error_messages() as $error ) {
        echo '<div class="error">';
        echo '<strong>ERROR</strong>:';
        echo $error . '<br/>';
        echo '</div>';
         
    }
}
}

function complete_registration() {
    global $reg_errors, $username, $password, $email, $first_name, $last_name, $nopc_id;
    if ( 1 > count( $reg_errors->get_error_messages() ) ) {
        $userdata = array(
        'user_login'    =>   $username,
        'user_email'    =>   $email,
        'user_pass'     =>   $password,      
        'first_name'    =>   $first_name,
        'last_name'     =>   $last_name,        
        );
		
		echo $nopc_id;
       
	   $user = wp_insert_user($userdata);  
		
		
		// sending the post variable in the api using posting
			
			
		echo 'Registration complete.';  	


		
    }
}

function custom_registration_function() {
    if ( isset($_POST['submit'] ) ) {
        registration_validation(
        $_POST['username'],
        $_POST['password'],
        $_POST['email'],        
        $_POST['fname'],
        $_POST['lname']      
        );
         
        // sanitize user form input
        global $username, $password, $email, $first_name, $last_name, $nopc_id;
        $username   =   sanitize_user( $_POST['username'] );
        $password   =   esc_attr( $_POST['password'] );
        $email      =   sanitize_email( $_POST['email'] );        
        $first_name =   sanitize_text_field( $_POST['fname'] );
        $last_name  =   sanitize_text_field( $_POST['lname'] );
		$nopc_id =   sanitize_text_field( $_POST['nopc_id'] );
        
 
        // This complete registration is used to save the data into wp users data table
        complete_registration(
        $username,
        $password,
        $email,        
        $first_name,
        $last_name        
        );		
    } 
	
	
	// this function will show you the form in the frontend 
    registration_form(
        $username,
        $password,
        $email,        
        $first_name,
        $last_name       
        );
}

// Register a new shortcode: [cr_custom_registration]
add_shortcode( 'cr_custom_registration', 'custom_registration_shortcode' );

// The callback function that will replace [hook]
function custom_registration_shortcode() {
    ob_start();
    custom_registration_function();
    return ob_get_clean();
}
//Add Short code for new address
add_shortcode( 'nop_add_new_address', 'add_new_address' );
//Add New Address 
function add_new_address() {
  	
	
	// getting the api url from the database
	$api_config=api_config();
	$response_url=json_decode($api_config);
	$api_url=$response_url[0]->api_url;
	$role_ids=$response_url[0]->role_ids;
	
	
	
	if(is_admin())
	{
	 $class='theform';
	 //$heading='Add New User Registration'; 
	 $heading='<h1 id="add-new-user">Add New User Registration</h1>';
	 $email_field='email-custom-form-field';
	 $submit_class='admin-register';	
	 $aduserclass="frmuser";
	}
	else
	{
	 $class='myform';
     $submit_class='register';	 
	 $aduserclass="frmadmin";
	}
	
echo '
    <style>
    div {
        margin-bottom:2px;
    }
    input{
        margin-bottom:4px;
    }
    .myform{   
            top: 37px;
    text-align: left;
    border: 1px solid #ccc;
    padding: 10px 10px 10px 10px;
    border-radius: 13px;
    right: 386px;
	}
	
	.error{
	color: red;
    font-size: 12px;
    position: relative
	}
	
	.theform{   
	position:relative;
	top: 37px;
    text-align: left;
    border: 1px solid #ccc;
    padding: 10px 10px 10px 10px;
    border-radius: 13px;
   	width: 40%;
	}
	
	.error{
	color: red;
    font-size: 12px;
    position: relative
	}
	
	.custom-form-field
	{
    width: 25em;
    padding: 8px 0px 8px 7px;
	}
	
	.email-custom-form-field
	{
	 width: 25em;
     padding: 8px 0px 8px 7px;
	 margin-left: 22px;
	}
	#registerform #user_login, #registerform #user_email, #registerform label[for="user_login"], #registerform label[for="user_email"], #wp-submit
	{
		display:none;
	}
	.login input[type=password] {
    font-size: 24px;
    width: 100%;
    padding: 3px;
    margin: 2px 6px 16px 0;
	}
	</style>
    ';
?>
	
	 <script>
            var cpurl="<?php echo plugin_dir_url( __FILE__ ) ?>";
			var myapurl="<?php echo $api_url; ?>";
		
        </script>
	<?php
	echo $heading;
	echo '<script src="'.plugin_dir_url( __FILE__ ).'jquery-3.2.1.min.js"></script><script src="'.plugin_dir_url( __FILE__ ).'js/custom-script.js"></script>

    <form id="reg_form" style="border: 1px solid#ccc; padding: 35px; margin: 0; width: 50%; border-radius: 13px;" action="'.get_site_url() .''. $_SERVER['REQUEST_URI'] . '" method="post" class="'.$class.' '.$aduserclass.'">
	<input type="hidden" id="url" name="url" value="'.$api_url.'">
	<input type="hidden" id="userlast" name="userlast" value="">
	<input type="hidden" id="wpurl-main" name="wpurl-main" value="'.plugin_dir_url( __FILE__ ).'">
	<input type="hidden" id="role_id" name="roleid" value="['.$role_ids.']">
	<input type="hidden" id="nopc_id" name="roleid" value="' . ( isset( $_POST['nopc_id'] ) ? $username : null ) . '">
	<div class="cct-1">
	<div class="error_msg_custom" style="display:none;color:red;"></div>	
    <label style="margin-right:21px;line-height:50px;" for="address_firstname">First Name<strong>*</strong></label>
    <input type="text" class="custom-form-field" name="address_firstname" id="address_firstname" value="">
	</div>
    
    <div class="cct-1">
    <label style="margin-right:24px;line-height:50px;" for="address_lastname">Last Name<strong>*</strong></label>
    <input type="text" class="custom-form-field" name="address_lastname" id="address_lastname" value="">    
	</div>	 
    
	<div class="cct-1">
    <label style="margin-right:26px;line-height:50px;" for="address_email">Email Id</label>
    <input type="text" class="custom-form-field" name="address_email" id="address_email" value="">
    </div>
     
    <div class="cct-1">
    <label style="margin-right:27px;line-height:50px;" for="address_company">Company</label>
    <input type="text" class="custom-form-field" name="address_company" id="address_company" value="">
    </div>    
    <div class="cct-1">
    <label style="margin-right:28px;line-height:50px;" for="address_country">Country<strong>*</strong></label>
    <input type="text" class="'.$email_field.'" name="address_country" id="address_country" value="">
    </div>   
<div class="cct-1">
    <label style="margin-right:28px;line-height:50px;" for="address_state">State<strong>*</strong></label>
    <input type="text" class="'.$email_field.'" name="address_state" id="address_state" value="">
    </div>  
<div class="cct-1">
    <label style="margin-right:28px;line-height:50px;" for="address_city">City<strong>*</strong></label>
    <input type="text" class="'.$email_field.'" name="address_city" id="address_city" value="">
    </div>
<div class="cct-1">
    <label style="margin-right:28px;line-height:50px;" for="address_address1">Address 1<strong>*</strong></label>
    <input type="text" class="'.$email_field.'" name="address_address1" id="address_address1" value="">
    </div>
<div class="cct-1">
    <label style="margin-right:28px;line-height:50px;" for="address_address1">Address 2<strong>*</strong></label>
    <input type="text" class="'.$email_field.'" name="address_address2" id="address_address2" value="">
    </div>
<div class="cct-1">
    <label style="margin-right:28px;line-height:50px;" for="address_zipcode">Zip Code<strong>*</strong></label>
    <input type="text" class="'.$email_field.'" name="address_zipcode" id="address_zipcode" value="">
    </div> 
<div class="cct-1">
    <label style="margin-right:28px;line-height:50px;" for="address_faxno">Fax No<strong>*</strong></label>
    <input type="text" class="'.$email_field.'" name="address_faxno" id="address_faxno" value="">
    </div>    
    
    <div style="text-align:center;"><input style="width: 110px; line-height: 0; height: 35px; margin-top: 10px; margin-bottom: 18px; font-size: 15px;" type="button" name="submit" class="button button-primary '. $submit_class .'" value="Save"/></div>
    </form>
    ';
	
}

// creating the nop menu in the admin section 

add_action('admin_menu','nop_menu');


function create_apiplugin_table()
{
 global $wpdb;
 $table_name =  $wpdb->prefix.'apisettings';
 $charset_collate = $wpdb->get_charset_collate();  
 $sql="CREATE TABLE ".$table_name." (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `role_ids` varchar(200) NOT NULL,
  `api_url` varchar(200) NOT NULL,
  `registration_enable` varchar(200) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql ); 
}
function create_oauthplugin_table()
{
 global $wpdb;
 $table_name =  $wpdb->prefix.'nopoauthsettings';
 $charset_collate = $wpdb->get_charset_collate();  
 $sql="CREATE TABLE ".$table_name." (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(200) NOT NULL,
  `client_secret` varchar(200) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql ); 
}

function api_settings()
{

	global $wpdb;	
	create_apiplugin_table();	
	$table_name =  $wpdb->prefix.'apisettings';	
	$current=$_GET['tab'];
    $page=$_GET['page'];	
	echo $heading='<h1 id="add-new-user">API Settings</h1>';
    $tabs = array( 'general-settings' => 'General Settings','api-configuration' => 'Api Configuration' );
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach($tabs as $tab => $name ){		
        $class = ($tab == $current) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab $class' href='?page=api_settings&tab=$tab'>$name</a>";
    }
    echo '</h2>';
	
	
	if($current=='api-configuration')
	{
		// fetching the data from the database if any 
		$result=$wpdb->get_results("select api_url from ".$table_name. "  where id='1'");
		$api_url=$result[0]->api_url;	
		 echo '<h4>Configuration for API Url </h4>';
		 echo '<form style="background: #fff; width: 25%; padding: 15px;" action="' . $_SERVER['REQUEST_URI'] . '" method="post" class="'.$class.'">
		 <input type="hidden" name="type" value="api_url">
		 <input type="textbox" name="api_url" value="'.$api_url.'" style="width: 202px;">
		 <input type="submit" name="submit" class="button button-primary" value="Save">
		 </form>';
		 
		 if($current=='api-configuration' && $_POST['type']=='api_url')
		 {
			 // checking for existing record in the database 
			 
			 $row_count = $wpdb->get_var("SELECT COUNT(id) FROM ".$table_name."");
              
			 if($row_count!=0)
			 {
				$wpdb->update($table_name,array('api_url'=>$_POST['api_url']),array('id'=>'1')); 	
                echo '<script>window.location.reload();</script>';                			
			 }
			 else
			 {		
				$wpdb->insert($table_name,array('api_url'=>$_POST['api_url']));				
				echo '<script>window.location.reload();</script>';
			 }
					
         }
		 
		 
		 
	}	
	else 
	{				
		// fetching the data from the database if any 
		$result=$wpdb->get_results("select role_ids,registration_enable from ".$table_name. "  where id='1'");
		$role_id=$result[0]->role_ids;		
		
		$regenb=$result[0]->registration_enable;
		$ischecked = "";
		if($regenb == "1"){
			$ischecked = "checked";
			?>
			<script>
			jQuery(document).ready(function(){				 
				jQuery('#box_role').show();
			})
				
			</script>
			<?php 
		}
 	     echo '<h4>Add the APi Url in the Textbox Below</h4>';
		 echo '<form style="background: #fff; width: 25%; padding: 15px;" action="' . $_SERVER['REQUEST_URI'] . '" method="post" class="'.$class.'">
		 <input type="hidden" name="type" value="roleid">
		 <input type="checkbox" '.$ischecked.' id="nopenable" name="nopenable" value="'.$regenb.'"><label>Enable NOP Registration</label><br><br>
		<span id="box_role" style="display:none;"> <input type="textbox" name="role_ids" placeholder="Role id with comma seperated" value="'.$role_id.'" width="202px;">
		</span> <input type="submit" name="submit" class="button button-primary" value="Save">
		 </form>';
		 
		 
		 if($current=='general-settings' && $_POST['type']=='roleid')
		 {
	
			
			 // checking for existing record in the database 
			 
			 $row_count = $wpdb->get_var("SELECT COUNT(id) FROM ".$table_name."");
              
			 if($row_count!=0)
			 {
				 
				// print_r($_POST['nopenable']);die;
				$wpdb->update($wpdb->prefix.'apisettings',array('role_ids'=>$_POST['role_ids'],'registration_enable'=>$_POST['nopenable']), array('id'=>'1')); 	
                echo '<script>window.location.reload();</script>';                			
			 }
			 else
			 {		
				$wpdb->insert($wpdb->prefix.'apisettings',array('role_ids'=>$_POST['role_ids'],'registration_enable'=>$_POST['nopenable']));				
				echo '<script>window.location.reload();</script>';
			 }
					
         }
		 
	}
	
}
function oauth_settings()
{
	
	global $wpdb;	
	create_oauthplugin_table();	
	$table_name =  $wpdb->prefix.'nopoauthsettings';
	$result=$wpdb->get_results("select * from ".$table_name. "  where id='1'");
	$client_id = $result[0]->client_id;	
	$client_secret = $result[0]->client_secret;	
	echo '<h1 id="add-new-user">Oauth Client Settings</h1>';
    echo "<form action='" . $_SERVER['REQUEST_URI'] . "' method='post'><table class='form-table' style='background:#fff;border:20px solid #fff;width:80%;'><tbody><tr><th scope='row'><label>Client ID</label></th>	<td><input type='hidden' name='type' value='nopoauth'><input value='".$client_id."' name='client_id' id='client_id' class='regular-text' type='text'></td></tr><tr><th scope='row'><label>Client Secret Key</label></th>	<td><input value='".$client_secret."' name='client_secret' id='client_secret' class='regular-text' type='text'></td></tr><tr><th scope='row'><label>Callback URL</label></th>	<td><input value='".plugin_dir_url( __FILE__ )."googleoauth2/oauth2callback/index.php' name='callback_url' id='callback_url' class='regular-text' type='text'></td></tr><tr colspan='2'><td><input type='submit' value='Save' class='button button-primary' style='width: 110px; line-height: 30px; height: 35px; margin-top: 10px; margin-bottom: 18px; font-size: 15px;'> </td></tr></tbody></table></form>";

if($_POST['type']=='nopoauth')
		 {
			 // checking for existing record in the database 
			 
			 $row_count = $wpdb->get_var("SELECT COUNT(id) FROM ".$table_name."");
              
			 if($row_count!=0)
			 {
				$wpdb->update($table_name,array('client_id'=>$_POST['client_id'],'client_secret'=>$_POST['client_secret']),array('id'=>'1')); 	
                echo '<script>window.location.reload();</script>';                			
			 }
			 else
			 {		
				$wpdb->insert($table_name,array('client_id'=>$_POST['client_id'],'client_secret'=>$_POST['client_secret']));				
				echo '<script>window.location.reload();</script>';
			 }
					
         }
		 	
	
}

function nop_menu()
{
	add_menu_page( 'My Plugin Settings Page', 'Nop Integration','manage_options','register','','');
	add_submenu_page( 'register','User registration', 'Register User', 'manage_options','register','custom_registration_function');  
    add_submenu_page( 'register','User Api', 'API Settings ','manage_options','api_settings','api_settings'); 	
	add_submenu_page( 'register','Oauth Settings', 'Oauth Settings ','manage_options','oauth_settings','oauth_settings'); 	
}




/** display product categories in tree view **/

function treeview()
{
	include_once(plugin_dir_path( __FILE__ ) .'api/getdata.php');
	$ctlnm = "";
	// getting the api url from the database
	$api_config=api_config();
	$response_url=json_decode($api_config);
	$api_url=$response_url[0]->api_url;
	
	
	
	//$response = wp_remote_get($api_url.'/api/categories');
	$appurli = $api_url.'/api/categories';
	$response = getdata($appurli);
	//$body = wp_remote_retrieve_body( $response );
	$result=json_decode($response);	
	$rows=$result->categories;
	$total_rows=count($rows);	
	$cat_link=get_page_link().'/?cat=';
	//print_r($rows);die;
	$apo=array();
	for($jj=0;$jj<$total_rows;$jj++)
	{
		array_push($apo,$rows[$jj]->parent_category_id);
		
	}
	
	
  $ctlnm .= '<div><ul class="category">';
  
  for($i=0;$i<$total_rows;$i++)
  {	    
	  if($rows[$i]->parent_category_id=='0' && $rows[$i]->published=='1')
	  {		 
		  //echo '<li><a href='.home_url().'/products/?'.strtolower($rows[$i]->id).'-'.$rows[$i]->se_name.'>'.$rows[$i]->name.'</a>';
        if (!in_array($rows[$i]->id, $apo)) 
		{
				$ctlnm .= '<li><a  class="catmain" href='.home_url().'/products/?'.$rows[$i]->se_name .'/'.strtolower($rows[$i]->id).'-'.$rows[$i]->se_name.'>'.$rows[$i]->name.'</a>';		  
		}
		else
		{	

			$ctlnm .= '<li><a  class="catmain" href='.home_url().'/products/?'.strtolower($rows[$i]->id).'-'.$rows[$i]->se_name.'>'.$rows[$i]->name.'</a>';		  
		}
	  }
	  else if($rows[$i]->parent_category_id!='0' && $rows[$i]->published=='1')
	  {
		  $catid=$rows[$i]->parent_category_id;
		  $ctlnm .= '<ul class="product" style="display:none;">';
		  if($rows[$i]->parent_category_id!='0' && $rows[$i]->published=='1')
		  {
           //echo '<li><a href='.home_url().'/products/?'.$catid.'-'.$rows[$i]->se_name.'/Product-'.$rows[$i]->id.'-'.$rows[$i]->se_name.'>'.$rows[$i]->name.'</a></li>';
           $ctlnm .= '<li><a href='.home_url().'/products/?'.$catid.'-'.$rows[$i]->se_name.'/'.$rows[$i]->id.'-'.$rows[$i]->se_name.'>'.$rows[$i]->name.'</a></li>';
          
          }
		  $ctlnm .= '</ul>';
	  }
  }  
  $ctlnm .= '</li></ul></div>';  
  return $ctlnm;
}

// register a new shortcode:[display_categories] 
 add_shortcode('display_categories_tree','treeview');

/** display product categories in tree view ends here **/
 
 
 
 
 
/** display categories using parameter **/
// register shortcode with parameter

function fetch_categories( $atts ) {    
include_once(plugin_dir_path( __FILE__ ) .'api/getdata.php');

// getting the api url from the database
$api_config=api_config();
$response_url=json_decode($api_config);
$api_url=$response_url[0]->api_url;

$path=basename($_SERVER['REQUEST_URI']);
$exp=explode('-',$path);


/*
$type=$exp[0];
$id=$exp[1]; 
$se_name=$exp[2];
*/


$type=$exp[0];
$get_id=explode("?",$exp[0]); 
$id=$get_id[1];
$se_name=$exp[1];

?>

<?php
if(!empty($id) && $type!='Product')
{
// fetching the categories name from the APi on the bases of ID 
//$cat_response=wp_remote_get($api_url.'/api/categories/'.$id);
$appurli = $api_url.'/api/categories/'.$id;
$cat_response = getdata($appurli);
//$cat_body=wp_remote_retrieve_body($cat_response);
$cat_result=json_decode($cat_response);
$cat_name=$cat_result->categories[0]->name;

?>

<div class="page category-page">
<style>
#loader {
  width: 50px;
    height: 40px;
    text-align: center;
    font-size: 10px;
    position: absolute;
    left: 0;
    right: 0;
    margin: auto;
    margin-top: 30%;
	z-index:10000;
}

#loader > div {
  background-color: #333;
  height: 100%;
  width: 6px;
  display: inline-block;
  
  -webkit-animation: sk-stretchdelay 1.2s infinite ease-in-out;
  animation: sk-stretchdelay 1.2s infinite ease-in-out;
}

#loader .rect2 {
  -webkit-animation-delay: -1.1s;
  animation-delay: -1.1s;
}

#loader .rect3 {
  -webkit-animation-delay: -1.0s;
  animation-delay: -1.0s;
}

#loader .rect4 {
  -webkit-animation-delay: -0.9s;
  animation-delay: -0.9s;
}

#loader .rect5 {
  -webkit-animation-delay: -0.8s;
  animation-delay: -0.8s;
}

@-webkit-keyframes sk-stretchdelay {
  0%, 40%, 100% { -webkit-transform: scaleY(0.4) }  
  20% { -webkit-transform: scaleY(1.0) }
}

@keyframes sk-stretchdelay {
  0%, 40%, 100% { 
    transform: scaleY(0.4);
    -webkit-transform: scaleY(0.4);
  }  20% { 
    transform: scaleY(1.0);
    -webkit-transform: scaleY(1.0);
  }
}
</style>
<div id="loader" style="display:block;"> <div class="rect1"></div>
  <div class="rect2"></div>
  <div class="rect3"></div>
  <div class="rect4"></div>
  <div class="rect5"></div></div>
    <div class="page-title">
       <h1><?php echo $cat_name; ?></h1>
    </div>

<div class="page-body">	
 <div class="category-grid sub-category-grid">
<div class="item-grid">

	
<?php
        $catappuri = $api_url.'/api/categories'; 
		$response = getdata($catappuri);
		//$body = wp_remote_retrieve_body( $response );
		$result=json_decode($response);	
		$rows=$result->categories;
		$total_rows=count($rows);    

     /*   echo '<pre>';
		  print_r($rows);
		  echo '</pre>';
		die;*/
?>

<?php
	       for($i=0;$i<$total_rows;$i++)
			  {
			?>
			
			<?php
				if($rows[$i]->parent_category_id==$id)
					{		
			
?>

<div class="item-box">
  <div class="sub-category-item">
	<h2 class="title techp1">
		  <a href="<?php echo get_page_link().'?'.$id.'-'.$se_name.'/'.$rows[$i]->id.'-'.$rows[$i]->se_name;?>"><?php echo $rows[$i]->name;?></a>                            
	</h2>
	 <div class="picture">
                           <a href="<?php echo get_page_link().'?'.$id.'-'.$se_name.'/'.$rows[$i]->id.'-'.$rows[$i]->se_name;?>"><img src="<?php if(count($rows[$i]->image)!=0) {echo $rows[$i]->image->src;} else { echo plugin_dir_url( __FILE__ ).'images/default-image_550.png'; }?>"></a>
     </div>
   </div>
</div>

<?php
	}
  }
?>



</div>
</div>
</div>
</div>
<?php	
}
else 
{	

$path=basename($_SERVER['REQUEST_URI']);
$exp=explode('-',$path);
	  
/*
$type=$exp[0];
$subcate=$exp[1]; 
$se_name=$exp[2];
*/

$get_id=explode("-",$exp[0]); 
$subcate=$get_id[0]; 
$se_name=$exp[1];

//echo $subcate=$exp[1];	
// fetching the categories name from the APi on the bases of ID 
$sbcatapuri = $api_url.'/api/categories/'.$subcate;
$subcat_response=getdata($sbcatapuri);
//$subcat_body=wp_remote_retrieve_body($subcat_response);
$subcat_result=json_decode($subcat_response);
$subcat_name=$subcat_result->categories[0]->name; 
$subcat_result->categories[0]->id;

$catprodmapuri = $api_url.'/api/product_category_mappings';
$product_mapping=getdata($catprodmapuri);
//$poduct_body=wp_remote_retrieve_body($product_mapping);
$product_map_result=json_decode($product_mapping);	
$product_map=$product_map_result->product_category_mappings;
$total_map_product_rows=count($product_map); 

?>	 
<div class="product-grid home-page-product-grid">
<style>
#loader {
  width: 50px;
    height: 40px;
    text-align: center;
    font-size: 10px;
    position: absolute;
    left: 0;
    right: 0;
    margin: auto;
    margin-top: 30%;
	z-index:10000;
}

#loader > div {
  background-color: #333;
  height: 100%;
  width: 6px;
  display: inline-block;
  
  -webkit-animation: sk-stretchdelay 1.2s infinite ease-in-out;
  animation: sk-stretchdelay 1.2s infinite ease-in-out;
}

#loader .rect2 {
  -webkit-animation-delay: -1.1s;
  animation-delay: -1.1s;
}

#loader .rect3 {
  -webkit-animation-delay: -1.0s;
  animation-delay: -1.0s;
}

#loader .rect4 {
  -webkit-animation-delay: -0.9s;
  animation-delay: -0.9s;
}

#loader .rect5 {
  -webkit-animation-delay: -0.8s;
  animation-delay: -0.8s;
}

@-webkit-keyframes sk-stretchdelay {
  0%, 40%, 100% { -webkit-transform: scaleY(0.4) }  
  20% { -webkit-transform: scaleY(1.0) }
}

@keyframes sk-stretchdelay {
  0%, 40%, 100% { 
    transform: scaleY(0.4);
    -webkit-transform: scaleY(0.4);
  }  20% { 
    transform: scaleY(1.0);
    -webkit-transform: scaleY(1.0);
  }
}
</style>
<div id="loader" style="display:block;"> <div class="rect1"></div>
  <div class="rect2"></div>
  <div class="rect3"></div>
  <div class="rect4"></div>
  <div class="rect5"></div></div>

    <div class="title">
        <strong><?php echo $subcat_name;?></strong>
    </div>
 <div class="item-grid">
       

	
<?php
	
for($p=0;$p<$total_map_product_rows;$p++)
{

if($product_map[$p]->category_id==$subcate)
{ 

// fetching the categories name for the product
$sbbctmpri = $api_url.'/api/categories/'.$subcate;
$cat_response=getdata($sbbctmpri);
//$cat_body=wp_remote_retrieve_body($cat_response);
$cat_result=json_decode($cat_response);
$cat_name=$cat_result->categories[0]->name;



$prmpnuri = $api_url.'/api/products/'.$product_map[$p]->product_id;
$response = getdata($prmpnuri);

//$body = wp_remote_retrieve_body( $response );
$result=json_decode($response);	
$rows=$result->products;
$total_rows=count($rows);  

//echo str_replace("","-",strtolower($rows[0]->name));
$text=strtolower($rows[0]->name);
$final = preg_replace('#[ -]+#', '-', $text);

if($rows[0]->published==1 && $rows[0]->visible_individually == 1)
{
	
?>
<div class="item-box">
  <div class="product-item" data-productid="1">
                <div class="picture">
			<a  class="product_link" href="<?php echo home_url().'/product-details/?pcat='.strtolower($cat_name).'&product='.$final.'&pid='.$product_map[$p]->product_id;?>" data-id='<?php echo $product_map[$p]->product_id;?>'><img src="<?php if(count($rows[0]->images)!=0) {echo $rows[0]->images[0]->src;} else { echo plugin_dir_url( __FILE__ ).'images/default-image_550.png'; }?>"></a><br>
	
</div>
</div>				
 <div class="details">
                   <h2 class="product-title techp1">
           <a href="<?php echo home_url().'/product-details/?pcat='.strtolower($cat_name).'&product='.$final.'&pid='.$product_map[$p]->product_id;?>"><?php echo $rows[0]->name;?>	</a>
        </h2>
  <div class="add-info">

                        <div class="prices">
                            <span class="price actual-price">$ <?php echo number_format($rows[0]->price,2);?></span>
                        </div>

                        <div class="buttons">

						<input type="button" value="Add to cart" class="addcartproduct button-2 product-box-add-to-cart-button" paid="<?php echo $product_map[$p]->product_id ?>" >                       

						</div>

                    </div>



</div>
</div>
<?php 

}
}

}
 
?>

</div>
<?php	  
  }
  return;
}


add_shortcode('NOP_categories', 'fetch_categories'); 
/** display categories using parameter ends here **/





/** function to display product details **/

function Display_products($atts)
{	 
include_once(plugin_dir_path( __FILE__ ) .'api/getdata.php');
// getting the api url from the database
$api_config=api_config();
$response_url=json_decode($api_config);
$api_url=$response_url[0]->api_url;



 $product_id=$_GET['pid']; 
 // fetching the product details on the bases of product id
$url=$api_url.'/api/products/'.$product_id;
$product_response=getdata($url);
//$product_body=wp_remote_retrieve_body($product_response);
$product_details=json_decode($product_response);
$product_attr=$product_details->products;
$img_count=count($product_attr[0]->images);

 
 /*echo '<pre>';
 print_r($product_details);
 echo '</pre>';*/
/** count the attributes of a products **/
$attributes=count($product_attr[0]->attributes);

?>

<div class="page product-details-page">
<style>
#loader {
  width: 50px;
    height: 40px;
    text-align: center;
    font-size: 10px;
    position: absolute;
    left: 0;
    right: 0;
    margin: auto;
    margin-top: 30%;
	z-index:10000;
}

#loader > div {
  background-color: #333;
  height: 100%;
  width: 6px;
  display: inline-block;
  
  -webkit-animation: sk-stretchdelay 1.2s infinite ease-in-out;
  animation: sk-stretchdelay 1.2s infinite ease-in-out;
}

#loader .rect2 {
  -webkit-animation-delay: -1.1s;
  animation-delay: -1.1s;
}

#loader .rect3 {
  -webkit-animation-delay: -1.0s;
  animation-delay: -1.0s;
}

#loader .rect4 {
  -webkit-animation-delay: -0.9s;
  animation-delay: -0.9s;
}

#loader .rect5 {
  -webkit-animation-delay: -0.8s;
  animation-delay: -0.8s;
}

@-webkit-keyframes sk-stretchdelay {
  0%, 40%, 100% { -webkit-transform: scaleY(0.4) }  
  20% { -webkit-transform: scaleY(1.0) }
}

@keyframes sk-stretchdelay {
  0%, 40%, 100% { 
    transform: scaleY(0.4);
    -webkit-transform: scaleY(0.4);
  }  20% { 
    transform: scaleY(1.0);
    -webkit-transform: scaleY(1.0);
  }
}
</style>
<div id="loader" style="display:block;"> <div class="rect1"></div>
  <div class="rect2"></div>
  <div class="rect3"></div>
  <div class="rect4"></div>
  <div class="rect5"></div></div>

    <div class="page-body">
     <form>
	 <div itemscope="" itemtype="">
                <div class="product-essential">
				
				  <div class="gallery">
                        <div class="picture">
                           <img id="mainwimg" src="<?php if(count($product_attr[0]->images[0])!=0) {  echo $product_attr[0]->images[0]->src; } else { echo plugin_dir_url( __FILE__ ).'images/default-image_550.png'; }?>">
                        </div>
                        <div class="picture-thumbs">
						      <?php
								  for($j=0;$j<$img_count;$j++)
								  {
								   ?>
								<div class="thumb-item">
                                <img src="<?php echo $product_attr[0]->images[$j]->src;?>" class="imgthumbs">
                            </div>
                            <?php  
							  }
							  ?> 
                        </div>
                    </div>
				    
				   <div class="overview">
				       <!--description-->
                       <div class="product-name">
                            <h1 itemprop="name">
                                <?php echo $product_attr[0]->name;?>
                            </h1>
                        </div>
                        
						<!--description-->
						 <div class="short-description">
                            <?php echo $product_attr[0]->short_description;?>
                        </div>
						
						 <!--availability-->
						
						 <?php if($product_attr[0]->display_stock_availability==1)
						 {
							 ?>
                        <div class="availability">
                            <div class="stock">
						
                                <span class="label">Availability:</span>
                                <span class="value"><?php if($product_attr[0]->stock_quantity==0){ echo 'Out of Stock';}else {echo 'In Stock';}?></span>
                            </div>
                        </div>
						 <?php } ?>
						
						 <!--SKU, MAN, GTIN, vendor-->

                        <div class="additional-details">
                           <?php if($product_attr[0]->sku!=""){?> <div class="sku">
                                <span class="label">SKU:</span>
							  <span class="value" itemprop="sku"><?php echo $product_attr[0]->sku;?></span>
                            </div><?php } ?>
                        </div>
						
						  <!--delivery-->
						    <?php if($product_attr[0]->is_free_shipping=='true'){ ?>
                        <div class="delivery">
                          <?php  echo '<div class="free-shipping"> Free Shipping'; ?></div>
                        </div>
						<?php } ?>
						
				   </div>				   


<div class="pp-overview">
   <?php 
   $price=0;
   for($att=0;$att<$attributes;$att++)
   {	
   ?>   
   <li style="list-style:none;line-height:30px;"><b style="line-height:40px;"><?php echo $product_attr[0]->attributes[$att]->product_attribute_name;?></b><br>
   <?php 
  
   $control=$product_attr[0]->attributes[$att]->attribute_control_type_name;
   $attr_count=count($product_attr[0]->attributes[$att]->attribute_values);
   if($control=='DropdownList')
	{
	?>
	<select style="height:40px;" id="<?php echo $product_attr[0]->attributes[$att]->id; ?>">
	<?php
	 for($i=0;$i<$attr_count;$i++)
	 {
		 //price adjustment 
		//$price_adjustment=number_format($product_attr[0]->attributes[$att]->attribute_values[$i]->price_adjustment,2);

		 
		 if($product_attr[0]->attributes[$att]->attribute_values[$i]->is_pre_selected=='1')
		{
			$check='Selected';
		}
        else {
		   $check='';
		}
		
	 ?>
     <option data-att-value="<?php echo $product_attr[0]->attributes[$att]->attribute_values[$i]->id;  ?>"  <?php echo $check;?>  value="<?php echo number_format($product_attr[0]->attributes[$att]->attribute_values[$i]->price_adjustment,2);?>"><?php echo $product_attr[0]->attributes[$att]->attribute_values[$i]->name;?>[+$<?php echo number_format($product_attr[0]->attributes[$att]->attribute_values[$i]->price_adjustment,2);?>]</option>
	 <?php	  
	 }
	 ?>
	</select>	
    <?php	
	} 
   else if($control=='RadioList')
   {	   
   for($i=0;$i<$attr_count;$i++)
    {
		//echo $product_attr[0]->attributes[$att]->attribute_values[$i]->is_pre_selected;
		//print_r($product_attr[0]);die;
		if($product_attr[0]->attributes[$att]->attribute_values[$i]->is_pre_selected=='1')
		{
			$check='checked';
		}
        else {$check='';}
       $radio_name=strtolower($product_attr[0]->attributes[$att]->product_attribute_name);		
	?>
   <input  id="<?php echo $product_attr[0]->attributes[$att]->id; ?>" type="radio" data-att-val="<?php echo $product_attr[0]->attributes[$att]->attribute_values[$i]->id; ?>" name="product_radio_<?php echo $product_attr[0]->attributes[$att]->id; ?>" <?php echo $check;?> value="<?php echo number_format($product_attr[0]->attributes[$att]->attribute_values[$i]->price_adjustment,2);?>"><?php echo $product_attr[0]->attributes[$att]->attribute_values[$i]->name;?>[+$<?php echo number_format($product_attr[0]->attributes[$att]->attribute_values[$i]->price_adjustment,2);?>]
   <br>
   <?php
   }
   }
   else
   {
	for($i=0;$i<$attr_count;$i++)
    {
		if($product_attr[0]->attributes[$att]->attribute_values[$i]->is_pre_selected=='1')
		{
			$check='checked';
		}
        else {
		   $check='';
		}		
   ?>
   <input  id="<?php echo $product_attr[0]->attributes[$att]->id; ?>" name="product_checkbox_<?php echo $product_attr[0]->attributes[$att]->id; ?>_<?php echo $product_attr[0]->attributes[$att]->attribute_values[$i]->id;?>" type="checkbox"  <?php echo $check;?>  value="<?php echo $product_attr[0]->attributes[$att]->attribute_values[$i]->id;?>" pr-data="<?php echo $product_attr[0]->attributes[$att]->attribute_values[$i]->price_adjustment; ?>"><?php echo $product_attr[0]->attributes[$att]->attribute_values[$i]->name;?>[+$<?php echo number_format($product_attr[0]->attributes[$att]->attribute_values[$i]->price_adjustment,2);?>]
   <br>
   <?php
	}
   }
   ?>
   </li>   
   <?php
 
    //echo $price = $price + $product_attr[0]->attributes[$att]->attribute_values[$i]->price_adjustment;
   }
   ?>  
  <?php if($product_attr[0]->product_type !='GroupedProduct') { ?> <li style="list-style: none; padding: 0 0 10px; line-height: 40px; font-size: 20px; font-weight: bold; color: #444;" ><b>$</b><span id="pprss"><?php echo $product_attr[0]->price; ?></span><b>.00</b></li> <?php } ?>
   <li style="list-style:none;margin: auto;" class="cart"><div class="bt-buttons">
   <?php if($product_attr[0]->product_type !='GroupedProduct' && $product_attr[0]->disable_buy_button !='1') { ?><input type='text' value='1' class='qtyval inpt0'> <input type="button" value="Add to cart" class="addcartproduct inpi01" paid="<?php echo $product_attr[0]->id;?>" stockcheck="<?php echo $product_attr[0]->stock_quantity;?>"><?php } ?>
   </div></li>      
   </div>


<ul border="1" style="list-style: none;">
  <li class="cart"><div class="bt-buttons">
    
   </div></li>      
</ul>

<ul>
<li class="prod_description"><?php  echo html_entity_decode($product_attr[0]->full_description);?></li>
</ul> 
</div>
</div>
 </form>
</div>
<?php
$associate_product_ids = $product_attr[0]->associated_product_ids;
echo '<div class="" data-productid="14">';
for($ih=0;$ih<count($associate_product_ids); $ih++)
{
	$aspid = $associate_product_ids[$ih];
	//$dtfile = file_get_contents($api_url.'/api/products/'.$aspid);
	$apornkl = $api_url.'/api/products/'.$aspid;
	$dtfile = getdata($apornkl);
	$asdfile = json_decode($dtfile);
	$jnd = $asdfile->products;
	$jnd_prod_img = $jnd[0]->images;
	//print_r($jnd[0]);die;
	?>
	
<div class="product-variant-line" data-productid="14">
                                    <div class="variant-picture">
                                        <img src="<?php echo $jnd_prod_img[0]->src; ?>" >
                                    </div>
                                <div class="variant-overview">
                                        <div class="variant-name">
                                           <?php echo $jnd[0]->name ?>
                                        </div>
                                                                        <!--availability-->
                                        <div class="availability">
            <div class="stock">
                <span class="label">Availability:</span>
                <span class="value"><?php if($jnd[0]->display_stock_availability > 0){ echo 'In Stock'; } else {echo 'Out of Stock'; } ?></span>
            </div>
        
    </div>

                                    <!--SKU, MAN, GTIN, vendor-->
                                    
<div class="additional-details">
    
        <div class="sku">
            <span class="label">SKU:</span>
            <span class="value" itemprop="sku" id="sku-14"><?php echo $jnd[0]->sku ?></span>
        </div>
            </div>
                                    <!--delivery-->
                                    
                                    <!--sample download-->
                                    
                                    <!--attributes-->

                                    <!--gift card-->

                                    <!--rental info-->

                                    <!--price & add to cart-->
    <div class="prices" >
            <div class="product-price">
<span itemprop="price">
                  $ <?php echo $jnd[0]->price ?>
                </span>
            </div>
                
    </div>

                                    <!--price breaks-->
                                    

    <div class="add-to-cart">
                            <div class="add-to-cart-panel">
                <label class="qty-label" for="addtocart_14_EnteredQuantity">Qty:</label>
<input class="qty-input qtyval" name="addtocart_14.EnteredQuantity" type="text" value="1">
                       
                                    <input type="button" class="button-1 add-to-cart-button addcartproduct" value="Add to cart" stockcheck="<?php echo $jnd[0]->stock_quantity ?>" paid="<?php echo $jnd[0]->id ?>">

            </div>
        
    </div>

 

                                </div>
                            </div>
							
	<?php
}
echo "</div>";
?>
</div>
<?php 
 }

// register shortcode for display product details on a page 
add_shortcode('display_product','Display_products');

/** function to display product details ends here **/





/** Shopping Cart widgets code here **/

class Shopping_Cart_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'Shopping_cart_Widget',
			'description' => 'Shopping Cart Widget',
		);
		parent::__construct( 'Shopping_cart_Widget', 'Shopping Cart Widget', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		include_once(plugin_dir_path( __FILE__ ) .'api/getdata.php');
		$title = apply_filters( 'widget_title', $instance['title'] );		 
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		//echo $args['before_title'] . $title . $args['after_title'];
		 
		// This is where you run the code and display the output
		//echo __( 'Hello, World!');
		echo 'Shopping Cart Section Display Here';	
		
		// getting the api url from the database
		$api_config=api_config();
		$response_url=json_decode($api_config);
		$api_url=$response_url[0]->api_url;
		
		
		//GET /api/shopping_cart_items
		 $url=$api_url."/api/shopping_cart_items";		 
         $cart_response=getdata($url);
         //$cart_body=wp_remote_retrieve_body($cart_response);
         $cart_items=json_decode($cart_response);
		 $count_cart_items=count($cart_items->shopping_carts);
		 $cart_details=$cart_items->shopping_carts;
		 
		 /*
		 echo '<pre>';
		 print_r($cart_items->shopping_carts);
		 echo '</pre>';
		*/
		
		 //print_r($cart_details[0]->product->name);
		
         
		  
		 $total=0;
         echo '<ul>';		 
		 for($i=0;$i<$count_cart_items;$i++)
		 {	 
	      
		  /*
			 echo '<pre>';
			 print_r($cart_details[$i]);
			 echo '</pre>';
	  */
	       		
			// change the utc time to system date 
			$time = strtotime($cart_details[$i]->customer->created_on_utc);
			$dateInLocal = date("Y-m-d", $time);
			$sysdate=date("Y-m-d");
			//echo $dateInLocal;

			//system date 
          //  echo $sysdate=date("Y-m-d");			
		
			/*
	        echo '<br>';
	        echo $cart_details[$i]->customer->last_ip_address;
			
			echo '<br>';
			echo $cart_details[$i]->customer->created_on_utc;
			echo '<br>';
			
			if($cart_details[$i]->customer->last_ip_address==$_SERVER['REMOTE_ADDR'])
			{
				echo 'this client';
			}
			else
			{
				echo 'error';
			}
			*/
			//print_r($cart_details[$i]->customer->last_ip_address);
			
			//$ip='[Nop_Shopping_Cart]'
            
			$ip='180.151.102.194';		
			if($ip==$cart_details[$i]->customer->last_ip_address)
			{			
            $total=$total + $cart_details[$i]->product->price;  
	         //print_r($cart_details[$i]->product->attributes[0]->product_attribute_name);
			 //echo $price=$cart_details[$i]->product->price;		 
			 //print_r($cart_details[$i]->product_attributes);
			 $product_attr=$cart_details[$i]->product_attributes;
			 $count_attr=count($product_attr);		 
			 echo '<li class="img_class"><img src="'.$cart_details[$i]->product->images[0]->src.'" width="128px;" ">';
			 echo '<ul class="prod_details"><li class="">'.$cart_details[$i]->product->name.'</li><li class="prod">';
			 for($j=0;$j<$count_attr;$j++)
			 {			  
			  echo $cart_details[$i]->product->attributes[$j]->product_attribute_name. ' : '.$cart_details[$i]->product->attributes[$j]->attribute_values[0]->name;
              echo '<br>';
			 }
			 echo 'Unit Price : $'.number_format($cart_details[$i]->product->price,2).'</br>';
			// echo 'Total Price : $'.$total=$total + $cart_details[$i]->product->price.'<br>';
			 echo 'Quantity : '.$cart_details[$i]->quantity.'</li></ul>';	
			 //echo '<br>';
             //echo 'Create on UTC:'.$dateInLocal.'</li></ul>';				 
           	}		 
		}
		 echo '</ul>'; 
          
		 echo 'Sub-Total :<b>$'.$total.'</b>'; 
       // Sub-Total: $67.56
		
		
		echo $args['after_widget'];	
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
		if ( isset( $instance[ 'title' ] ) ) {
		$title = $instance[ 'title' ];
		}
		else {
		$title = __( 'New title');
		}
    ?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
<?php
	}
	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved		
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;

	}
}

add_action( 'widgets_init', function(){
	register_widget( 'Shopping_Cart_Widget' );
});
/** Shopping Cart widgets code ends here **/



/** shortcode for displaying shoppping cart in the page **/

// register shortcode for display shopping cart  on a page 

function Nop_Shopping_Cart()
{
	include_once(plugin_dir_path( __FILE__ ) .'api/getdata.php');
	$cart_box = "";
$cart_box .= "<div id='spcrt'>
	<style>
	.img_class li {
    list-style: none;
}
li.img_class {
    width: 190px!important;
    list-style: none;
    display: inline-block;
    line-height: 29px;
}
.img_class {
    border: 0px solid;
    max-height: 161px;
    width: 104%;
    list-style: none;
}
ul.prod_details {
    float: right;
    display: block;
    width: 100px;
}
	</style>
	
	";
	    // getting the api url from the database
		$api_config=api_config();
		$response_url=json_decode($api_config);
		$api_url=$response_url[0]->api_url;	
	
		//GET /api/shopping_cart_items
		
		 $nopmeid =$_COOKIE['nopmeid'];
		$cooguid = $_COOKIE['Nop_customer'];
		

		 $url = $api_url."/api/shopping_cart_items/".$nopmeid;

         $cart_response=getdata($url);		 
		
        // $cart_body=wp_remote_retrieve_body($cart_response);
         $cart_items=json_decode($cart_response);
		 
		 $count_cart_items=count($cart_items->shopping_carts);
		 $cart_details=$cart_items->shopping_carts;         
		
		 $total=0;
		 
		 if($nopmeid =="")
		 {
			 $count_cart_items="0";
		 }
        $cart_box .=  '<input type="button" class="shopping_Cart_menu" value="Shopping Cart('.$count_cart_items.')"><div id="cart_pop" style="display:none;"><div style="width:263px;height:auto;margin-bottom:10px;border:1px solid #ccc;padding:2px;">';		 
if($nopmeid!="")
			 {		
		for($i=0;$i<$count_cart_items;$i++)
		 {		
	 
	 			
	       		        $atmain = $cart_details[$i]->product_attributes;
				$varProductAtrr = "";
				$varSubTotalExtra = 0;
				foreach($atmain as $mmatlist)
				{
				 	$atsid = $mmatlist->id;
					//print_r($mmatlist);
					 $atsval = $mmatlist->value;
					// change the utc time to system date 
					$time = strtotime($cart_details[$i]->customer->created_on_utc);
					$dateInLocal = date("Y-m-d", $time);
					$sysdate=date("Y-m-d");
					$atrlist = $cart_details[$i]->product->attributes;
					//var_dump(); 
					$arrAtrValues = $atrlist[$mmatlist->id-1]->attribute_values;
					$objAttrData = false;
					foreach($arrAtrValues as $key=>$value){
						if($value->id == $atsval){
							$objAttrData = $value;
						}
					}
					//var_dump($objAttrData);
					$varSubTotalExtra = $varSubTotalExtra + $objAttrData->price_adjustment;
					$varPriceAdj = (!empty($objAttrData->price_adjustment)) ? "[+$".number_format($objAttrData->price_adjustment,2)."]" : "";
					$varProductAtrr.= $atrlist[$mmatlist->id-1]->product_attribute_name.": ".$objAttrData->name.$varPriceAdj."<br/>";
			       }
			
                         $total = $total + ($cart_details[$i]->product->price * $cart_details[$i]->quantity) + $varSubTotalExtra; 	        
			 $product_attr=$cart_details[$i]->product_attributes;
			 $count_attr=count($product_attr);		
		 
			$cart_box .=  '<div style="float:left;"><img style="float: left;width: 65px;" src="'.$cart_details[$i]->product->images[0]->src.'">';
			$cart_box .= '<a href="javascript:void()" style="clear: both; display: block; width: 65px; background: #333; text-align: center; color: #fff; font-size: 14px" class="delitem" delid="'.$cart_details[$i]->id.'">delete</a></div>';	
			 
			$cart_box .=  '<div style="float:left;width:180px; padding-left:12px"><h1 style="margin: 0px; font-size: 16px; line-height: 30px;">'.$cart_details[$i]->product->name.'</h1>
			 <p class="prod" style="margin-top:10px;">';
			 $cart_box .=$varProductAtrr;
			
			 $cart_box .=  'Unit Price : $'.number_format($cart_details[$i]->product->price+$varSubTotalExtra,2).'</br>';			
			$cart_box .=  'Quantity : '.$cart_details[$i]->quantity.'</p> </div>';	
			 			 
           			 
		}
			 } 
		
		 if($count_cart_items == '0')
		 {
			
			 $cart_box .=  "<p>You have no items in your shopping cart.</p>";
		
         $cart_box .=  '</div>';
	     }
	if($count_cart_items != '0')
	{
		 $cart_box .=  '<div style="clear:both;">Sub-Total :<b>$'.$total.'</b></div>'; 
		 $cst_link  = $api_url.'/cart?q='.$cooguid;
		 $cart_box .=  "<a style='background: #3399ff; width: 100%; clear: both; display: block; padding-left: 10px; height: 30px;text-align: center; line-height: 30px; color: #fff;' href='{$cst_link}' type='button' class='button btn btn-primary' id='checkout'>Checkout</a>"	;
	}
		 
		$cart_box .=  '</div></div>'; 
	return $cart_box;
}


// register shortcode for nop shopping cart 
add_shortcode('Nop_Shopping_Cart','Nop_Shopping_Cart');
/** shortcode for displaying shoppping cart in the page ends here **/



/*** shortcode for single product display ***/

function Single_Product($attr)
{
	
	include_once(plugin_dir_path( __FILE__ ) .'api/getdata.php');
	
	// getting the api url from the database
		$api_config=api_config();
		$response_url=json_decode($api_config);
		$api_url=$response_url[0]->api_url;
		
	
	    $pid=$attr['id'];
	
        /** api for getting the product details such as name, price and image **/           
         $url=$api_url."/api/products/".$pid;
		 $product=getdata($url);		 
		 
         //$product_body=wp_remote_retrieve_body($product);
         $product_details=json_decode($product);
         $response=$product_details->products; 
		 
		 if(!empty($response))
		 { 
		 $rows=$product_details->products;
         $total_rows=count($rows); 

		
		$text=strtolower($rows[0]->name);
		$final = preg_replace('#[ -]+#', '-', $text);     	 
		 
		
        /** map the product with the category using the product category mapping api **/	 
		$mbpolyuri = $api_url.'/api/product_category_mappings/'.$pid;
		$product_mapping=getdata($mbpolyuri);
		//$product_map=wp_remote_retrieve_body($product_mapping);
		$product_map_details=json_decode($product_mapping);
		$p_cat_id=$product_map_details->product_category_mappings[0]->category_id;
		 
		 
		 
		/** getting the category name from the product category mapping api category id **/		
		$vbxctmpuri = $api_url.'/api/categories/'.$p_cat_id;
		$cat_response=getdata($vbxctmpuri);
		//$cat_body=wp_remote_retrieve_body($cat_response);
		$cat_result=json_decode($cat_response);
		$cat_name=$cat_result->categories[0]->name;
		 
		     
	    
		$img=$response[0]->images[0]->src;
		$pname=$response[0]->name;
		$price=number_format($response[0]->price,2);
		
		$published=$response[0]->published;
		
		if($published==1)
		{
			?>
		
		
		<div class="page category-page">
		<div class="product-grid">
		<div class="item-grid">
		<div class="item-box">
                            
<div class="product-item" >
    <div class="picture">
       <a href='<?php echo home_url() ?>/product-details/?pcat=<?php echo strtolower($cat_name).'&product='.$final.'&pid='.$pid ?>'><img src='<?php echo $img ?>'></a>
    </div>
    <div class="details">
                   <h2 class="product-title techp1">
           <a href="<?php echo home_url().'/product-details/?pcat='.strtolower($cat_name).'&product='.$final.'&pid='.$product_map[$p]->product_id;?>"><?php echo $rows[0]->name;?>	</a>
        </h2>

        
        <div class="add-info">
            
            <div class="prices">
                <span class="price actual-price">$ <?php echo $price; ?></span>
                            </div>
            
            <div class="buttons">
            <input type="button" value="Add to cart" class="addcartproduct button-2 product-box-add-to-cart-button" paid="<?php echo $pid; ?>">                
            </div>
            
        </div>
    </div>
</div>

                        </div>
		
		
		</div>
		
		</div>
		
		</div>
		
	    <?php
		}	
	}		
}


add_shortcode('Nop_Catalog_Product','Single_Product');
/*** shortcode for single product display  ends here ***/

function treeviewstore($att)
{
	include_once(plugin_dir_path( __FILE__ ) .'api/getdata.php');
$ctlnm = "";
	// getting the api url from the database
	$api_config=api_config();
	$response_url=json_decode($api_config);
	$api_url=$response_url[0]->api_url;
	
	
	$ctaypri = $api_url.'/api/categories';
	$response = getdata($ctaypri);
	//$body = wp_remote_retrieve_body( $response );
	$result=json_decode($response);	
	$rows=$result->categories;
	$total_rows=count($rows);	
	$cat_link=get_page_link().'/?cat=';
	//print_r($rows);die;
	$apo=array();
		
	for($jj=0;$jj<$total_rows;$jj++)
	{
		array_push($apo,$rows[$jj]->parent_category_id);
		
	}
	

  $ctlnm .= '<div><ul class="category">';

  for($i=0;$i<$total_rows;$i++)
  {	    
 
	  if($rows[$i]->parent_category_id=='0' && $rows[$i]->published=='1' && $rows[$i]->store_ids[0]==$att['id'])
	  {		 
		  //echo '<li><a href='.home_url().'/products/?'.strtolower($rows[$i]->id).'-'.$rows[$i]->se_name.'>'.$rows[$i]->name.'</a>';
        if (!in_array($rows[$i]->id, $apo)) 
		{
				$ctlnm .= '<li><a  class="catmain" href='.home_url().'/products/?'.$rows[$i]->se_name .'/'.strtolower($rows[$i]->id).'-'.$rows[$i]->se_name.'>'.$rows[$i]->name.'</a>';		  
		}
		else
		{	

			$ctlnm .= '<li><a  class="catmain" href='.home_url().'/products/?'.strtolower($rows[$i]->id).'-'.$rows[$i]->se_name.'>'.$rows[$i]->name.'</a>';		  
		}
	  }
	  else if($rows[$i]->parent_category_id!='0' && $rows[$i]->published=='1' && $rows[$i]->store_ids[0]==$att['id'])
	  {
		  $catid=$rows[$i]->parent_category_id;
		  $ctlnm .= '<ul class="product" style="display:none;">';
		  if($rows[$i]->parent_category_id!='0' && $rows[$i]->published=='1' && $rows[$i]->store_ids[0]==$att['id'])
		  {
           //echo '<li><a href='.home_url().'/products/?'.$catid.'-'.$rows[$i]->se_name.'/Product-'.$rows[$i]->id.'-'.$rows[$i]->se_name.'>'.$rows[$i]->name.'</a></li>';
           $ctlnm .= '<li><a href='.home_url().'/products/?'.$catid.'-'.$rows[$i]->se_name.'/'.$rows[$i]->id.'-'.$rows[$i]->se_name.'>'.$rows[$i]->name.'</a></li>';
          
          }
		  $ctlnm .= '</ul>';
	  }
  }  
  $ctlnm .= '</li></ul></div>';  
  return $ctlnm;
}

// register a new shortcode:[display_categories] 
 add_shortcode('display_categories_tree_store','treeviewstore');


 function noporders($att)
{
	include_once(plugin_dir_path( __FILE__ ) .'api/getdata.php');
	global $wpdb;
	include_once('../../wp-includes/user.php');
	
	// getting the api url from the database
	$api_config=api_config();
	$response_url=json_decode($api_config);
	$api_url=$response_url[0]->api_url;
	
	$wpuid = get_current_user_id();
	$customer_id = $wpuid;
	if($wpuid==0)
	{
?>
		<script>
createCookie("order","order",20);
</script>
<?php

		echo "<script>window.location.assign('".get_site_url()."/wp-login.php')</script>";
	}

$tblnmp =  'wp_usermapping';

	$result=$wpdb->get_results("select nopuid from ".$tblnmp." where wpuid=".$wpuid);

	$current_user = $result[0]->nopuid;
	
	$ordmapuri = $api_url.'/api/orders';
	$response = getdata($ordmapuri);
	//$body = wp_remote_retrieve_body( $response );

	$result=json_decode($response);	

	$rows=$result->orders;
	$total_rows=count($rows);	
	$cat_link=get_page_link().'/?cat=';
	
	if ($current_user == "")
	{
		echo "No order found";
	}
	else
	{
		echo "<input type='button' id='sh-orders' value='Orders'> <br>";
		echo '<div class="tab-ord">';

  for($value=count($rows);$value>=0;$value--) {
	   $_xyz = $rows[$value]->customer;
	  
	   if($_xyz->id == $current_user)
	   {
$currency = array('USD'=>'$', 'EUR'=>'€', 'INR'=>'₹', 'CAD'=>'$');
$symbol_currency = '';
if(array_key_exists($rows[$value]->customer_currency_code,$currency))
{
$symbol_currency = $currency[$rows[$value]->customer_currency_code];
}
else
{
$symbol_currency = $rows[$value]->customer_currency_code;
}
$dtexp = explode('.',str_replace('T',' ',$rows[$value]->created_on_utc));
		   echo '<div class="rowsord"><br><br><div class="page-atitle">Order Id : ' . $rows[$value]->id.'</div>';
			   echo '<div class="pt01">Order Status : ' . $rows[$value]->order_status.'</div>';
			   echo '<div class="pt01">Order Date : ' . $dtexp[0].'</div>';
			   echo '<div class="pt01">Order Total : ' .$symbol_currency .' '. $rows[$value]->order_total.'</div>';
			   $path = get_site_url().'/order-details?id='. $rows[$value]->id ;
			   echo '<div class="pt01"><a style="text-decoration: none !important;" href="'. $path.'">Get Order Details </a>'.'</div></div>';
			  
	   }

}

echo '</div>';
	}
	
	 
  // Get Customer Address 
		$cusmpurin = $api_url.'/api/customers';
		$customer_details = getdata($cusmpurin);
		//$customer_details_body = wp_remote_retrieve_body( $customer_details );

		$_customer_details_result = json_decode($customer_details);	
		$customer_details_result = $_customer_details_result->customers;
		  
		
		foreach($customer_details_result as $value){
			foreach($value->addresses as $address){
				if($address->id == $customer_id)
				{   echo'<div class="tab-adrs" style="display:none;"><div class="col-add1">';
		        	echo '<h4>Address </h4>';
					echo '<span>' .$address->first_name .' '. $address->last_name .'</span>';
					echo '<span>Email:'. $address->email.'</span>';
					echo '<span>Phone:' .$address->phone_number.'</span>';
					echo '<span>Fax Number:'. $address->fax_number.'</span>';
					echo '<span>'. $address->company.'</span>';
					echo '<span>'.$address->address1 .' '.$value->address2.'</span>';
					echo '<span>' .$address->city.'</span>';
					echo '<span>'. $address->country.'</span>';
					echo '<span>'. $address->zip_postal_code.'</span>';
					echo '<span>';
					echo '</div></div>';
				}
			}
		}

}
// register a new shortcode:[display_categories] 
 add_shortcode('Nop_Customer_Orders','noporders');

function nopordersdetails()
{
	include_once(plugin_dir_path( __FILE__ ) .'api/getdata.php');
	global $wpdb;
	include_once('../../wp-includes/user.php');
	$wpuid = get_current_user_id();
	$result=$wpdb->get_results("select nopuid from 'wp_usermapping' where wpuid=$wpuid");

	$customer_id = $result[0]->nopuid;
	
	$att_id = $_REQUEST['id'];
	
	
	// getting the api url from the database
	$api_config=api_config();
	$response_url=json_decode($api_config);
	$api_url=$response_url[0]->api_url;
	
	
	
	if($wpuid==0)
	{
		
		echo "<script>window.location.assign('".get_site_url()."/wp-login.php')</script>";
	}
	$urlaporder = $api_url.'/api/orders';
	$response = getdata($urlaporder);
	//$body = wp_remote_retrieve_body( $response );

	$result=json_decode($response);	
	$rows=$result->orders;
	$total_rows=count($rows);	
	$cat_link=get_page_link().'/?cat=';
	
	
	
  foreach($rows as $value) {
	  if($value->id == $att_id){

$currency = array('USD'=>'$', 'EUR'=>'€', 'INR'=>'₹', 'CAD'=>'$');
$symbol_currency = '';
if(array_key_exists($value->customer_currency_code,$currency))
{
$symbol_currency = $currency[$value->customer_currency_code];
}

		  echo '<div class="col-add1">';
	  $billing_address = $value->billing_address;
	  echo '<h4>Billing Details </h4> ';
	  echo '<span>Name :' . $billing_address->first_name . ' ' . $billing_address->last_name.'</span>';
	  echo '<span>email :' . $billing_address->email.'</span>';
	  echo '<span>Phone No :' . $billing_address->phone_number.'</span>';
	  echo '<span>Fax :' . $billing_address->fax.'</span>';
	  echo '<span>Address :' . $billing_address->address1.'</span>';
	  echo '<span>' . $billing_address->address2.'</span>';
	  echo '<span>' . $billing_address->city.'</span>';
	  echo '<span>' . $billing_address->country.'</span>';
	  echo '<span>' . $billing_address->zip_postal_code.'</span>';

	  echo '<h4 style="margin-top: 22px;">Payment </h4> ';
	  echo '<span>Payment Method:' . str_replace('Payments.', $value->payment_method_system_name).'</span>';
	  echo '<span>Payment Status:' . $value->payment_status.'</span>';
	   echo '</div>';
	   
	   
	    echo '<div class="col-add1">';
	  $shipping_address = $value->billing_address;
	  echo '<h4>Shipping Details </h4> ';
	  echo '<span>Name :' . $shipping_address->first_name . ' ' . $billing_address->last_name.'</span>';
	  echo '<span>email :' . $shipping_address->email.'</span>';
	  echo '<span>Phone No :' . $shipping_address->phone_number.'</span>';
	  echo '<span>Fax :' . $shipping_address->fax.'</span>';
	  echo '<span>Address :' . $shipping_address->address1.'</span>';
	  echo '<span>' . $shipping_address->address2.'</span>';
	  echo '<span>' . $shipping_address->city.'</span>';
	  echo '<span>' . $shipping_address->country.'</span>';
	  echo '<span>' . $shipping_address->zip_postal_code.'</span>';
	  
	  echo '<h4 style="margin-top: 22px;">Shipping </h4> ';
	  echo '<span>Payment Method:' .  $value->shipping_method.'</span>';
	  echo '<span>Payment Status:' . $value->shipping_status.'</span>';
	  echo '</div>';
	  echo'<div style="clear:both;"></div>';
		$product = $value->order_items;
	 echo '<h4 class="pro-dd1">Product Details </h4> ';
	 echo '<table class="data-table">';
	 echo '<thead><tr><th>SKU</th><th>Name</th><th>price</th><th>Quantity</th><th>Total</th><tr>';
	foreach($product as $_product){
		echo '<tr>';
		echo '<td>'.$_product->product->sku .'</td>';
		echo '<td>'.$_product->product->name .'</td>';
		echo '<td>'.$symbol_currency . ''.$_product->unit_price_incl_tax .'</td>';
		echo '<td>'.$_product->quantity .'</td>';
		echo '<td>'.$symbol_currency . ' '. $_product->price_incl_tax.'</td>';
		echo '<tr>';
	}


echo '<tr><td colspan="4" style="text-align: right">Order Sub Total Excluding Tax</td><td><strong> '.$symbol_currency . ' ' .$value->order_subtotal_excl_tax.'</strong></td></tr>';
echo '<tr><td colspan="4" style="text-align: right">Order Sub Total Including Tax</td><td><strong> '.$symbol_currency . ' ' .$value->order_subtotal_incl_tax.'</strong></td></tr>';
echo '<tr><td colspan="4" style="text-align: right">Order Tax</td><td><strong> '.$symbol_currency . ' ' .$value->order_tax.'</strong></td></tr>';

echo '<tr><td colspan="4" style="text-align: right">Discount Excluding Tax</td><td><strong> '.$symbol_currency . ' ' .$value->order_sub_total_discount_excl_tax.'</strong></td></tr>';
echo '<tr><td colspan="4" style="text-align: right">Discount Including Tax</td><td><strong> '.$symbol_currency . ' ' .$value->order_sub_total_discount_incl_tax.'</strong></td></tr>';
echo '<tr><td colspan="4" style="text-align: right">Order Total</td><td><strong>'.$symbol_currency . ' ' . $value->order_total.'</strong></td></tr>';
	  echo '</table>';
	 
	  
	  
	  }
			
}
 
}
// register a new shortcode:[display_categories] 
 add_shortcode('Nop_Order_Details','nopordersdetails');
function nopcataloghome() {    
include_once(plugin_dir_path( __FILE__ ) .'api/getdata.php');

// getting the api url from the database
$api_config=api_config();
$response_url=json_decode($api_config);
$api_url=$response_url[0]->api_url;



/*
$type=$exp[0];
$id=$exp[1]; 
$se_name=$exp[2];
*/


$type=$exp[0];
$get_id=explode("?",$exp[0]); 
$id=$get_id[1];
$se_name=$exp[1];

?>
<?php
if($type!='Product')
{
$urlmpcat = $api_url.'/api/categories';
$cat_response=getdata($urlmpcat);

//$cat_body=wp_remote_retrieve_body($cat_response);
$cat_result=json_decode($cat_response);
$cat_result1=json_decode($cat_response);

$cat_name=$cat_result->categories[0]->name;

foreach($cat_result1 as $prods){
	$final[] = (array)$prods;
}

foreach($final[0] as $prodsfinal){
	$prodfinal[] = (array)$prodsfinal;
}

?>

<div class="category-grid home-page-category-grid">
        <div class="item-grid">

<?php
$apo=array();
	for($jj=0;$jj<count($prodfinal);$jj++)
	{
		array_push($apo,$prodfinal[$jj]['parent_category_id']);
		
	}

foreach($prodfinal as $awnlist)
{
	$keymyarr = $awnlist['id'];
	$keymyarrval = $awnlist['display_order'];
	$myarray[$keymyarr]=$keymyarrval;
}
//$myarray = uksort($myarray);
asort($myarray);

//$remyarray = array_reverse($myarray);
$id=0;
foreach($myarray as $key=>$value)
{
	foreach($prodfinal as $listcat)
	{ 
	if($key == $listcat['id'] && $listcat['show_on_home_page']==1 && $listcat['published']==1)
	{
		if (!in_array($listcat['id'], $apo)) 
		{
		?>
		<div class="item-box">
                    <div class="category-item">
	<h2 class="title techp1"><a href="<?php echo home_url().'/products/?'.$listcat['se_name'].'/'. $listcat['id'].'-'.$listcat['se_name']; ?>"><?php echo $listcat['name']; ?></a></h2>
	 <div class="picture"><a href="<?php echo home_url().'/products/?'.$listcat['se_name'].'/'. $listcat['id'].'-'.$listcat['se_name']; ?>"><img src="<?php echo $listcat['image']->src; ?>"></a></div>
	</div>
</div>	
		<?php
		}
		else
		{
			?>
		<div class="item-box">
                    <div class="category-item">
	<h2 class="title techp1"><a href="<?php echo home_url().'/products/?'. $listcat['id'].'-'.$listcat['se_name']; ?>"><?php echo $listcat['name']; ?></a></h2>
	 <div class="picture"><a href="<?php echo home_url().'/products/?'. $listcat['id'].'-'.$listcat['se_name']; ?>"><img src="<?php echo $listcat['image']->src; ?>"></a></div>
	</div>
</div>	
		<?php
		}
	}
	}

}
?>


</div>
</div>
<?php
}
$i=$i+1;
}

add_shortcode('Nop_Catalog_Homepage_Categories', 'nopcataloghome'); 
function nopcataloghomeproducts() {    
include_once(plugin_dir_path( __FILE__ ) .'api/getdata.php');

// getting the api url from the database
$api_config=api_config();
$response_url=json_decode($api_config);
$api_url=$response_url[0]->api_url;




/*
$type=$exp[0];
$id=$exp[1]; 
$se_name=$exp[2];
*/


$type=$exp[0];
$get_id=explode("?",$exp[0]); 
$id=$get_id[1];
$se_name=$exp[1];

?>
<style>
#loader {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border: 16px solid green;
  border-radius: 50%;
  border-top: 16px solid blue;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<?php
if($type!='Product')
{
$urlcathomepccl = $api_url.'/api/products';
$cat_response=getdata($urlcathomepccl);


//$cat_body=wp_remote_retrieve_body($cat_response);
$cat_result1=json_decode($cat_response);
$cat_name=$cat_result->products[0]->name;

foreach($cat_result1 as $prods){
	$final[] = (array)$prods;
}
foreach($final[0] as $prodsfinal){
	$prodfinal[] = (array)$prodsfinal;
}
?>

<div class="product-grid home-page-product-grid">
<div class="title" style="text-align:center;">
            <strong>Featured products</strong>
        </div>
<div class="item-grid">
<?php
foreach($prodfinal as $awnlist)
{
	$keymyarr = $awnlist['id'];
	$keymyarrval = $awnlist['display_order'];
	$myarray[$keymyarr]=$keymyarrval;
}
//$myarray = uksort($myarray);
asort($myarray);

foreach($myarray as $key=>$value)
{

foreach($prodfinal as $listcat){
	if($key == $listcat['id'] && $listcat['show_on_home_page']==1 && $listcat['published']==1)
	{

	?>
	
	
	
    <div class="item-box">
	<div class="product-item" data-productid="1">
	   <div class="picture">

          <a href="<?php echo home_url().'/product-details/?'. $listcat['id'].'-'.$listcat['se_name'].'&pid='.$listcat['id']; ?>"><img src="<?php echo $listcat['images'][0]->src; ?>"></a>
       </div>
       
	<div class="details"> 
	  <h2 class="product-title techp1">
            <a href="<?php echo home_url().'/product-details/?'. $listcat['id'].'-'.$listcat['se_name'].'&pid='.$listcat['id']; ?>"><?php echo $listcat['name']; ?></a>
     </h2>
	
	<div class="add-info">
	   <div class="prices">
                    <span class="price actual-price">$<?php echo $listcat['price']; ?></span>
       </div>
	   <div class="buttons">

                    <input type="button" value="Add to cart" class="addcartproduct button-2 product-box-add-to-cart-button"  paid="<?php echo $listcat['id']; ?>">
      </div>
	</div>

	</div>
	</div>
	</div>
	
	
	
<?php }}}?>

</div>
</div>
<?php
}
}

add_shortcode('Nop_Catalog_Homepage_Products', 'nopcataloghomeproducts'); 
function cookiesetup()
{
	

}
add_shortcode('Nop-cookie','cookiesetup');
function wptuts_scripts_with_jquery()
{
    // Register the script like this for a plugin:
    wp_register_script( 'custom-script', plugins_url( '/js/custom-script.js', __FILE__ ), array( 'jquery' ) );
    // or
    // Register the script like this for a theme:
    wp_register_script( 'custom-script', get_template_directory_uri() . '/js/custom-script.js', array( 'jquery' ) );
 
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script( 'custom-script' );
}
add_action( 'wp_enqueue_scripts', 'wptuts_scripts_with_jquery' );
   