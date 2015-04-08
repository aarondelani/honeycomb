<?php
	// Need page preferences here
	$page_title = "Inventory Reports";
	$body_class .= " inventory-page";
	$inventory_page_active = TRUE;
	$autocomplete = TRUE;
	include '../admin/vars.php';
	include '../admin/headers.php';
	include '../navigation.php';
	$imghost = "http://www.lesliejordan.com/inventory/prodimages/";

	$paradox_mysql_link = new mysqli($paradox_mysql_server, $paradox_mysql_user, $paradox_mysql_password, $paradox_db);

	$filters = $paradox_mysql_link->query('SELECT inv_filter.filterid as filterid, inv_filter.filtername as filtername, inv_filter.filterreference as filterreference, inv_filter.filtercategory as filtercategory, inv_filtercat.categoryname as category FROM (inv_filter JOIN inv_filtercat ON (inv_filter.filtercategory = inv_filtercat.filtercatid)) WHERE (inv_filtercat.filtercatid != 6) AND inv_filter.hide != "y";');

// Setting Default Report
	$all_inventory = FALSE;

	$query = "SELECT `paradox`.`inv_item`.`itemid` AS `itemid`, inv_item.item_keyword AS item_keyword, inv_item.style AS Style, inv_item.color AS Color, inv_item.styleinfo AS Fabric, inv_item.item_brand AS Brand, inv_item.item_pattern, inv_item.item_fit AS Fit, inv_item.item_origin AS Origin, inv_item.image AS image, (`oh`.`size_os_oh` - `so`.`size_os_commit`) AS `OS`, (`oh`.`size_2xs_oh` - `so`.`size_2xs_commit`) AS `2XS`, (`oh`.`size_xs_oh` - `so`.`size_xs_commit`) AS `XS`, (`oh`.`size_s_oh` - `so`.`size_s_commit`) AS `S`, (`oh`.`size_m_oh` - `so`.`size_m_commit`) AS `M`, (`oh`.`size_l_oh` - `so`.`size_l_commit`) AS `L`, (`oh`.`size_xl_oh` - `so`.`size_xl_commit`) AS `XL`, (`oh`.`size_2xl_oh` - `so`.`size_2xl_commit`) AS `2XL`, (`oh`.`size_3xl_oh` - `so`.`size_3xl_commit`) AS `3XL`, (`oh`.`size_4xl_oh` - `so`.`size_4xl_commit`) AS `4XL`, ( ( ( ( ( ( ( ( ( (`oh`.`size_2xs_oh` - `so`.`size_2xs_commit`) + (`oh`.`size_2xs_oh` - `so`.`size_2xs_commit`) ) + (`oh`.`size_xs_oh` - `so`.`size_xs_commit`) ) + (`oh`.`size_s_oh` - `so`.`size_s_commit`) ) + (`oh`.`size_m_oh` - `so`.`size_m_commit`) ) + (`oh`.`size_l_oh` - `so`.`size_l_commit`) ) + (`oh`.`size_xl_oh` - `so`.`size_xl_commit`) ) + (`oh`.`size_2xl_oh` - `so`.`size_2xl_commit`) ) + (`oh`.`size_3xl_oh` - `so`.`size_3xl_commit`) ) + (`oh`.`size_4xl_oh` - `so`.`size_4xl_commit`) ) AS `size_avail_total` FROM ( (`paradox`.`inv_item` JOIN `paradox`.`view_item_oh_counts` `oh` ON ( (`oh`.`itemid` = `paradox`.`inv_item`.`itemid`) ) ) JOIN `paradox`.`view_item_so_counts` `so` ON ( (`so`.`itemid` = `paradox`.`inv_item`.`itemid`) ) ) WHERE inv_item.item_remove = 'active' AND inv_item.hide = 'n' GROUP BY `paradox`.`inv_item`.`itemid`;";
	$lji_rack_page = FALSE;
	$all_inventory = TRUE;
	$current_page = "Viewing All Inventory";

if (isset($_GET["rep"])) {
	if ($_GET["rep"] == "rack") {
		$filterQuery = "lji rack";
		$lji_rack_page = TRUE;
		$current_page = "LJI Rack Report";
	}

	if ($_GET["rep"] == "close") {
		$closeout_page = TRUE;
		$filterQuery = "closeout";
		$current_page = "Closeout Report";
	}

	if ($_GET["rep"] == "all") {
	}

	$query = "SELECT `paradox`.`inv_item`.`itemid` AS `itemid`, inv_item.item_keyword AS item_keyword, inv_item.style AS Style, inv_item.color AS Color, inv_item.styleinfo AS Fabric, inv_item.item_brand AS Brand, inv_item.item_pattern, inv_item.item_fit AS Fit, inv_item.item_origin AS Origin, inv_item.image AS image, (`oh`.`size_os_oh` - `so`.`size_os_commit`) AS `OS`, (`oh`.`size_2xs_oh` - `so`.`size_2xs_commit`) AS `2XS`, (`oh`.`size_xs_oh` - `so`.`size_xs_commit`) AS `XS`, (`oh`.`size_s_oh` - `so`.`size_s_commit`) AS `S`, (`oh`.`size_m_oh` - `so`.`size_m_commit`) AS `M`, (`oh`.`size_l_oh` - `so`.`size_l_commit`) AS `L`, (`oh`.`size_xl_oh` - `so`.`size_xl_commit`) AS `XL`, (`oh`.`size_2xl_oh` - `so`.`size_2xl_commit`) AS `2XL`, (`oh`.`size_3xl_oh` - `so`.`size_3xl_commit`) AS `3XL`, (`oh`.`size_4xl_oh` - `so`.`size_4xl_commit`) AS `4XL`, ( ( ( ( ( ( ( ( ( (`oh`.`size_2xs_oh` - `so`.`size_2xs_commit`) + (`oh`.`size_2xs_oh` - `so`.`size_2xs_commit`) ) + (`oh`.`size_xs_oh` - `so`.`size_xs_commit`) ) + (`oh`.`size_s_oh` - `so`.`size_s_commit`) ) + (`oh`.`size_m_oh` - `so`.`size_m_commit`) ) + (`oh`.`size_l_oh` - `so`.`size_l_commit`) ) + (`oh`.`size_xl_oh` - `so`.`size_xl_commit`) ) + (`oh`.`size_2xl_oh` - `so`.`size_2xl_commit`) ) + (`oh`.`size_3xl_oh` - `so`.`size_3xl_commit`) ) + (`oh`.`size_4xl_oh` - `so`.`size_4xl_commit`) ) AS `size_avail_total` FROM ( (`paradox`.`inv_item` JOIN `paradox`.`view_item_oh_counts` `oh` ON ( (`oh`.`itemid` = `paradox`.`inv_item`.`itemid`) ) ) JOIN `paradox`.`view_item_so_counts` `so` ON ( (`so`.`itemid` = `paradox`.`inv_item`.`itemid`) ) ) WHERE inv_item.item_keyword LIKE '%". $filterQuery ."%' AND inv_item.item_remove = 'active' AND inv_item.hide = 'n' GROUP BY `paradox`.`inv_item`.`itemid`;";
}

