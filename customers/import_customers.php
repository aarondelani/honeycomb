<!DOCTYPE html>
<?php
	// Need page preferences here
	$page_short_title = "Import Customers";
	$page_title = $page_short_title;
	$customer_page_active = TRUE;
	$import_customer_page_active = TRUE;
	// $dataTables = TRUE;

	include '../admin/vars.php';
	include '../admin/headers.php';

	include '../navigation.php';

	$mysql_link = new mysqli($mysql_server, $mysql_user, $mysql_password, $honeycomb_db);

	$csvdata_check = $mysql_link->query('SELECT 1 from `csvdata`');

	$paradox_mysql_link = new mysqli($paradox_mysql_server, $paradox_mysql_user, $paradox_mysql_password, $paradox_db);

	$customers_table = $paradox_mysql_link->query("SELECT * from customers;");
?>

<script src="<?php echo "$host";?>/javascripts/jquery.csv.js"></script>

<div id="wrapper" class="container-fluid theme-showcase" role="main">
	<div id="content">
		<h1 class="hidden-accessible sr-only">Customers</h1>

		<?php
			include 'customer_navigation.php'
		?>

		<div class="row">
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Upload CSV</h3>
					</div>
					<div class="panel-body" id="inputs">
						<p>Get started by uploading a csv file:</p>
						<input class="form-control" type="file" id="files" name="files[]" multiple />
						<output id="list">
						</output>
					</div>
				</div>

			</div>
			<div class="col-md-8">
				<div id="navigate_tables" class="panel panel-success sr-only">
					<div class="panel-heading">
						<h3 class="panel-title">CSV Preview <span class="badge" id="csv_count"></span> Entries</h3>
					</div>
					<div class="panel-body toggle-matches-area">
						<span class="toggle-matches-form">
							<input type="checkbox" aria-label="Toggle Matches in DB" name="toggle_matches" id="toggle_matches">
							<label for="toggle_matches"><span class="label label-warning" id="match_count"></span> Matches in the Coolcat Database</label>
						</span>
					</div>
				</div>

				<p>Contacts are matched by First Name and Last Name and may appear multiple times on our Coolcat Records.</p>
			</div>
			<div id="table_holder"></div>
		</div>


<?php
	// if ($customers_table->num_rows > 0) {
	// 	// output data of each row
	// 	while($row = $customers_table->fetch_assoc()) {
	// 		$mstrng = "/(\*DO NOT SELL\*|\*DO NOT QUOTE\*|\*DO NOT QTE\*|ACS\-|ZZB|S2L|ZZJ|ZZK|SCRN|ASI\-|ZZV|ZZE|RUN|RETAIL\-|NYRR\-|MAR\-|ZZDL|EM\-|BTL|BIKE\-|ALA\-|WA\-|TRI\-|CA|ZZSHOW|ZZS|ZZQ|ZZO|ATS|RRCA\-|ZZM|ZZMMAP|ZZLN|ZZLM|ZZLDR|ZZLDN|AHA\-|NY|ZZJFU|SHOW|SCRN\-A|RRCA\-|RRCA\-TX\-|RRCA\-VT\-|RRM|RSM|RRCA\-OH\-|RRCA\-NJ\-|RRCA\-NY|RFC\-WA\-|RFC|PROD\-|PRO\-|PRO|PARK\-|LLS\-WA)(.*)/";
	// 		$custName_parsed = mysql_escape_string($row["cust_name"]);

	// 		$replacement = '$2","$1';

	// 		$custName_parsed = preg_replace($mstrng, $replacement, $custName_parsed);;
	// 		$custName_parsed = strtolower($custName_parsed);

	//  		echo "\"0\",\"" . mysql_escape_string($row["cust_id"]) . "\",\"" . ucwords($custName_parsed). "\"<br>";
	// 	}
	// } else {
	// }
?>

	<!-- End Content Div -->
	</div>
</div>

<?php

	include '../admin/footer.php';

?>
<script type="text/javascript">
<?php

	if ($csvdata_check === TRUE){
	} else {
		$insert = "CREATE TABLE IF NOT EXISTS `csvdata` (
			`ID` int(10) NOT NULL AUTO_INCREMENT,
			`company` varchar(50),
			`firstname` varchar(50),
			`lastname` varchar(50),
			`email` varchar(50),
			`notes` BLOB,
			PRIMARY KEY (`ID`)
		);";

		if ($mysql_link->query($insert) === TRUE){
			// echo "Created Insert CSV DB";
		}
	}

	$company_table = "";

	if ($customers_table->num_rows > 0) {
		// output data of each row
		while($row = $customers_table->fetch_assoc()) {
			$company_table .= "[\"" . mysql_escape_string($row["cust_name"]) . "\", \"" . mysql_escape_string($row["cust_cont_firstname"]) . "\", \"" . mysql_escape_string($row["cust_cont_lastname"]) . "\", \"" . mysql_escape_string($row["cust_cont_email"]) . "\"],";
		}
	} else {
		$company_table = "[]";
	}

	$paradox_mysql_link->close();
	$mysql_link->close();
