// var search = location.search.substring(1);

var jsonifyUrlQuery = function (query) {
	search = query;

	return search?JSON.parse('{"' + search.replace(/&/g, '","').replace(/=/g,'":"') + '"}',
		function(key, value) { return key===""?value:decodeURIComponent(value) }):{}
}

var buildRow = function (parent, arr, table) {
	var parent = $(parent);
	var arr = arr;
	var table = $(table);
	var row = $("<tr />");

	for (var i = 0; i < arr.length; i++) {
		arr[i];

		if (arr[i] != undefined) {
			t =  arr[i].toString();
		} else {
			t = ""
		}

		$("<td />").html(t).appendTo(row);
	};

	row.appendTo(table);
};

// ajaxifyForm, takes a simple form magically ajaxify's it.
// First parameter is the form itself. The form needs to have a designated action to it, otherwise it will not create a request.
// Second parameter is for the action that happens if the transaction is a success.
// The third parameter is whether or not we want to reset the form
var ajaxifyForm = function (form, success, reset) {
	var form = $(form);
	var arg = success;

	$(form).on(
		'submit',
		function (event) {
			event.preventDefault();

			$.ajax({
				type: form.attr('method'),
				url: form.attr('action'),
				data: form.serialize(),
				dataType: 'text',
				processData: false,
				contentType: 'application/x-www-form-urlencoded',
				success: function (response) {
					if (arg !== undefined) {
						data = jsonifyUrlQuery(decodeURIComponent(form.serialize()));

						arg(form,data);
					}

					if(reset) {
						form.trigger('reset');
					}
				}
			});

			return false; // avoid to execute the actual submit of the form.
		}
	);
};

// Filter Customer Page