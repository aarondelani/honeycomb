<?php
	$generated_catalog = FALSE;

	$paradox_mysql_link = new mysqli($paradox_mysql_server, $paradox_mysql_user, $paradox_mysql_password, $paradox_db);

// $filters = $paradox_mysql_link->query('SELECT inv_filter.filterid as filterid, inv_filter.filtername as filtername, inv_filter.filterreference as filterreference, inv_filter.filtercategory as filtercategory, inv_filtercat.categoryname as category FROM (inv_filter JOIN inv_filtercat ON (inv_filter.filtercategory = inv_filtercat.filtercatid)) WHERE (inv_filtercat.filtercatid != 6) AND inv_filter.hide != "y";');

// Setting Default Report
	$all_inventory = FALSE;

	$query = "SELECT `paradox`.`inv_item`.`itemid` AS `itemid`, inv_item.item_keyword AS item_keyword, inv_item.style AS Style, inv_item.color AS Color, inv_item.styleinfo AS Fabric, inv_item.item_brand AS Brand, inv_item.item_pattern, inv_item.item_fit AS Fit, inv_item.item_origin AS Origin, inv_item.image AS image, (`oh`.`size_os_oh` - `so`.`size_os_commit`) AS `OS`, (`oh`.`size_2xs_oh` - `so`.`size_2xs_commit`) AS `2XS`, (`oh`.`size_xs_oh` - `so`.`size_xs_commit`) AS `XS`, (`oh`.`size_s_oh` - `so`.`size_s_commit`) AS `S`, (`oh`.`size_m_oh` - `so`.`size_m_commit`) AS `M`, (`oh`.`size_l_oh` - `so`.`size_l_commit`) AS `L`, (`oh`.`size_xl_oh` - `so`.`size_xl_commit`) AS `XL`, (`oh`.`size_2xl_oh` - `so`.`size_2xl_commit`) AS `2XL`, (`oh`.`size_3xl_oh` - `so`.`size_3xl_commit`) AS `3XL`, (`oh`.`size_4xl_oh` - `so`.`size_4xl_commit`) AS `4XL`, ( ( ( ( ( ( ( ( ( (`oh`.`size_2xs_oh` - `so`.`size_2xs_commit`) + (`oh`.`size_2xs_oh` - `so`.`size_2xs_commit`) ) + (`oh`.`size_xs_oh` - `so`.`size_xs_commit`) ) + (`oh`.`size_s_oh` - `so`.`size_s_commit`) ) + (`oh`.`size_m_oh` - `so`.`size_m_commit`) ) + (`oh`.`size_l_oh` - `so`.`size_l_commit`) ) + (`oh`.`size_xl_oh` - `so`.`size_xl_commit`) ) + (`oh`.`size_2xl_oh` - `so`.`size_2xl_commit`) ) + (`oh`.`size_3xl_oh` - `so`.`size_3xl_commit`) ) + (`oh`.`size_4xl_oh` - `so`.`size_4xl_commit`) ) AS `size_avail_total` FROM ( (`paradox`.`inv_item` JOIN `paradox`.`view_item_oh_counts` `oh` ON ( (`oh`.`itemid` = `paradox`.`inv_item`.`itemid`) ) ) JOIN `paradox`.`view_item_so_counts_v2` `so` ON ( (`so`.`itemid` = `paradox`.`inv_item`.`itemid`) ) ) WHERE ";

	$lji_rack_page = FALSE;
	$all_inventory = TRUE;
	$current_page = "Viewing All Inventory";

	if (isset($_GET["t"])) {
		if ($_GET["t"] == 1){
			$testing = TRUE;
		}
	}

	if (!isset($_GET["rep"]) && !isset($_POST["submit"]) || $_GET["rep"] == "all") {
		$query .= "inv_item.item_remove = 'active' GROUP BY `paradox`.`inv_item`.`itemid`;";
	}

	if (isset($_GET["rep"])) {
		$filterQuery = $query;

		if ($_GET["rep"] != "all") {
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

			$query .= "inv_item.item_keyword LIKE '%" . $filterQuery . "%' AND inv_item.item_remove = 'active' GROUP BY `paradox`.`inv_item`.`itemid`;";
		}
	}

	if (isset($_POST["submit"])) {
		$generated_catalog = TRUE;
		$querio = $_POST["query_box"];

		$filterQuery = implode(" OR inv_item.itemid = ", $querio);

		$query .= "inv_item.itemid = " . $filterQuery . " AND inv_item.item_remove = 'active' ORDER BY `paradox`.`inv_item`.`color`;";
	}

	$par_rep = $paradox_mysql_link->query($query);
?>
