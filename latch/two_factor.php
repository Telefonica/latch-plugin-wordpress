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
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?php echo bloginfo('name'); ?></title>
	<link rel="stylesheet" id="wp-admin-css" href="<?php echo site_url(); ?>/wp-admin/css/wp-admin.css?ver=<?php bloginfo('version'); ?>" type="text/css" media="all">
	<link rel='stylesheet' id='buttons-css' href="<?php echo site_url(); ?>/wp-includes/css/buttons.min.css?ver=<?php bloginfo('version'); ?>" type='text/css' media='all' />
	<link rel="stylesheet" id="colors-fresh-css" href="<?php echo site_url(); ?>/wp-admin/css/colors-fresh.css?ver=<?php bloginfo('version'); ?>" type="text/css" media="all">
	<meta name="robots" content="noindex,nofollow">
</head>
<body class="login login-action-login wp-core-ui">
	<div id="login">
		<h1>
			<a href="" title="<?php _e('Powered by WordPress', 'latch') ?>"><?php echo bloginfo('name'); ?></a>
		</h1>

		<?php if(!empty($two_factor_error)) { echo '<div id="login_error">' . $two_factor_error . '</div>'; } ?>

		<form name="loginform" id="loginform" action="" method="post">
			<p>
				<label for="code">Latch two-factor token:<br />
				<input type="password" name="latch_two_factor" id="latch_two_factor" class="input" value="" size="20" maxlength="6" autocomplete="off" /></label>
			</p>
			<p class="submit">
				<input type="submit" name="wp-submit" id="wp-submit"
					class="button button-primary button-large" value="<?php _e("Log In", "latch"); ?>"/>
				<input type="hidden" name="redirect_to"
					value="<?php echo site_url(); ?>/wp-admin/" />
                                <input type="hidden" name="log" value="<?php echo htmlspecialchars(stripslashes($username)); ?>" autocomplete="off" />
				<input type="hidden" name="pwd" value="<?php echo htmlspecialchars(stripslashes($password)); ?>" autocomplete="off" />
			</p>
		</form>


		<script type="text/javascript">
		function wp_attempt_focus(){setTimeout( function(){ try{d = document.getElementById('latch_two_factor'); d.focus();	d.select();} catch(e){}}, 200);}
		wp_attempt_focus();
		if(typeof wpOnload=='function')wpOnload();
		</script>
	</div>
	<div class="clear"></div>
</body>
</html>