?>

	var companiesArray = [<?php echo $company_table; ?>];
	var content = $("#table_holder");

	function isAPIAvailable() {
		// Check for the various File API support.
		if (window.File && window.FileReader && window.FileList && window.Blob) {
		  // Great success! All the File APIs are supported.
		  return true;
		} else {
		  // source: File API availability - http://caniuse.com/#feat=fileapi
		  // source: <output> availability - http://html5doctor.com/the-output-element/
		  document.writeln('The HTML5 APIs used in this form are only available in the following browsers:<br />');
		  // 6.0 File API & 13.0 <output>
		  document.writeln(' - Google Chrome: 13.0 or later<br />');
		  // 3.6 File API & 6.0 <output>
		  document.writeln(' - Mozilla Firefox: 6.0 or later<br />');
		  // 10.0 File API & 10.0 <output>
		  document.writeln(' - Internet Explorer: Not supported (partial support expected in 10.0)<br />');
		  // ? File API & 5.1 <output>
		  document.writeln(' - Safari: Not supported<br />');
		  // ? File API & 9.2 <output>
		  document.writeln(' - Opera: Not supported');
		  return false;
		}
	}

	function handleFileSelect(evt) {
		var files = evt.target.files; // FileList object
		var file = files[0];

		// read the file metadata
		var output = '<strong class="csv-file-name">' + decodeURIComponent(escape(file.name)) + '</strong>\n'
			output += '<ul>\n';
			output += '<li>FileType: ' + (file.type || 'n/a') + '</li>\n';
			output += '<li>FileSize: ' + file.size + ' bytes</li>\n';
			output += '<li>LastModified: ' + (file.lastModifiedDate ? file.lastModifiedDate.toLocaleDateString() : 'n/a') + '</li>\n';
			output += '</ul><hr>';

		new compareArrays(companiesArray, file);

		$("#navigate_tables").removeClass('sr-only');

		// post the results
		$('#list').append(output);
	}

	csv_customer_array = [];

	function compareArrays (c,file,col) {
		var reader = new FileReader();

		reader.readAsText(file);

		$body.addClass("loading");

		reader.onload = function (event) {
			var csv = event.target.result;
			var data = $.csv.toArrays(csv);
			var matches_count = 0;
			var non_matches_count = 0;
			var holder = [];
			var cell_class = "";

			csv_customer_array.push(data);

			$("<h3>").html("Matches within the Customer Database").attr('id', 'csvmatches').appendTo(content);

			new buildTable(
				{
					table_id: "csv_table_display",
					table_classes: "table blues",
					table_headers: data[0]
				},
					content // insert into html
				);

			loopcsv:
			for (var j = data.length - 1; j >= 0; j--) {
				companyName = String(data[j][0]).toLowerCase();
				lastName = String(data[j][2]).toLowerCase();
				firstName = String(data[j][1]).toLowerCase();

				tempCSVArr = data[j];

				noName = false;

				if ((lastName == "") || (firstName == "")) {
					noName = true;
				}

				loopcontacts:
				for (var i = c.length - 1; i >= 0; i--) {
					cust_companyName = String(c[i][0]).toLowerCase();

					if (noName) {
						var tempReg = new RegExp(companyName);

						if (cust_companyName.search(tempReg) > 0) {
							matches_count = matches_count + 1;

							tempCSVArr = tempCSVArr.concat([c[i][0]]);
							cell_class = "has-match";

							$('#match_count').html(matches_count);
						}
					} else {
						cust_lastName = String(c[i][2]).toLowerCase();
						cust_firstName = String(c[i][1]).toLowerCase();

						if ((cust_firstName == firstName) && (cust_lastName == lastName)) {
							matches_count = matches_count + 1;

							tempCSVArr = tempCSVArr.concat([c[i][0]]);
							cell_class = "has-match";

							$('#match_count').html(matches_count);
						}
					}

				}

				new buildRow(tempCSVArr, $('#csv_table_display'), {cellClass: cell_class});

				tempCSVArr.length = 0;
				cell_class = "";
			};

			$('#csv_count').html(data.length);

			$body.removeClass("loading");

			if (matches_count <= 0) {
				$('.toggle-matches-area').addClass('sr-only');
			}

			return true;
		};
	};

	$('.toggle-matches-area').bind(
		'change',
		function (event) {
		$('#csv_table_display').toggleClass('display-matches');
	});

	$(document).ready(
		function(){
			if(isAPIAvailable()) {
				$('#files').bind('change', handleFileSelect);
			}
		}
	);
</script>
