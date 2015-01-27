<!DOCTYPE html>
<?php
	// Need page preferences here
	$page_title = "Customers";
	$customer_page_active = TRUE;

	include 'headers.php';
	include 'vars.php';
	include '../navigation.php';

	$paradox_mysql_link = new mysqli($paradox_mysql_server, $paradox_mysql_user, $paradox_mysql_password, $paradox_db);
	$mysql_link = new mysqli($mysql_server, $mysql_user, $mysql_password, $honeycomb_db);

	$tableCheck = $mysql_link->query('SELECT 1 from `csvdata`');

	if ($tableCheck === TRUE){
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
			echo "Created Insert CSV DB";
		}
	}

	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		
	}
/*
<script src="http://jquery-csv.googlecode.com/git/src/jquery.csv.js"></script>
*/
?>
<script src="<?php echo "$host";?>/javascripts/jquery.csv.js"></script> 

<div id="wrapper" class="container-fluid theme-showcase" role="main">
	<div id="content">
		<h1 class="hidden-accessible sr-only">Customers</h1>

		<nav class="navbar navbar-default" id="client_bar">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#client_bar" aria-expanded="false" aria-controls="client_bar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/customers">Customers</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a href="#">Add Customer</a></li>
				<li><a href="#">Link</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Tools <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#">Import &amp; Compare</a></li>
					</ul>
				</li>
			</ul>
		</nav>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Upload CSV</h3>
			</div>
			<div class="panel-body" id="inputs">
				<p>Get started by uploading a csv files:</p>
				<input class="form-control" type="file" id="files" name="files[]" multiple />
				<output id="list">
				</output>
			</div>
		</div>
		<!-- <form class="client-search" role="search">
			<input id="search_customer_table_input" type="text" class="form-control" aria-label="Seach customers and contacts" placeholder="Search customers and contacts...">
			<div class="input-group">
				<div class="input-group-btn">
					<button type="button" class="btn btn-default">Search</button>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					<span class="caret"></span>
					<span class="sr-only">Toggle Dropdown</span>
				</button>
				<ul class="dropdown-menu dropdown-menu-right" role="menu">
					<li><a href="#">Action</a></li>
					<li><a href="#">Another action</a></li>
					<li><a href="#">Something else here</a></li>
					<li class="divider"></li>
					<li><a href="#">Separated link</a></li>
				</ul>
				</div>
			</div>
		</form> -->

		<table class="table blues" id="contents" border>

		</table>

		<!-- <table id="customer_table" class="table blues">
			<thead>
				<tr>
					<th>Customer</th>
					<th>Contact First Name</th>
					<th>Contact Last Name</th>
					<th>Contact Email</th>
				</tr>
			</thead> -->
			<?php
				// $customers_table = $paradox_mysql_link->query("SELECT * from customers;");

				// if ($customers_table->num_rows > 0) {
				// 	// output data of each row
				// 	while($row = $customers_table->fetch_assoc()) {
				// 		echo "<tr><td>" . $row["cust_name"]. "</td><td>". $row["cust_cont_firstname"]. "</td><td>". $row["cust_cont_lastname"]. "</td><td>" . $row["cust_cont_email"] . "</td></tr>";
				// 	}
				// } else {
				// 	echo "<tr><td colspan=\"100%\" class=\"empty-row\">0 results</td></tr>";
				// }
			?>
		<!-- </table> -->


	<!-- End Content Div -->
	</div>

</div>

<?php
$mysql_link->close();

