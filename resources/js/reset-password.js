/**
 * Validates the form data including password and confirm password.
 *
 * @return {boolean} true if the form data is valid, false otherwise
 */
function validate_form() {
	// validate the data
    let password = trim($("#password").val())
    ,   confirm = trim($("#password_confirm").val())
    ;

    if (password.length < 6) {
		alert("Your password must be at least 6 characters long.");
		$("#password").focus();
		return false;        
    }

    if (password.length > 64) {
        alert("Your password must not be greater than 64 characters long.");
        $("#password").focus();
        return false;
    }

	if (password != confirm) {
		alert("Your password does not match with your confirm password.");
		$("#password_confirm").focus();
		return false;
	}

	return true;
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

    $('#reset-password-form').on('submit', function(e) {
        return validate_form();
    });

    $('#password').focus();
});