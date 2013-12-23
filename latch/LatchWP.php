<?php
/**
* Plugin Name: Latch
* Plugin URI: http://www.elevenpaths.com
* Description: Latch WordPress integration
* Author: Eleven Paths
* Author URI: http://www.elevenpaths.com/
* Version: 1.0.3
* Compatibility: WordPress 3.5
* Text Domain: latch
*/

/*
Latch Wordpress plugin - Integrates Latch into the Wordpress authentication process.
Copyright (C) 2013 Eleven Paths

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 2.1 of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public
License along with this library; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
*/

require_once("Latch.php");
require_once("LatchResponse.php");
require_once("Error.php");

class LatchWP {
	
	/* -------- GLOBAL SETTINGS (admin) --------- */
	
	function action_admin_init() {
		add_settings_section('latch_settings', 'Global settings', array('LatchWP', 'latch_settings_content'), 'latch_settings');
		add_settings_field('latch_appId', 'Application ID', array('LatchWP', 'latch_settings_appId'), 'latch_settings', 'latch_settings');
		add_settings_field('latch_appSecret', 'Secret key', array('LatchWP', 'latch_settings_appSecret'), 'latch_settings', 'latch_settings');
        add_settings_field('latch_host', 'API URL', array('LatchWP', 'latch_settings_host'), 'latch_settings', 'latch_settings');
		register_setting('latch_settings', 'latch_appId', array('LatchWP', 'latch_validate_appId'));
		register_setting('latch_settings', 'latch_appSecret', array('LatchWP', 'latch_validate_appSecret'));
        register_setting('latch_settings', 'latch_host', array('LatchWP', 'latch_validate_host'));
	}

	function action_admin_menu() {
		add_options_page('Latch settings', 'Latch settings', 'manage_options', 'latch_wordpress', array('LatchWP', 'latch_settings_page'));
	}

	function latch_settings_content() {
		_e("Fill in the data received when you registered the application in Latch:");
	}

	function latch_settings_appId() {
		$appId = esc_attr(get_option('latch_appId'));
		echo '<input id="latch_appId" name="latch_appId" type="text" size="45" maxlength="20" value="' . $appId . '" />';
	}

	function latch_settings_appSecret() {
		$appSecret = esc_attr(get_option('latch_appSecret'));
		echo '<input id="latch_appSecret" name="latch_appSecret" size="90" maxlength="40" type="text" value="' . $appSecret . '" />';
	}
	
    function latch_settings_host() {
        $host = esc_attr(get_option('latch_host'));
        echo '<input id="latch_host" name="latch_host" size="90" type="text" value="' . $host . '" />';
    }
	
	function latch_settings_page() {
		echo '<div><h2>Latch settings</h2>';
		echo '<form action="options.php" method="post">';
		settings_fields('latch_settings');
		do_settings_sections('latch_settings');
		echo '<br /><input name="Submit" type="submit" value="' . __('Save Changes') . '" />';
		echo '</form></div>';
	}
	
	function latch_validate_appId($appId){
		if (!empty($appId) && strlen($appId) != 20) {
			add_settings_error('latch_invalid_appId', 'latch_invalid_appId', __('Invalid application ID'));
			return '';
		} else {
			return $appId;
		}
	}
	
	function latch_validate_appSecret($appSecret){
		if (!empty($appSecret) && strlen($appSecret) != 40) {
			add_settings_error('latch_invalid_appSecret', 'latch_invalid_appSecret', __('Invalid secret key'));
			return '';
		} else {
			return $appSecret;
		}
	}

    function latch_validate_host($host) {
        return rtrim($host, '/');
    }
	
	
	/* -------- PROFILE SETTINGS (current user) --------- */
	
	function action_profile_personal_options() {
		global $user_id, $is_profile_page;
		
		$latch_id = trim( get_user_option('latch_id', $user_id ) );
		
		echo "<h3>" . __( 'Latch Setup', 'latch' ) . "</h3>\n";
		echo '<table class="form-table"><tbody><th>';
		
		if(empty($latch_id)) {
			echo '<label for="latch_token">' . __('Latch token','latch') . '</label></th><td>';
			echo '<input name="latch_token" id="latch_token"  maxlength="10" type="text" size="25" />';
		} else {
			echo '<label for="latch_accountId">' . __('Latch ID','latch') . '</label></th><td>';
			echo '<input name="latch_accountId" id="latch_accountId" type="text" value="' . esc_attr($latch_id) . '" readonly="readonly" size="80" /> ';
			echo '<input name="latch_unpair" id="latch_unpair" type="checkbox" /> ' . __("Stop using Latch",'latch') ;
		}
		echo '</td></tr></tbody></table>';
	}
	