if (!$all_inventory) {
}

	$par_rep = $paradox_mysql_link->query($query);
?>
<div id="wrapper">
	<div id="content" class="container-fluid" role="main">
		<?php include 'navbar.php'; ?>
		<?php
			if ($filters->num_rows > 0) {
				while ($filter = $filters->fetch_assoc()) {
					?>
					<span class="checkbox inv-filter-box"><label for="<?php echo $filter["filterreference"]; ?>"><input type="checkbox" id="<?php echo $filter["filterreference"]; ?>" value="<?php echo $filter["filtername"]; ?>"> <?php echo $filter["filtername"]; ?></label></span>
					<?php
				}
			}

		 ?>

		<h2><?php echo $current_page; ?></h2>

		<table class="table stripes layout" id="report_table">
			<thead>
				<tr>
					<th class="product-image">Preview</th>
					<th>Style</th>
					<th>Color</th>
					<th>Fabric</th>
					<th>Brand</th>
					<th>Pattern</th>
					<th>Fit</th>
					<th>Origin</th>
					<!-- <th class="text-center">OS</th> -->
					<!-- <th class="text-center">2XS</th> -->
					<th class="text-center">XS</th>
					<th class="text-center">S</th>
					<th class="text-center">M</th>
					<th class="text-center">L</th>
					<th class="text-center">XL</th>
					<th class="text-center">2XL</th>
					<th class="text-center">3XL</th>
					<!-- <th class="text-center">4XL</th> -->
					<th class="text-center">Total</th>
				</tr>
			</thead>
		<?php if ($par_rep->num_rows > 0) {
				while($repor = $par_rep->fetch_assoc()) {
					// print_r($repor);
					$item_id = $repor["itemid"];
					$item_image = $repor["image"];
		?>
		<tr data-item-keywords="<?php echo $repor["item_keyword"]; ?>">
			<td class="product-image text-center">
			<?php if ($item_image != NULL || "") { ?>
				<img src="<?php echo $imghost . $item_image; ?>" alt="">
				<?php } else { ?>
				<span class="glyphicon glyphicon-picture"></span><span> No Preview</span>
			<?php } ?>
			</td>
			<td><?php echo $repor["Style"]; ?></td>
			<td><?php echo $repor["Color"]; ?></td>
			<td><?php echo $repor["Fabric"]; ?></td>
			<td><?php echo $repor["Brand"]; ?></td>
			<td><?php echo $repor["item_pattern"]; ?></td>
			<td><?php echo $repor["Fit"]; ?></td>
			<td><?php echo $repor["Origin"]; ?></td>
			<!-- <td class="text-center"><?php echo $repor["OS"]; ?></td> -->
			<!-- <td class="text-center"><?php echo $repor["2XS"]; ?></td> -->
			<td class="text-center"><?php echo $repor["XS"]; ?></td>
			<td class="text-center"><?php echo $repor["S"]; ?></td>
			<td class="text-center"><?php echo $repor["M"]; ?></td>
			<td class="text-center"><?php echo $repor["L"]; ?></td>
			<td class="text-center"><?php echo $repor["XL"]; ?></td>
			<td class="text-center"><?php echo $repor["2XL"]; ?></td>
			<td class="text-center"><?php echo $repor["3XL"]; ?></td>
			<!-- <td class="text-center"><?php echo $repor["4XL"]; ?></td> -->
			<td class="text-center"><?php echo $repor["size_avail_total"]; ?></td>
		</tr>
		<?php }
		} ?>
		</table>
	</div>
</div>

<?php

$paradox_mysql_link->close();
$dataTables = TRUE;
include '../admin/footer.php';

?>

<script type="text/javascript">
pageHeight = window.innerHeight - 400 + "px";

$(document).ready(function(){
	body = $('body');
	body.removeClass('loading');

	var report_table = $('#report_table').DataTable({
		"pageLength": 100,
		stateSave: true,
		"scrollY": pageHeight,
		"scrollX": true,
        "scrollCollapse": true,
		"search": {
			"regex": true,
			"smart": true,
		}
	});
});

</script>

<?php
$paradox_mysql_link->close();
?>