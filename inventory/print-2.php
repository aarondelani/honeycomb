<?php
	// Need page preferences here
	$page_title = "Inventory Reports";
	$body_class .= " inventory-page-print";
	$inventory_page_active = TRUE;
	$autocomplete = TRUE;


	include '../admin/vars.php';
	include '../admin/headers.php';
	// include '../navigation.php';
	// $imghost = "http://www.lesliejordan.com/inventory/prodimages/";
	$imghost = "prodImages/";
// Setting Default Report
	$filterQuery = "lji rack";
	$lji_rack_page = TRUE;
	$closeout_page = FALSE;
	$current_page = "LJI Rack Catalog";
	$testing = FALSE;

if (isset($_GET["rep"])) {
	if ($_GET["rep"] == "rack") {
		// $filterQuery = "lji rack";

		$filterQuery = "inv_item.item_keyword LIKE '%lji rack%' AND inv_item.item_keyword NOT LIKE '%accessory%' AND inv_item.item_keyword NOT LIKE '%currently in stock%'";
	}

	if ($_GET["t"] == 1){
		$testing = TRUE;
	}

	if ($_GET["rep"] == "close") {
		$lji_rack_page = FALSE;
		$closeout_page = TRUE;
		$filterQuery = "inv_item.item_keyword LIKE '%closeout%' AND inv_item.item_keyword NOT LIKE '%accessory%' AND inv_item.item_keyword NOT LIKE '%currently in stock%'";
		$current_page = "Closeout Catalog";
	}

	$query = "SELECT `paradox`.`inv_item`.`itemid` AS `itemid`, inv_item.item_keyword AS item_keyword, inv_item.style AS Style, inv_item.color AS Color, inv_item.styleinfo AS Fabric, inv_item.item_brand AS Brand, inv_item.item_pattern, inv_item.item_fit AS Fit, inv_item.item_origin AS Origin, inv_item.image AS image, (`oh`.`size_os_oh` - `so`.`size_os_commit`) AS `OS`, (`oh`.`size_2xs_oh` - `so`.`size_2xs_commit`) AS `2XS`, (`oh`.`size_xs_oh` - `so`.`size_xs_commit`) AS `XS`, (`oh`.`size_s_oh` - `so`.`size_s_commit`) AS `S`, (`oh`.`size_m_oh` - `so`.`size_m_commit`) AS `M`, (`oh`.`size_l_oh` - `so`.`size_l_commit`) AS `L`, (`oh`.`size_xl_oh` - `so`.`size_xl_commit`) AS `XL`, (`oh`.`size_2xl_oh` - `so`.`size_2xl_commit`) AS `2XL`, (`oh`.`size_3xl_oh` - `so`.`size_3xl_commit`) AS `3XL`, (`oh`.`size_4xl_oh` - `so`.`size_4xl_commit`) AS `4XL`, ( ( ( ( ( ( ( ( ( (`oh`.`size_2xs_oh` - `so`.`size_2xs_commit`) + (`oh`.`size_2xs_oh` - `so`.`size_2xs_commit`) ) + (`oh`.`size_xs_oh` - `so`.`size_xs_commit`) ) + (`oh`.`size_s_oh` - `so`.`size_s_commit`) ) + (`oh`.`size_m_oh` - `so`.`size_m_commit`) ) + (`oh`.`size_l_oh` - `so`.`size_l_commit`) ) + (`oh`.`size_xl_oh` - `so`.`size_xl_commit`) ) + (`oh`.`size_2xl_oh` - `so`.`size_2xl_commit`) ) + (`oh`.`size_3xl_oh` - `so`.`size_3xl_commit`) ) + (`oh`.`size_4xl_oh` - `so`.`size_4xl_commit`) ) AS `size_avail_total` FROM ( (`paradox`.`inv_item` JOIN `paradox`.`view_item_oh_counts` `oh` ON ( (`oh`.`itemid` = `paradox`.`inv_item`.`itemid`) ) ) JOIN `paradox`.`view_item_so_counts` `so` ON ( (`so`.`itemid` = `paradox`.`inv_item`.`itemid`) ) ) WHERE " . $filterQuery . " AND inv_item.item_remove = 'active' AND inv_item.hide = 'n' GROUP BY `paradox`.`inv_item`.`itemid`;";

	if($_GET["rep"] == "all") {
		$query = "SELECT `paradox`.`inv_item`.`itemid` AS `itemid`, inv_item.item_keyword AS item_keyword, inv_item.style AS Style, inv_item.color AS Color, inv_item.styleinfo AS Fabric, inv_item.item_brand AS Brand, inv_item.item_pattern, inv_item.item_fit AS Fit, inv_item.item_origin AS Origin, inv_item.image AS image, (`oh`.`size_os_oh` - `so`.`size_os_commit`) AS `OS`, (`oh`.`size_2xs_oh` - `so`.`size_2xs_commit`) AS `2XS`, (`oh`.`size_xs_oh` - `so`.`size_xs_commit`) AS `XS`, (`oh`.`size_s_oh` - `so`.`size_s_commit`) AS `S`, (`oh`.`size_m_oh` - `so`.`size_m_commit`) AS `M`, (`oh`.`size_l_oh` - `so`.`size_l_commit`) AS `L`, (`oh`.`size_xl_oh` - `so`.`size_xl_commit`) AS `XL`, (`oh`.`size_2xl_oh` - `so`.`size_2xl_commit`) AS `2XL`, (`oh`.`size_3xl_oh` - `so`.`size_3xl_commit`) AS `3XL`, (`oh`.`size_4xl_oh` - `so`.`size_4xl_commit`) AS `4XL`, ( ( ( ( ( ( ( ( ( (`oh`.`size_2xs_oh` - `so`.`size_2xs_commit`) + (`oh`.`size_2xs_oh` - `so`.`size_2xs_commit`) ) + (`oh`.`size_xs_oh` - `so`.`size_xs_commit`) ) + (`oh`.`size_s_oh` - `so`.`size_s_commit`) ) + (`oh`.`size_m_oh` - `so`.`size_m_commit`) ) + (`oh`.`size_l_oh` - `so`.`size_l_commit`) ) + (`oh`.`size_xl_oh` - `so`.`size_xl_commit`) ) + (`oh`.`size_2xl_oh` - `so`.`size_2xl_commit`) ) + (`oh`.`size_3xl_oh` - `so`.`size_3xl_commit`) ) + (`oh`.`size_4xl_oh` - `so`.`size_4xl_commit`) ) AS `size_avail_total` FROM ( (`paradox`.`inv_item` JOIN `paradox`.`view_item_oh_counts` `oh` ON ( (`oh`.`itemid` = `paradox`.`inv_item`.`itemid`) ) ) JOIN `paradox`.`view_item_so_counts` `so` ON ( (`so`.`itemid` = `paradox`.`inv_item`.`itemid`) ) ) WHERE inv_item.item_remove = 'active' AND inv_item.hide = 'n' GROUP BY `paradox`.`inv_item`.`itemid`;";
		$all_inventory = TRUE;
		$current_page = "Viewing All Inventory";
	}
}

