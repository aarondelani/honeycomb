body = $("body");

function cmdBack() {
    window.history.back();
}

$(document).on(
	{
		ajaxStart: function() {
			body.addClass("loading");
		},
		ajaxStop: function() {
			body.removeClass("loading");
		}
	}
);

$(document).ready(
	function (event) {
		body.removeClass("loading");

		$('[data-toggle="tooltip"]').tooltip();
	}
);

var createInputProperty = function (attr, val, appendTo) {
	var inputHidden = $('<input type="hidden">');
	var appendToForm = appendTo;
	var checkInput = $('input[name='+ attr +']');

	// Check first to see if this input exists
	if (checkInput.length == 0) {
		inputHidden.attr('name', attr);
		inputHidden.attr('value', val);
		inputHidden.appendTo(appendToForm);
	} else {
		// If it does, replace the value
		checkInput.attr('value', val);
	}
}

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

var _disp_info = function (string) {
	var body = $('body');
	var comp = $('<div class="info-comp">');
	var compContent = $('<div class="info-comp-content">');

	compContent.html(string);

	comp.append(compContent);
	body.append(comp);

	comp.addClass('in');

	// Displaying and hiding func through js for browser support
	setTimeout(
		function(){
			comp.addClass('displayed');
		}, 1);
	setTimeout(
		function(){
			comp.addClass('out');
		}, 2000);
	setTimeout(
		function(){
			comp.removeClass('displayed');
		}, 3000);
	setTimeout(
		function(){
			comp.removeClass('in');
			comp.removeClass('out');
		}, 3500);
	setTimeout(
		function(){
			comp.remove()
		}, 3501);
};

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

	if (params.cellClass != "") {
		row.addClass(params.cellClass);
	}

	row.appendTo(table);
};

var jsonifyUrlQuery = function (query) {
	search = query;

	return search?JSON.parse(
		'{"' + search.replace(/&/g, '","').replace(/=/g,'":"') + '"}',
		function(key, value) {
			return key === ""?value:decodeURIComponent(value)}
		):{}
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

						arg({success: true, response: response});
					}

					if(reset) {
						form.trigger('reset');
					}

					// console.log(response);

					return response;
				}
			});

			return false; // avoid to execute the actual submit of the form.
		}
	);
};

var compareVals = function(obj) {
	inputs = obj;

	inputs.each(function(i){
		var i = $(this);
		var discrepancy = 0;

		i.on('keypress change', function (){
			var inputVal = i.val();
			var inputParent = i.parent('td');
			var compareTo = $('.'+i.attr('data-compare')).val();

			if (parseInt(inputVal) > parseInt(compareTo)) {
				console.log(true, "still greater than");

				if(inputParent.hasClass('has-warning')) {
					inputParent.removeClass('has-warning');
				}
			} else {
				console.log(false, "LESS THAN");

				if(!inputParent.hasClass('has-warning')) {
					inputParent.addClass('has-warning');
				}
			}
		});

		console.log(i.attr('data-compare'));
	});
};

function _removeFromArr (arr, string) {
	var index = arr.indexOf(string);

	if (index > -1) {
		arr.splice(index, 1);
	}
};

// var inputs = $('.input-data');
// compareVals(inputs);
// MARKUP:
// <table class="table" id="sizing">
// 		<thead>
// 	<tr>
// 			<th>Size 1</th>
// 			<th>Size 2</th>
// 			<th>Size 3</th>
// 			<th>Size 4</th>
// 			<th>Size 5</th>
// 	</tr>
// 		</thead>
// 	<tr>
// 		<td><input data-compare="size-1" class="input-data form-control" type="number" placeholder="0" value="0"></td>
// 		<td><input data-compare="size-2" class="input-data form-control" type="number" placeholder="0" value="0"></td>
// 		<td><input data-compare="size-3" class="input-data form-control" type="number" placeholder="0" value="0"></td>
// 		<td><input data-compare="size-4" class="input-data form-control" type="number" placeholder="0" value="0"></td>
// 		<td><input data-compare="size-5" class="input-data form-control" type="number" placeholder="0" value="0"></td>
// 	</tr>
// 	<tr>
// 		<td><input class="form-control size-1" type="number" value="0"></td>
// 		<td><input class="form-control size-2" type="number" value="2"></td>
// 		<td><input class="form-control size-3" type="number" value="5"></td>
// 		<td><input class="form-control size-4" type="number" value="8"></td>
// 		<td><input class="form-control size-5" type="number" value="9"></td>
// 	</tr>
// </table>
console.log('Hello... is it me you\'re looking for?');