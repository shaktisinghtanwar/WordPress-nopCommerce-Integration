<?php
/*
 * Copyright (C) 2013 Tony Gaitatzis
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * Author: Tony Gaitatzis - http://www.linkedin.com/in/tonygaitatzis
 * This code complements the online tutorial:
 * http://20missionglass.tumblr.com/post/60787835108/programming-an-oauth2-client-app-in-php
 */

 include_once('../../../../wp-load.php');
	global $wpdb;	
	$rsurl=$wpdb->get_results("select * from ".$wpdb->prefix.'apisettings');
	$api_url = $rsurl[0]->api_url;
	
	$rs=$wpdb->get_results("select * from ".$wpdb->prefix.'nopoauthsettings');
	$client_id = $rs[0]->client_id;
	$client_secret = $rs[0]->client_secret;

$oauth2_client_id = $client_id; // Client ID
$oauth2_secret = $client_secret;  // Client Secret
$ourl = plugin_dir_url( __FILE__ ).'oauth2callback/index.php';
$oauth2_redirect = $ourl; // Redirect URI

?>
