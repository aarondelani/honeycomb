// var search = location.search.substring(1);
$body = $("body");

$(document).on(
	{
		ajaxStart: function() {
			$body.addClass("loading");
		},
		ajaxStop: function() {
			$body.removeClass("loading");
		}
	}
);

$(document).ready(
	function (event) {
		$body.removeClass("loading");
	}
);

var buildTable = function (params, insert) {
	table_id = params.table_id;
	table_classes = params.table_classes;
	table_headers = params.table_headers;

	var table = $("<table>");

	if (table_id) {
		table.attr('id', table_id);
	}

	if (table_classes) {
		table.attr('class', table_classes);
	}

	if (table_headers) {
		buildRow(table_headers, table, {hasHeading: true});
	}

	table.appendTo(insert);
}

// new buildTable(
// 	{
// 		table_id: "constantinople",
// 		table_classes: "hello world",
// 		table_headers: [
// 			"Fruit",
// 			"name",
// 			"time"
// 		]
// 	},
// 		$("#wrapper") // insert into html
// 	);

var buildRow = function (arr, table, params) {
	var arr = arr;
	var table = $(table);
	var row = $("<tr />");
	var cell = $("<td />");

	if (params == undefined) {
		var params = {
			hasHeading: false,
			cellClass: ""
		};
	} else {
		var params = params;
	}

	for (var i = arr.length - 1; i >=0; i--) {
		if (params.hasHeading && i < arr.length) {
			cell = $("<th />");
		} else {
			cell = $("<td />");
		}

		if (arr[i] != undefined) {
			t =  arr[i].toString();
		} else {
			t = "";
		}

		cell.html(t).prependTo(row);
	};

	console.log(params)

	if (params.cellClass != "") {
		row.addClass(params.cellClass);
	}

	row.appendTo(table);
};

var jsonifyUrlQuery = function (query) {
	search = query;

	return search?JSON.parse('{"' + search.replace(/&/g, '","').replace(/=/g,'":"') + '"}',
		function(key, value) { return key===""?value:decodeURIComponent(value) }):{}
}

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