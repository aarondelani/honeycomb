<?php
	// Need page preferences here
	$page_short_title = "Import Customers";
	$page_title = $page_short_title;
	$customer_page_active = TRUE;
	$import_customer_page_active = TRUE;

	include 'headers.php';
	include 'vars.php';
	include '../navigation.php';

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
						<p>Get started by uploading a csv file.</p>
						<input class="form-control" type="file" id="files" name="files[]" multiple />
						<output id="list">
						</output>
					</div>
				</div>

				<ul class="nav nav-pills nav-stacked sr-only" id="navigate_tables">
					<li role="presentation" class="active"><a href="#csvpreview">CSV Preview <span class="badge" id="csv_count"></span></a></li>
					<li role="presentation"><a href="#csvmatches">Matches in Customer Database <span class="badge" id="match_count"></span></a></li>
				</ul>
				<p>Contacts are matched by First Name and Last Name and may appear multiple times on our Coolcat Records.</p>
			</div>
			<div class="col-md-8" id="table_holder"></div>
		</div>

	<!-- End Content Div -->
	</div>
</div>

<?php include 'footer.php'; ?>

<script type="text/javascript">
<?php
	$paradox_mysql_link = new mysqli($paradox_mysql_server, $paradox_mysql_user, $paradox_mysql_password, $paradox_db);
	$mysql_link = new mysqli($mysql_server, $mysql_user, $mysql_password, $honeycomb_db);

	$csvdata_check = $mysql_link->query('SELECT 1 from `csvdata`');

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

	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

	}

	$customers_table = $paradox_mysql_link->query("SELECT * from customers;");
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
		var output = ''
			output += '<span style="font-weight:bold;">' + escape(file.name) + '</span><br />\n';
			output += ' - FileType: ' + (file.type || 'n/a') + '<br />\n';
			output += ' - FileSize: ' + file.size + ' bytes<br />\n';
			output += ' - LastModified: ' + (file.lastModifiedDate ? file.lastModifiedDate.toLocaleDateString() : 'n/a') + '<br />\n';

		// read the file contents
		// printTable(file);

		$("<h3>").html("Preview of the CSV").attr('id', 'csvpreview').appendTo(content);

		new buildTable(
			{
				table_id: "csv_non_match_data_table",
				table_classes: "table blues",
				table_headers: [
					"Company Name",
					"First Name",
					"Last Name",
					"Email"
				]
			},
				content // insert into html
			);

		$("<h3>").html("Matches within the Customer Database").attr('id', 'csvmatches').appendTo(content);

		new buildTable(
			{
				table_id: "csv_matches_table",
				table_classes: "table stripes",
				table_headers: [
					"Coolcat Entry",
					"Company Name",
					"First Name",
					"Last Name",
					"Email"
				]
			},
				content // insert into html
			);

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

			csv_customer_array.push(data);

			for(var row in data) {
				new buildRow(data[row], $('#csv_non_match_data_table'));
			}

			for (var j in data) {
				for (var i = c.length - 1; i >= 0; i--) {
				// looping through customer Array
				// for(var j = data.length - 1; j>=0 ;j--){
					cust_lastName = String(c[i][2]).toLowerCase();
					cust_firstName = String(c[i][1]).toLowerCase();
					lastName = String(data[j][2]).toLowerCase();
					firstName = String(data[j][1]).toLowerCase();
					companyName = String(data[j][0]).toLowerCase();

					if ((cust_firstName == firstName) && (cust_lastName == lastName)) {
						// console.log(c[i].indexOf(companyName));
						// console.log('email',String(c[i][3]).toLowerCase(), String(data[j][3]).toLowerCase(), (String(c[i][3]).toLowerCase() == String(data[j][3]).toLowerCase()));
						matches_count = matches_count + 1;
						tempArr = [c[i][0]];
						tempArr = tempArr.concat(data[j]);
						console.log(tempArr);

						new buildRow(tempArr, $('#csv_matches_table'));

						$('#match_count').html(matches_count);
						tempArr.length = 0;
					}
				}
			};

			$('#csv_count').html(data.length);

			$body.removeClass("loading");
			return true;
		};
	};
<?php /*
function printTable(file) {
	var reader = new FileReader();
	reader.readAsText(file);
	reader.onload = function(event){
		var csv = event.target.result;
		var data = $.csv.toArrays(csv);
		var html = '';
		console.log(data);

		for(var row in data) {
			html += '<tr>\r\n';

			for(var item in data[row]) {
				html += '<td>' + data[row][item] + '</td>\r\n';
			}

			html += '</tr>\r\n';
		}
		$('#contents').html(html);
	};
	reader.onerror = function(){ alert('Unable to read ' + file.fileName); };
}
*/ ?>

$(document).ready(function(){
	if(isAPIAvailable()) {
		$('#files').bind('change', handleFileSelect);
	}
});

</script>