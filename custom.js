jQuery(document).ready(function ($) {
		$('#login-btn').on('click', function () {
			// Use AJAX to submit the form
			$.ajax({
				type: 'POST',
				url: '<?php echo admin_url('admin-ajax.php'); ?>',
				data: {
					action: 'custom_user_login', // Updated action for login form
					email: $('#custom-login-form input[name="email"]').val(),
					password: $('#custom-login-form input[name="password"]').val(),
					remember_me: $('#custom-login-form input[name="remember_me"]').is(':checked') ? 1 : 0,
				},
				success: function (response) {
					if (response === 'success') {
						// Redirect to the dashboard page
						window.location.href = '<?php echo home_url('/my-dashboard/?tab=enrolled-courses'); ?>';
					} else {
						// Display the error message in the div and show the failed-alert div
						$('.failed-alert-message').html(response);
						$('.login-form.failed-alert').show();
					}
				}
			});
		});

		$(".toggle-password").click(function () {
			$(this).toggleClass("fa-eye fa-eye-slash");
			var input = $($(this).attr("toggle"));
			if (input.attr("type") == "password") {
				input.attr("type", "text");
			} else {
				input.attr("type", "password");
			}
		});

		// Add event listener to hide failed-alert on input field click
		$('#custom-login-form input').on('click', function () {
			$('.login-form.failed-alert').hide();
			$('.failed-alert-message').html(''); // Clear the error message
		});
	});