include 'footer.php';
?>
<script type="text/javascript">
	<?php
		$customers_table = $paradox_mysql_link->query("SELECT * from customers LIMIT 100;");
		$companies = "";
		$firstNames = "";
		$lastNames = "";

		$array = array('a' => 1, 'b' => 2,'c' => 3, 'd' => 2);
		$lastElementKey = key($array);

		if ($customers_table->num_rows > 0) {
			// output data of each row
			while($row = $customers_table->fetch_assoc()) {
				$comma = ",";
				if ($row == $lastElementKey) {
					$comma = "";
				};
				$companies .= "\"" . addslashes($row["cust_name"]) . "\"" . $comma;
				$firstNames .= "\"" . addslashes($row["cust_cont_firstname"]) . "\"" . $comma;
				$lastNames .= "\"" . addslashes($row["cust_cont_lastname"]) . "\"" . $comma;
				$emailes .= "\"" . addslashes($row["cust_cont_email"]) . "\"" . $comma;

				// echo "<tr><td>" . $row["cust_name"]. "</td><td>". $row["cust_cont_firstname"]. "</td><td>". $row["cust_cont_lastname"]. "</td><td>" . $row["cust_cont_email"] . "</td></tr>";
			}
		} else {
			$companies = "NULL";
			$firstNames = "NULL";
			$lastNames = "NULL";
			$emailes = "NULL";
		}
	?>

	var companiesArray = [<?php echo $companies; ?>];
	var firstNamesArray = [<?php echo $companies; ?>];
	var lastNamesArray = [<?php echo $companies; ?>];
	var companiesEmail = [<?php echo $emailes; ?>];

	var b = ["ACS-EA MAKING STRIDES 2010 EASTERN DIVISION","ACS-GA-GEORGIA OFFICE 2011","ACS-ID-COEUR D\'ALENE-TOUR de COEUR 2012","ACS-IL ACS CHICAGO 2010 MAKING STRIDES","ACS-LA ACS-MID SOUTH NEW ORLEANS LOUISIANA 2012","ACS-MA BOSTON 2010","ACS-MIDWEST DIVISION 2010","ACS-MO-KANSAS CITY 2002","ACS-MO-ROLLA-  SEE HEARTLAND 2005","ACS-NATL BIDDING 2010 AMERICAN CANCER SOCIETY","ACS-NATL FUNDRAISE-DEVELOP 2010-PHOENIX OFFICE 2010","ACS-NATL NATIONAL OFFICE 2011","ACS-NATL-RELAY4LIFE BUSINESS UNIT(VENDING)-2005","ACS-NY NEW YORK OFFICE 2010","ACS-OR-PORTLAND-RELAY4LIFE 2000","ACTION PLUS SPORTS - GIRLS ON THE RUN 2013","ACTIVE DIVAS ROCK 2010 MARCIE GOODEN","ACTIVE IMPRINTS 2012","ACTIVE NETWORK 2007","ACTIVE NETWORK-ACTIVE MKTG GROUP 2005","ACTIVE-MIKE COLEMAN-TRAINING PROGRAMS 2006","ACTIVE.COM SPORTS MKTG GROUP 2010 ACTIVE NETWORK","ACVO AMERICAN COLLEGE OF VETERINARY OPHTHALMOLOGISTS 2014","AD AGENCY 2006","AD-ROAD RACE MANAGEMENT 2006","ADA-CA LOS ANGELES WESTERN DIVISION AREA II","ADA-CA SAN JOSE 2008","ADA-FL CENTRAL FLORIDA AREA 2007","ADA-GA ATLANTA 2003","ADA-NY NEW YORK NY 2002","ADA-OR SUMMIT TO SURF 2002","ADA-OR-WALK 2004","ADA-TX DALLAS NATL DIR 2003","ADA-VA NATIONAL 2003","ADA-WA AFFILIATE 2003","ADA-WA SEATTLE TOUR DE CURE 2008","ADAPTIVE ATHLETICS ASSOCIATION","ACME RUNNING COMPANY 2008","ACS-EA MAKING STRIDES 2010 EASTERN DIVISION"];

	function compareArrays (c,csv,is_matched) {
		var emptyArray = [];
		var is_matched = is_matched;
		// body...
		for(i=0;i<c.length;i++){
			// Looping through company array
			for(j=0;j<csv.length;j++){
				// Looping through CSV array
				if (is_mached) {
					if(csv[j] == c[i]){
						emptyArray.push(csv[j]);
						// continue outerloop;
					}
				} else {
					if(csv[j] !== c[i]){
						emptyArray.push(csv[j]);
						// continue outerloop;
					}
				}
			}
		}

		return emptyArray;
	};

	// var matchedCompanies = new compareArrays(companiesArray, b);

	// console.log(matchedCompanies);

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
		console.log(new buildCSVArr(file, lastNamesArray, 2, false));

		// post the results
		$('#list').append(output);
	}

	var lastNames = [];

	function buildCSVArr (file,company_col,csv_col, is_matched) {
		// Param is ARR index of searching field
		var reader = new FileReader();
		var emptyArray = [];

		reader.readAsText(file);

		reader.onload = function (event) {
			var csv = event.target.result;
			var data = $.csv.toArrays(csv);

			for (var row in data) {
				// looping through CSV

				var matches = new compareArrays(company_col, csv_col, is_matched);

				console.log(data[row][csv_col]);

				for (var item in data[row]) {
				}

				return matches;
			}

			return true;
		}
	}

function printUsingBuildRow(file, table) {
	var reader = new FileReader();
	reader.readAsText(file);

	reader.onload = function(event){
		var csv = event.target.result;
		var data = $.csv.toArrays(csv);
		var html = '';

		for(var row in data) {
			console.log(row);

			buildRow(data[row], table);

			for(var item in data[row]) {
			}
		}
		// $('#contents').html(html);
	};

	reader.onerror = function(){ alert('Unable to read ' + file.fileName); };
}

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

// var customer_table = $('#customer_table').DataTable({
// 	"search": {
// 		"regex": true,
// 		"smart": true
// 	}
// });

$(document).ready(function(){
	if(isAPIAvailable()) {
		$('#files').bind('change', handleFileSelect);
	}
});

</script>