<?php
	// Need page preferences here
	$page_title .= "Leads";
	$body_class = "";
	$lead_page_active = TRUE;
	$autocomplete = TRUE;
	$view_lead = FALSE;
	$imghost = "http://www.lesliejordan.com/inventory/prodimages/";

	include '../admin/vars.php';
	include '../admin/headers.php';
	include '../navigation.php';

	if (isset($_GET["leadId"])) {
		$lead_id = $_GET["leadId"];
		$view_lead = TRUE;
		$eligable_leads = $sugar_link->query("SELECT * FROM _leads WHERE id = '$lead_id' LIMIT 1;");

	} else {
		$eligable_leads = $sugar_link->query("SELECT id, timestamp, company, event, first_name, last_name, email FROM _leads WHERE eligable = 1 ORDER BY timestamp;");
	}

?>

<div id="wrapper">
	<div id="content" class="container" role="main">
		<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> <strong>WAIT ONE SECOND</strong> this is a very experimental feature. Things may figuratively blow up if you play around here.</div>

		<?php
			include 'customer_navigation.php';

			if ($view_lead) {
				if ($eligable_leads->num_rows > 0) {
	 				while ($lead = $eligable_leads->fetch_assoc()) {
	 					// print_r($lead);
	 					$unique_hash = $lead["unique_hash"];
	 					$english_timestamp = date('D, F jS, Y, g:ia T', strtotime($lead["timestamp"]));
		?>
			<div class="row">
				<div class="col-md-8">
					<h2><span class="fa fa-compass" aria-hidden="true"></span> Lead Information</h2>

					<strong><?php echo $english_timestamp; ?></strong><br>
					<strong>Company:</strong> <?php echo $lead["company"]; ?><br>

					<strong>Event:</strong> <?php echo $lead["event"]; ?><br>

					<strong>Contact:</strong> <?php echo $lead["first_name"]; ?> <?php echo $lead["last_name"]; ?> <br>
					<strong>Email:</strong> <?php echo $lead["email"]; ?>
					<div class="message">
						<h4>Message:</h4>
						<?php echo $lead["message"]; ?>
					</div>
					<hr>
					<div class="notes">
						<h4>Notes</h4>
					</div>
				</div>
				<div class="col-md-4">
					<h4>Products Interested</h4>
					<?php
						$paradox_mysql_link = new mysqli($paradox_mysql_server, $paradox_mysql_user, $paradox_mysql_password, $paradox_db);

						$int_prod = $sugar_link->query("SELECT * from items WHERE unique_hash = '$unique_hash';");

						if ($view_lead) {
							if ($int_prod->num_rows > 0) {
								$prodsArr = [];
								while ($int_item = $int_prod->fetch_assoc()) {
									// print_r($int_item);
									array_push($prodsArr, $int_item["item_id"]);
									// echo $int_item . "<br>";
								}
							}
							$query = "SELECT `paradox`.`inv_item`.`itemid` AS `itemid`, inv_item.item_keyword AS item_keyword, inv_item.style AS Style, inv_item.color AS Color, inv_item.styleinfo AS Fabric, inv_item.item_brand AS Brand, inv_item.item_pattern, inv_item.item_fit AS Fit, inv_item.item_origin AS Origin, inv_item.image AS image, (`oh`.`size_os_oh` - `so`.`size_os_commit`) AS `OS`, (`oh`.`size_2xs_oh` - `so`.`size_2xs_commit`) AS `2XS`, (`oh`.`size_xs_oh` - `so`.`size_xs_commit`) AS `XS`, (`oh`.`size_s_oh` - `so`.`size_s_commit`) AS `S`, (`oh`.`size_m_oh` - `so`.`size_m_commit`) AS `M`, (`oh`.`size_l_oh` - `so`.`size_l_commit`) AS `L`, (`oh`.`size_xl_oh` - `so`.`size_xl_commit`) AS `XL`, (`oh`.`size_2xl_oh` - `so`.`size_2xl_commit`) AS `2XL`, (`oh`.`size_3xl_oh` - `so`.`size_3xl_commit`) AS `3XL`, (`oh`.`size_4xl_oh` - `so`.`size_4xl_commit`) AS `4XL`, ( ( ( ( ( ( ( ( ( (`oh`.`size_2xs_oh` - `so`.`size_2xs_commit`) + (`oh`.`size_2xs_oh` - `so`.`size_2xs_commit`) ) + (`oh`.`size_xs_oh` - `so`.`size_xs_commit`) ) + (`oh`.`size_s_oh` - `so`.`size_s_commit`) ) + (`oh`.`size_m_oh` - `so`.`size_m_commit`) ) + (`oh`.`size_l_oh` - `so`.`size_l_commit`) ) + (`oh`.`size_xl_oh` - `so`.`size_xl_commit`) ) + (`oh`.`size_2xl_oh` - `so`.`size_2xl_commit`) ) + (`oh`.`size_3xl_oh` - `so`.`size_3xl_commit`) ) + (`oh`.`size_4xl_oh` - `so`.`size_4xl_commit`) ) AS `size_avail_total` FROM ( (`paradox`.`inv_item` JOIN `paradox`.`view_item_oh_counts` `oh` ON ( (`oh`.`itemid` = `paradox`.`inv_item`.`itemid`) ) ) JOIN `paradox`.`view_item_so_counts` `so` ON ( (`so`.`itemid` = `paradox`.`inv_item`.`itemid`) ) ) WHERE ";

							$filterQuery = implode(" OR inv_item.itemid = ", $prodsArr);

							$query .= "inv_item.itemid = " . $filterQuery . " AND inv_item.item_remove = 'active' AND inv_item.hide = 'n' ORDER BY `paradox`.`inv_item`.`color`;";
							$products_interested = $paradox_mysql_link->query($query);

							if ($products_interested->num_rows > 0) {
								echo "<div class=\"list-group\">";
								while ($repor = $products_interested->fetch_assoc()) {
									// print_r($repor);
									// array_push($prodsArr, $int_item["item_id"])
									// echo $int_item . "<br>";
									$item_id = $repor["itemid"];
									$item_image = $repor["image"];
									?>
										<div class="list-group-item media lead-media">
											<?php
												$imgURL = $imghost . $item_image;
											?>
											<div class="media-left product-image">
												<img src="<?php echo $imgURL; ?>" alt="">
											</div>
											<div class="media-body">
												<h4><?php echo $repor["Style"] . " " . $repor["Color"] . " " . $repor["Fabric"] . " " . $repor["Fit"]; ?></h4>
												<!-- <span class="style-number"><?php echo $repor["Style"]; ?></span> <span class="fit"><?php echo $repor["Fit"]; ?></span> -->
												<a class="btn btn-default" data-toggle="collapse" href="#<?php echo $unique_hash."I".$item_id; ?>" aria-expanded="false" aria-controls="<?php echo $unique_hash."I".$item_id; ?>">View Inventory</a>

												<!-- <?php echo $repor["Brand"]; ?> -->
												<!-- <?php echo $repor["item_pattern"]; ?> -->
											</div>
											<div class="collapse" id="<?php echo $unique_hash."I".$item_id; ?>">
												<table class="table">
													<thead>
														<tr>
															<th colspan="2">Inventory</th>
														</tr>
													</thead>
													<?php if ($repor["OS"] > 0) { ?>
														<tr><td class="text-right row-header">OS</td><td class="text-center"><?php echo $repor["OS"]; ?></td></tr>
													<?php } ?>
													<?php if ($repor["2XS"] > 0) { ?>
														<tr><td class="text-right row-header">2XS</td><td class="text-center"><?php echo $repor["2XS"]; ?></td></tr>
													<?php } ?>
														<tr><td class="text-right row-header">XS</td><td class="text-center"><?php if ($repor["XS"] > 0) { echo $repor["XS"]; } else { echo "0"; } ?></td></tr>
														<tr><td class="text-right row-header">S</td><td class="text-center"><?php if ($repor["S"] > 0) { echo $repor["S"]; } else { echo "0"; } ?></td></tr>
														<tr><td class="text-right row-header">M</td><td class="text-center"><?php if ($repor["M"] > 0) { echo $repor["M"]; } else { echo "0"; } ?></td></tr>
														<tr><td class="text-right row-header">L</td><td class="text-center"><?php if ($repor["L"] > 0) { echo $repor["L"]; } else { echo "0"; } ?></td></tr>
														<tr><td class="text-right row-header">XL</td><td class="text-center"><?php if ($repor["XL"] > 0) { echo $repor["XL"]; } else { echo "0"; } ?></td></tr>
														<tr><td class="text-right row-header">2XL</td><td class="text-center"><?php if ($repor["2XL"] > 0) { echo $repor["2XL"]; } else { echo "0"; } ?></td></tr>
														<tr><td class="text-right row-header">3XL</td><td class="text-center"><?php if ($repor["3XL"] > 0) { echo $repor["3XL"]; } else { echo "0"; } ?></td></tr>
													<?php if ($repor["4XL"] > 0) { ?>
														<tr><td class="text-right row-header">4XL</td><td class="text-center"><?php echo $repor["4XL"]; ?></td></tr>
													<?php } ?>
													<!-- <tr><td class="text-right row-header">Total</td><td class="text-center"><?php echo $repor["size_avail_total"]; ?></td></tr> -->
												</table>
											</div>
										</div>
									<?php
								}
								echo "</div>";
							}
						}
					?>
				</div>
			</div>

		<?php }}} else { ?>
		<h1><span class="fa fa-compass" aria-hidden="true"></span> Leads</h1>

		<div class="list-group anti-aliased">
		<?php if ($eligable_leads->num_rows > 0) {
 				while ($lead = $eligable_leads->fetch_assoc()) {
 					$english_timestamp = date('D, F jS, Y, g:ia T', strtotime($lead["timestamp"]));
		?>
			<a data-lead-id="<?php echo $lead["id"]; ?>" class="list-group-item" href="leads.php?leadId=<?php echo $lead['id']; ?>">
				<?php echo $lead["company"]; ?><br>
				<strong><?php echo $english_timestamp; ?></strong><br>
				<?php echo $lead["event"]; ?>
				<?php echo $lead["first_name"]; ?>
				<?php echo $lead["last_name"]; ?>
			</a>

		<?php } } ?>
		</div>
		<?php } ?>
	</div>
</div>

<?php include '../admin/footer.php'; ?>

<script type="text/javascript">
$(document).ready(function(){

});
</script>

<?php $sugar_link->close(); ?>