	function action_user_profile_update_errors($errors) {
		global $user_id;
		
		$appId = get_option('latch_appId');
		$appSecret = get_option('latch_appSecret');
		$token =  $_POST['latch_token'];
        $host = get_option('latch_host');
        if (!empty($host)) {
            Latch::setHost($host);
        }
		
		if (!empty($appId) && !empty($appSecret) ) {
			$api = new Latch($appId, $appSecret);
			$userLatchId = get_user_option('latch_id', $user_id);
			
			if (!empty($token) && empty($userLatchId)) { 
				$pairResponse = $api->pair($token);
				$responseData = $pairResponse->getData();
			
				if (!empty($responseData)) {
					$accountId = $responseData->{"accountId"};
				}

				if (!empty($accountId)) {
					update_user_option($user_id, 'latch_id', $accountId, true);
				} elseif ($pairResponse->getError() == NULL) { 
                    // If Account ID is empty and no error fields are found, there are problems with the connection to the server
				    $errors->add('latch_pairing_error', 'Latch pairing error: Cannot connect to the server. Please, try again later.');
				} else {
					$errors->add('latch_pairing_error', 'Latch pairing error: ' . __($pairResponse->getError()->getMessage()) );
				}
				
			} else if ($_POST['latch_unpair']) {
				$unpairResponse = $api->unpair(get_user_option('latch_id', $user_id));
				$responseError = $unpairResponse->getError();
				
				if (empty($responseError)) {
					update_user_option($user_id, 'latch_id', null, true);
				} else {
					$errors->add('latch_unpairing_error', 'Latch unpairing error: ' . __($responseError->getMessage()) );
				}
			}
		}
	}


	/* -------- AUTHENTICATION --------- */
	
	function filter_authenticate($user, $username = '', $password = '') {			
		if (!is_a($user, 'WP_User')) {
			return $user;
		} else {
			$appId = get_option('latch_appId');
			$appSecret = get_option('latch_appSecret');
            $host = get_option('latch_host');
            if (!empty($host)) {
                Latch::setHost($host);
            }
	
			if (!empty($appId) && !empty($appSecret) ) {
				remove_action('authenticate', 'wp_authenticate_username_password', 20);
				$user = wp_authenticate_username_password(null, $username, $password);
	
				if (isset($_POST["latch_two_factor"])) {
					$expectedToken = get_user_option('latch_two_factor', $user->ID);
					update_user_option($user->ID, 'latch_two_factor', null, true);
										
					if (!empty($expectedToken) && $_POST["latch_two_factor"] === $expectedToken) {
						return $user;
					} else {
						return new WP_Error('latch_invalid_token', __('<strong>ERROR</strong>: Invalid token', 'latch'));
					}
				}
				
				$latch_accountId = get_user_option('latch_id', $user->ID);
				
				if (!empty($latch_accountId)) {
				    $api = new Latch($appId, $appSecret);
					$statusResponse = $api->status($latch_accountId);
	
					$responseData = $statusResponse->getData();
					$responseError = $statusResponse->getError();
					
					//error_log(print_r($responseData, true));
					//error_log(print_r($responseError, true));
									
					// If something goes wrong, disable Latch temporary or permanently to prevent blocking the user
					if (empty($statusResponse) || (empty($responseData) && empty($responseError))) {
						return $user;						
					} else {
						if (!empty($responseError)) {
							if ($responseError->getCode() == 201) {
								// If the account is externally unpaired, apply the changes in WP database 
								update_user_option($user->ID, 'latch_id', null, true);
								update_user_option($user->ID, 'latch_two_factor', null, true);
							}					
							return $user;
						}
					}
						
					if (!empty($responseData) && $responseData->{"operations"}->{$appId}->{"status"} === "on") {
						$two_factor_token = $responseData->{"operations"}->{$appId}->{"two_factor"}->{"token"};
						
						if (!empty($two_factor_token)) {
							update_user_option($user->ID, 'latch_two_factor', $two_factor_token, true);
							
							include('two_factor.php');
							die;
						}
						
						update_user_option($user->ID, 'latch_two_factor', null, true);
						
						return $user;
					} else {
						//return new WP_Error('latch_account_blocked', __('<strong>ERROR</strong>: The account is blocked by Latch', 'latch'));
						return new WP_Error('authentication_failed', __('<strong>ERROR</strong>: Invalid username or incorrect password.'));
					}
				} else {
					return $user;
				}
			} else {
				return $user;
			}
		}
	}
}

add_action('admin_init', array('LatchWP', 'action_admin_init'));
add_action('admin_menu', array('LatchWP', 'action_admin_menu'));
add_action('profile_personal_options', array('LatchWP', 'action_profile_personal_options'));
add_action('user_profile_update_errors', array('LatchWP', 'action_user_profile_update_errors'), 20, 1);
add_filter('authenticate', array('LatchWP', 'filter_authenticate'), 50, 3);

?>