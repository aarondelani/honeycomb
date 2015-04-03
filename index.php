<?php
	// Need page preferences here
	$page_title = "";
	$body_class = "";
	$home_page_active = TRUE;
	$autocomplete = TRUE;

	$query = "SELECT `paradox`.`inv_item`.`itemid` AS `itemid`, inv_item.style AS Style, inv_item.color AS Color, inv_item.styleinfo AS Fabric, inv_item.item_brand AS Brand, inv_item.item_pattern, inv_item.item_fit AS Fit, inv_item.item_origin AS Origin, inv_item.image AS image, (`oh`.`size_os_oh` - `so`.`size_os_commit`) AS `OS`, (`oh`.`size_2xs_oh` - `so`.`size_2xs_commit`) AS `2XS`, (`oh`.`size_xs_oh` - `so`.`size_xs_commit`) AS `XS`, (`oh`.`size_s_oh` - `so`.`size_s_commit`) AS `S`, (`oh`.`size_m_oh` - `so`.`size_m_commit`) AS `M`, (`oh`.`size_l_oh` - `so`.`size_l_commit`) AS `L`, (`oh`.`size_xl_oh` - `so`.`size_xl_commit`) AS `XL`, (`oh`.`size_2xl_oh` - `so`.`size_2xl_commit`) AS `2XL`, (`oh`.`size_3xl_oh` - `so`.`size_3xl_commit`) AS `3XL`, (`oh`.`size_4xl_oh` - `so`.`size_4xl_commit`) AS `4XL`, ( ( ( ( ( ( ( ( ( (`oh`.`size_2xs_oh` - `so`.`size_2xs_commit`) + (`oh`.`size_2xs_oh` - `so`.`size_2xs_commit`) ) + (`oh`.`size_xs_oh` - `so`.`size_xs_commit`) ) + (`oh`.`size_s_oh` - `so`.`size_s_commit`) ) + (`oh`.`size_m_oh` - `so`.`size_m_commit`) ) + (`oh`.`size_l_oh` - `so`.`size_l_commit`) ) + (`oh`.`size_xl_oh` - `so`.`size_xl_commit`) ) + (`oh`.`size_2xl_oh` - `so`.`size_2xl_commit`) ) + (`oh`.`size_3xl_oh` - `so`.`size_3xl_commit`) ) + (`oh`.`size_4xl_oh` - `so`.`size_4xl_commit`) ) AS `size_avail_total` FROM ( (`paradox`.`inv_item` JOIN `paradox`.`view_item_oh_counts` `oh` ON ( (`oh`.`itemid` = `paradox`.`inv_item`.`itemid`) ) ) JOIN `paradox`.`view_item_so_counts` `so` ON ( (`so`.`itemid` = `paradox`.`inv_item`.`itemid`) ) ) WHERE inv_item.item_keyword LIKE `%lji rack%` AND inv_item.item_remove = `active` GROUP BY `paradox`.`inv_item`.`itemid`;";

	include 'admin/vars.php';
	include 'admin/headers.php';
	include 'navigation.php';
?>
<!-- <div id="wrapper">
	<div id="content" class="container" role="main">
		<div id="welcome" class="jumbotron">
			<img src="images/honeycomb-ico-grad.svg" alt="Honey Comb Icon" class="honeycomb-icon">
			<h1>Welcome <?php echo ucfirst($_SESSION["username"]);?>,</h1>
			<p>Honeycomb is an experimental lab...</p>
			<a class="btn btn-lg btn-primary" href="about.php">Learn More</a>
		</div>
	</div>
</div> -->
<div id="welcome">
	<div class="container">
		<div class="jumbotron">
			<img src="images/honeycomb-ico-grad.svg" alt="Honey Comb Icon" class="honeycomb-icon">
			<h1>Welcome <?php echo ucfirst($_SESSION["username"]);?>,</h1>
			<p>Honeycomb is an experimental lab...</p>
		</div>
	</div>
