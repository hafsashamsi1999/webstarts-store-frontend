function validate_signup() {
	// validate the data
	if ($("#fullname").val().length < 1 || $("#fullname").val() == 'Full Name') {
		alert("You must enter your full name.");
		$("#fullname").focus();
		return false;
	}
	if (!validate_email($("#username").val()) || $("#username").val() == 'Email Address'){
		alert("You must enter a valid email.");
		$("#username").focus();
		return false;
	}
	if ($("#password").val().length < 6){
		alert("Your password must be at least 6 characters.");
		$("#password").focus();
		return false;
	}

	return true;
}

function validate_email(email) {
	var re = /^[^@]+@[^@.]+.*\.[a-zA-Z]{2,}$/i;
	return re.test(email);
}

var StripeElements = null;
document.addEventListener("DOMContentLoaded", (event) => {

	if (window.stripe_public_key) {
		StripeElements = stripeInit(stripe_public_key);
	}

	try {
		$('input[name="tz"]').val(Intl.DateTimeFormat().resolvedOptions().timeZone);
	} catch(e) {}

	$('#signup-button').focus();

    /* $('#signup-form').on('submit', function(e) {
		return validate_signup();
    }); */

    $('#signup-button:not(.disabled)').on('click', function(e) {

		$(this).addClass('disabled');
		// Prevent the default form submission
		e.preventDefault();

        if (validate_signup()) {
			if (StripeElements) {

				StripeElements.stripe.createToken(StripeElements.card).then(function(result) {
					if (result.error) {
						$(this).removeClass('disabled');
						$("#card-error").html(
							'<div class="alert alert-danger"><div class="alert-icon"><i class="material-icons">error_outline</i></div><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="material-icons">clear</i></span></button>' + result.error.message + '</div>'
						).show();
					} else {
						$("#card-error").empty().hide();
						$('input[name="stripecardtoken"]').val(result.token.id);
						$("#signup-form").submit();
					}
				});
				
			} else {
				$("#signup-form").submit();
			}
            /* grecaptcha.ready(function() {
                grecaptcha.execute(recaptcha_sitekey, {action: recaptcha_action}).then(function(token) {
                    $('#signup-form[name="recaptcha_token"]').val(token);

					var fmData = {};
					$('#signup-form input').each(function(i, inp) {
						var name = inp.name || '';
						if(name != '') {
							fmData[name] = inp.value;
						}
					});

					console.log(fmData);
                    //$("#signup-form").submit();
					// var url = 'https://www.webstarts.com/api/v1/signup';
					// $.post(url, fmData, function(data) {
					// 	if(data.success) {
					// 		window.location.href = 'https://www.webstarts.com/cadmin/dashboard';
					// 	} else {
					// 		alert(data.message);
					// 		$('#signup-button').removeClass('disabled');
					// 	}
					// });
                });
            }); */
        }
    });

});

