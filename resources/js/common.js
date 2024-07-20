(function ($) {
	// Selector to select only not already processed elements
	$.expr[":"].notmdproc = function (obj) {
		if ($(obj).data("mdproc")) {
			return false;
		} else {
			return true;
		}
	};

	function _isChar(evt) {
		if (typeof evt.which == "undefined") {
			return true;
		} else if (typeof evt.which == "number" && evt.which > 0) {
			return (
			!evt.ctrlKey
			&& !evt.metaKey
			&& !evt.altKey
			&& evt.which != 8  // backspace
			&& evt.which != 9  // tab
			&& evt.which != 13 // enter
			&& evt.which != 16 // shift
			&& evt.which != 17 // ctrl
			&& evt.which != 20 // caps lock
			&& evt.which != 27 // escape
			);
		}
		return false;
	}

	function _addFormGroupFocus(element) {
		var $element = $(element);
		if (!$element.prop('disabled')) {  // this is showing as undefined on chrome but works fine on firefox??
			$element.closest(".form-group").addClass("is-focused");
		}
	}

	function _removeFormGroupFocus(element) {
		$(element).closest(".form-group").removeClass("is-focused");
	}

	function attachEvents() {
      var validate = true;

      $(document)
          .on("keydown paste", ".form-control", function(e) {
              if (_isChar(e)) {
                  $(this).closest(".form-group").removeClass("is-empty");
              }
          })
          .on("keyup change", ".form-control", function() {
              var $input = $(this);
              var $formGroup = $input.closest(".form-group");
              var isValid = (typeof $input[0].checkValidity === "undefined" || $input[0].checkValidity());

              if ($input.val() === "") {
                  $formGroup.addClass("is-empty");
              } else {
                  $formGroup.removeClass("is-empty");
              }

              // Validation events do not bubble, so they must be attached directly to the input: http://jsfiddle.net/PEpRM/1/
              //  Further, even the bind method is being caught, but since we are already calling #checkValidity here, just alter
              //  the form-group on change.
              //
              // NOTE: I'm not sure we should be intervening regarding validation, this seems better as a README and snippet of code.
              //        BUT, I've left it here for backwards compatibility.
              if (validate) {
                  if (isValid) {
                      $formGroup.removeClass("has-error");
                  } else {
                      $formGroup.addClass("has-error");
                  }
              }
          })
          .on("focus", ".form-control, .form-group.is-fileinput", function() {
              _addFormGroupFocus(this);
          })
          .on("blur", ".form-control, .form-group.is-fileinput", function() {
              _removeFormGroupFocus(this);
          })
          // make sure empty is added back when there is a programmatic value change.
          //  NOTE: programmatic changing of value using $.val() must trigger the change event i.e. $.val('x').trigger('change')
          .on("change", ".form-group input", function() {
              var $input = $(this);
              if ($input.attr("type") == "file") {
                  return;
              }

              var $formGroup = $input.closest(".form-group");
              var value = $input.val();
              if (value) {
                  $formGroup.removeClass("is-empty");
              } else {
                  $formGroup.addClass("is-empty");
              }
          })
          // set the fileinput readonly field with the name of the file
          .on("change", ".form-group.is-fileinput input[type='file']", function() {
              var $input = $(this);
              var $formGroup = $input.closest(".form-group");
              var value = "";
              $.each(this.files, function(i, file) {
                  value += file.name + ", ";
              });
              value = value.substring(0, value.length - 2);
              if (value) {
                  $formGroup.removeClass("is-empty");
              } else {
                  $formGroup.addClass("is-empty");
              }
              $formGroup.find("input.form-control[readonly]").val(value);
          });
	}

	document.arrive('input.form-control, textarea.form-control, select.form-control', function () {

		$(this).filter(":notmdproc").data("mdproc", true)
		.each(function () {
			var $input = $(this);

			// Requires form-group standard markup (will add it if necessary)
			var $formGroup = $input.closest(".form-group"); // note that form-group may be grandparent in the case of an input-group
			if ($formGroup.length === 0 && $input.attr('type') !== "hidden" && !$input.attr('hidden')) {
				$input.wrap("<div class='form-group'></div>");
				$formGroup = $input.closest(".form-group"); // find node after attached (otherwise additional attachments don't work)
			}

			// Set as empty if is empty (damn I must improve this...)
			if ($input.val() === null || $input.val() == "undefined" || $input.val() === "") {
				$formGroup.addClass("is-empty");
			}

			// Support for file input
			if ($formGroup.find("input[type=file]").length > 0) {
				$formGroup.addClass("is-fileinput");
			}

		});

		attachEvents();
	});

})(jQuery);


