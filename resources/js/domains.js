document.addEventListener("DOMContentLoaded", (event) => {
	var $form = $('.new-domain-form');

	$form.on("submit", function(e) {
		e.preventDefault();
		e.stopPropagation();
		searchDomain();
	});

	$form.find('.btn-secondary').click(function() {
		searchDomain();
	});

	$form.find('input[name="domainname"]').on('keyup', function(e) {
		if (e.keyCode == 13) {
			searchDomain();
		}
	});

	if (typeof searchDomainName != 'undefined') {
		getSuggestions(searchDomainName);
	}

	// Continue with domain
	$('body').on('click', 'button[data-continue-domain]', function() {
		var $form2 = $('form[name="domain-select"]');
		var domain = $(this).data('continue-domain');
		var price = $(this).data('domain-price');
		$form2.find('input[name="domain"]').val(domain);
		$form2.find('input[name="price"]').val(price);
		$form2[0].submit();
	});

	// Select domain
	$('body').on('click', 'button[data-select-domain]', function() {
		var domain = $(this).data('select-domain');
		$form.find('input[name="domainname"]').val(domain);
		window.location.replace('/domain-search/' + domain);
	});
});

function searchDomain(form) {
	var $form = $('.new-domain-form')
	//,	$fields = $form.find('input[type="hidden"]')
	//,	data = {}
	,	domain = $form.find('input[name="domainname"]').val()
	,	url = '/domain-search/' + domain
	;

	if (domain == '') {
		return false;
	}

	window.location.replace(url);
	return false;
	/* return;
	$fields.each(function(i, input) {
		data[input.name] = input.value;
	});
	$form.attr('action', url).submit(); */
}

function getSuggestions(domain) {
	var $form = $('.new-domain-form')
	,	$fields = $form.find('input[type="hidden"]')
	,	data = {}
	,	url = '/domain-suggestion/' + domain
	,	$loader = getLoader('loader1')
	;

	$('#domain-suggestions ul').after($loader);
	$('#domain-suggestions').removeClass('hidden');
	
	$fields.each(function(i, input) {
		data[input.name] = input.value;
	});

	$.post(url, data, function(resp) {
		$loader.remove();
		render(resp);
	}, 'json');
}

function render(resp) {
	var data = resp.data;
	if (data.is_success === "1" && data.attributes && data.attributes.suggestion) {
		if (data.attributes.suggestion.items && $.isArray(data.attributes.suggestion.items)) {
			data.attributes.suggestion.items.forEach(function(item) {
				var $li = $('<li class="py-1" />').append('<button data-select-domain="'+item.domain+'" class="p-4 w-full hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white flex justify-between group"><span>' + item.domain + '</span><span class="hidden group-hover:block">Select</span></button>');
				$('#domain-suggestions ul').append($li);
			});
		}
	}
}

function getLoader(id) {
	return $(`<div role="status" class="my-10 text-center">
				<svg class="inline mr-2 w-10 h-10 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
					<path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="var(--tw-ring-color)" />
				</svg>
				<span class="sr-only">Loading...</span>
		</div>`).attr('id', id);
}