$paradox_mysql_link = new mysqli($paradox_mysql_server, $paradox_mysql_user, $paradox_mysql_password, $paradox_db);
$par_rep = $paradox_mysql_link->query($query);
?>
<div id="wrapper">
	<div id="content" class="container-fluid" role="main">
		<div class="header-cont">
			<div class="contact-details">
				<ul>
					<li><a href="http://www.lesliejordan.com">www.lesliejordan.com</a></li>
					<li>Call 803-935-3343 for availability</li>
					<li>ljsales@lesliejordan.com</li>
				</ul>
			</div>
			<h2><a href="http://www.lesliejordan.com"><img src="images/lj-logo.svg" alt="Leslie Jordan Logo"></a> <?php echo $current_page; ?></h2>
		</div>

		<?php
			$result_count = 0;

			if ($par_rep->num_rows > 0) {
				while($repor = $par_rep->fetch_assoc()) {
					// print_r($repor);
					$item_id = $repor["itemid"];
					$item_image = $repor["image"];

					if ($item_image != "" || NULL) {
			?>
		<div class="print-product-item">
			<div class="product-row">
				<div class="item-details text-center">
				<?php
					$imgURL = $imghost . $item_image;
				 ?>
					<img src="<?php echo $imgURL; ?>" alt="">

					<div class="deets">
						<span class="style-number"><?php echo $repor["Style"]; ?></span><br>
						<span class="fit"><?php echo $repor["Fit"]; ?></span>
					</div>
				</div>

				<!-- <?php echo $repor["Brand"]; ?> -->
				<!-- <?php echo $repor["item_pattern"]; ?> -->
				<table class="layout inventory-stats">
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
			</div><div class="product-footer text-center">
				<?php echo $repor["Color"] . " " . $repor["Fabric"]; ?>
			</div>
		</div>
			<?php }
			}
		} ?>
		<div class="footer-cont">
			<div class="footer-cont-content">
				<strong>Leslie Jordan Inc.</strong> Long Sleeve Shirts and T-Shirts
			</div>
		</div>
	</div>
</div>

<?php

$paradox_mysql_link->close();

include '../admin/footer.php';

?>

<script type="text/javascript">
$(document).ready(function(){
	<?php 
		if (!$testing) { ?>
		window.print();
	<?php } ?>

	body = $('body');
	body.removeClass('loading');

	header = $('.header-cont');
	container = $('#content');
	items = $('.print-product-item');
	footer = $('.footer-cont');
	counter = 0;
	page_count = 0;

	page_contents = [];

	// container.append(new page);
	console.log(items.length);

	items.each(
		function (node) {
			// console.log(node);

			if (counter == 0) {
			}

			// console.log(page);
			if (counter >= 0 && page_contents.length !== 12) {
				page_contents.push(this);

				this.remove();

				++counter;
			}

			if (page_contents.length == 12) {
				// container.append(page);
				var page = $('<div class="page">');
				var page_number = $('<span class="page-number">');

				++page_count;

				page.prepend(header.clone());

				for (var i = page_contents.length - 1; i >= 0; i--) {
					page.append(page_contents[i]);

					container.append(page);
				};

				console.log(page_count);

				page.append(footer.clone().prepend(page_number.append(page_count)));

				page_contents.length = 0;
				counter = 0;
				console.log('there eleven', page_contents.length);
			}

			if (items.length == node + 1) {
				var page = $('<div class="page">');
				var page_number = $('<span class="page-number">');

				++page_count;

				page.prepend(header.clone());

				for (var i = page_contents.length - 1; i >= 0; i--) {
					page.append(page_contents[i]);

					container.append(page);

					++page_contents;
				};

				page.append(footer.clone().prepend(page_number.append(page_count)));

				console.log('there eleven', page_contents.length);

				page_contents.length = 0;
				counter = 0;

				header.remove();
				footer.remove();
			}

	});

	// console.log(page_contents);

	// console.log(counter);
});
</script>

<?php
$paradox_mysql_link->close();
?>