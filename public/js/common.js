!function(o){function t(){o(document).on("keydown paste",".form-control",(function(t){var r;(void 0===(r=t).which||"number"==typeof r.which&&r.which>0&&!r.ctrlKey&&!r.metaKey&&!r.altKey&&8!=r.which&&9!=r.which&&13!=r.which&&16!=r.which&&17!=r.which&&20!=r.which&&27!=r.which)&&o(this).closest(".form-group").removeClass("is-empty")})).on("keyup change",".form-control",(function(){var t=o(this),r=t.closest(".form-group"),e=void 0===t[0].checkValidity||t[0].checkValidity();""===t.val()?r.addClass("is-empty"):r.removeClass("is-empty"),e?r.removeClass("has-error"):r.addClass("has-error")})).on("focus",".form-control, .form-group.is-fileinput",(function(){var t;(t=o(this)).prop("disabled")||t.closest(".form-group").addClass("is-focused")})).on("blur",".form-control, .form-group.is-fileinput",(function(){o(this).closest(".form-group").removeClass("is-focused")})).on("change",".form-group input",(function(){var t=o(this);if("file"!=t.attr("type")){var r=t.closest(".form-group");t.val()?r.removeClass("is-empty"):r.addClass("is-empty")}})).on("change",".form-group.is-fileinput input[type='file']",(function(){var t=o(this).closest(".form-group"),r="";o.each(this.files,(function(o,t){r+=t.name+", "})),(r=r.substring(0,r.length-2))?t.removeClass("is-empty"):t.addClass("is-empty"),t.find("input.form-control[readonly]").val(r)}))}o.expr[":"].notmdproc=function(t){return!o(t).data("mdproc")},document.arrive("input.form-control, textarea.form-control, select.form-control",(function(){o(this).filter(":notmdproc").data("mdproc",!0).each((function(){var t=o(this),r=t.closest(".form-group");0!==r.length||"hidden"===t.attr("type")||t.attr("hidden")||(t.wrap("<div class='form-group'></div>"),r=t.closest(".form-group")),null!==t.val()&&"undefined"!=t.val()&&""!==t.val()||r.addClass("is-empty"),r.find("input[type=file]").length>0&&r.addClass("is-fileinput")})),t()}))}(jQuery);