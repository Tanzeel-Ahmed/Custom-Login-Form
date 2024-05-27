// Shortcode for user login form
function custom_user_login_form_shortcode() {
	ob_start();
?>

<div id="custom-login-form-container">
	<div class="login-form failed-alert">
		<div class="failed-alert-content">
			<div class="failed-alert-icon icon-alert"><img src="https://www.ecarebehavioralinstitute.com/wp-content/uploads/2024/01/exclamation-icon.png"></div>
			<div class="failed-alert-message"> </div>
		</div>
	</div>
	<form id="custom-login-form" action="" method="post">
		<input type="hidden" name="action" value="custom_user_login">
		<p>
			<label for="email" class="required-label">Email:</label>
			<input type="email" name="email" required placeholder="E.g; jane@campany.com">
		</p>
		<p class="pass-field">
			<label for="password" class="required-label">Password:</label>
			<input type="password" name="password" id="password-field" required placeholder="**********">
			<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
		</p>
		<p class="remember-me">
			<input type="checkbox" name="remember_me" id="remember_me">
			<label for="remember_me">Keep me logged in on this device</label>
		</p>
		<button type="button" id="login-btn">Login</button>
		<p class="forgot-password"><a href="<?php echo wp_lostpassword_url(); ?>">I Forgot My Password?</a></p>
	</form>
</div>
<?php

	return ob_get_clean();
}
add_shortcode('custom_user_login_form', 'custom_user_login_form_shortcode');

// Handle login form submission using AJAX
function custom_user_login_form_ajax() {
	$result_message = ''; // Initialize the result message

	if (isset($_POST['action']) && $_POST['action'] === 'custom_user_login') {
		$email = sanitize_email($_POST['email']);
		$password = $_POST['password'];
		$remember_me = isset($_POST['remember_me']) && $_POST['remember_me'] ? true : false;

		// Perform your login logic here
		// Example: You can use wp_signon() function
		$creds = array(
			'user_login'    => $email,
			'user_password' => $password,
			'remember'      => true,
		);
		$user_signon = wp_signon($creds, false);

		if (!is_wp_error($user_signon)) {
			// Login successful
			$result_message = 'success';
		} else {
			// Login failed
			$result_message = 'Incorrect email or password. Please try again';
		}
	}

	echo $result_message;
	die(); // This is important to end the AJAX request
}
add_action('wp_ajax_custom_user_login', 'custom_user_login_form_ajax');
add_action('wp_ajax_nopriv_custom_user_login', 'custom_user_login_form_ajax');
