<?php

/*
Latch Wordpress plugin - Integrates Latch into the Wordpress authentication process.
Copyright (C) 2013 Eleven Paths

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if (defined('WP_UNINSTALL_PLUGIN')) {
	delete_option('latch_appId');
	delete_option('latch_appSecret');
    delete_option('latch_host');

	$all_user_ids = get_users('fields=ID');
	foreach ($all_user_ids as $user_id) {
		delete_user_meta($user_id, 'latch_id');
		delete_user_meta($user_id, 'latch_two_factor');
	}
}

?>