</div>
<div id="wrapper">
	<div id="content" class="container" role="main">
		<div class="row">
			<div class="col-md-8 anti-aliased">
				<div class="page-header">
					<h2>What is &#8220;Honeycomb?&#8221; <small>this might get confusing...</small></h2>
				</div>

				<p>Well, maybe not too confusing. Here are a few questions you might have:</p>
				<p><strong>Why do we need two products, what&apos;s the difference between Coolcat and Honeycomb?</strong> <br>It is actually not two products. Applications developed in Honeycomb will be plugged into Coolcat in furthur development. Its a testing ground. Testing grounds have been known to draw crowds who are expecting explosions. Maybe expect a few.</p>
				<p><strong>Then why not develop these new and experimental features on Coolcat?</strong> <br>Dean and Aaron&apos;s coding style hasn&apos;t merged into one <code>coding</code> super-power yet. So when Aaron was tasked to produce a simple program that compares a spreadsheet of potential clients to our customer database, it had been decided that he develop it as separate &#8220;thing.&#8221;</p>
				<p><strong>Why is it called &#8220;Honeycomb?&#8221;</strong> Aaron Delani needed an arbitrary name to call the project. First thing to come to mind was productivity and connectivity. Beehives provide that for bees, who are apparently always busy, and honeycombs are where they store the honey.</p>
				<p><i>Honeycomb</i> is a pluggable framework and playground for experimental Coolcat Features.</p>

				<h3>Development:</h3>

				<div class="alert alert-warning">
					<p><i>Honeycomb</i> is in rapid development. So don&apos;t be surprised if a few things break.</p>
				</div>

				<h4>Features:</h4>

				<ul>
					<li>View quantities in inventory.</li>
					<li>Create Closeout and LJI Rack Catalogs on the fly.</li>
					<li>A UI Framework that provides consistency throughout the application</li>
					<li>Coolcat Integration for Viewing Customer List</li>
					<li>Compare an Event CSV to current Customer Database (from Coolcat)</li>
					<li>Mobile Web App ready</li>
					<li>Integrated Authentication with Coolcat</li>
					<li>Product Library, with attributes and options (Continuing to improve the library)</li>
				</ul>

				<h4>Upcoming Features:</h4>
				<p>(<i>Features are being produced concurrently.</i>)</p>

				<ul>
					<li>Customer Company Hierarchy Table (to be used for any queries related to our customers) <br> This will improve prospects, inventory, and updates with our customers.</li>
					<li>Customer Contact List</li>
					<li>Robust and Concise Quote and Sales Order Creation</li>
					<li>Sales Order, Notes, and Product Notifications</li>
					<li>Sales Order and Purchase Order workflow process (So nothing drops between the cracks)</li>
					<li>User Dashboard, get information on what&apos;s going on within the company, including what you&apos;re working on. <br>Making it easier to pick up where you left off.</li>
					<li>Notes app for users. <br>When you create a note on a product, sales order, or anything, you should be able to find it for posterity and documentation.</li>
				</ul>

				<p>Please be advised, the whole look, feel, and functionality of Honeycomb could change in a second.</p>

				<hr>

				<h3>Technical Stuff</h3>

				<ul>
					<li>CSS UI Framework
						<ul>
							<li>CSS/CSS3 Pre-processor (makes coding, debugging, and packaging faster and easier) <a href="http://sass-lang.org">SASS</a> + <a href="http://compass-style.org">Compass</a></li>
							<li>Using <a href="http://getbootstrap.com">Bootstrap</a> for a quick UI framework.</li>
						</ul>
					</li>
					<li>Javascript Framework
						<ul>
							<li><strong>bees.js</strong> javascript library by Aaron Delani, produced in-house.</li>
							<li><a href="http://jquery.com">Jquery</a></li>
							<li>HTML Table searching and manipulation with <a href="http://datatables.net">Datatables.net</a> Jquery Plugin</li>
							<li>CSV Parser by Evan Plaice <a href="https://code.google.com/p/jquery-csv/">Jquery CSV</a></li>
						</ul>
					</li>
					<li>PHP is all written in house by Aaron Delani</li>
				</ul>
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">Requests:</div>
					<div class="panel-body">
						<p>If you have any feature requests, please let <a href="mailto:aaron@lesliejordan.com">Aaron Delani</a> know.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include 'admin/footer.php'; ?>

<script type="text/javascript">
$(document).ready(function(){
	var subUser = $('#submitUser'),
		addUserBtn = $('#addUserBtn');

	new ajaxifyForm(
		subUser,
		function (form,data) {
			var data = data;

			new buildRow(
				form,
				[data.first_name, data.last_name, data.e_mail, data.phone_1],
				$("#user_table")
			);
		},
		true //clear form
	);
});
</script>