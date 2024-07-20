function validate_login() {
	// validate the data
	if (!validate_email($("#username").val())) {
		alert("You must enter a valid email.");
		$("#username").focus();
		return false;
	}

	if ($("#password").val().length < 6) {
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


document.addEventListener("DOMContentLoaded", (event) => {

	// Form Field Focus
    $(document).ready(function () {
    	 // Check input values on page load
        $('.form-group input').each(function () {
            checkAutofill($(this));
        });

        // Check input values on focus and blur events
        $('.form-group input').on('load', function () {
            checkAutofill($(this));
        });

        function checkAutofill(input) {
    		setTimeout(function () {
    		    if (input.val() !== '') {
            		input.parent('.form-group').addClass('is-focused');
    		    } else {    
            		input.parent('.form-group').addClass('is-focused');
    		    }
    		}, 100);
		}
    });

    $('#login-form').on('submit', function(e) {
        return validate_login();
    });

    $('#username').focus();

    //$('#login-button').focus();

    
});
