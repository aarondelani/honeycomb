<?php
	// Need page preferences here
	include '../admin/vars.php';

	$page_title = "Inventory Reports";
	$body_class .= " inventory-page";
	$inventory_page_active = TRUE;
	$autocomplete = TRUE;

	include '../admin/headers.php';
	include '../navigation.php';
	$closeout_page = FALSE;
	$lji_rack_page = FALSE;

	$imghost = "http://www.lesliejordan.com/inventory/prodimages/";

	include 'view_control.php';
?>
<div id="wrapper">
	<div id="content" class="container-fluid" role="main">
		<?php include 'navbar.php'; ?>

		<nav class="navbar navbar-inverse product-navbar navbar-fixed-bottom" id="custom_catalog_controls">
			<div class="collapse navbar-collapse">
				<form class="navbar-form" action="print.php" method="POST" name="id" id="print_this" role="search">
					<div class="form-group">
						<button class="btn btn-default" name="submit" value="1" data-toggle="tooltip" data-placement="bottom" title="<?php echo $tooltip; ?>"><span class="glyphicon glyphicon-print"></span> Print Custom Catalog <span class="badge" id="item_print_count"></span></button>
					</div>
				</form>
			</div>
		</nav>

		<?php
		if ($generated_catalog) {
		} ?>

		<h2><?php echo $current_page; ?></h2>

		<table class="table stripes layout" id="report_table">
			<thead id="inventory_table_head">
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
		<?php
			if ($par_rep->num_rows > 0) {
				while($repor = $par_rep->fetch_assoc()) {
					// print_r($repor);
					$item_id = $repor["itemid"];
					$item_image = $repor["image"];
					$style_ = $repor["Style"];

					// Product Library Query
					// $plQ = $mysql_link->query('SELECT id_product FROM _product WHERE _product_style = "$style_" LIMIT 1');

					// if ($plQ->num_rows > 0) {
					// 	while ($plQID = $plQ->fetch_assoc()) {
					// 		$product_library_id = $plQID["id_product"];
					// 	}
					// }
		?>
			<tr data-item-keywords="<?php echo $repor["item_keyword"]; ?>" class="item-row">
				<td class="product-image text-center">
					<input type="checkbox" id="<?php echo $item_id; ?>" class="item-checkbox" data-item-name="<?php echo $repor["Style"] . " " . $repor["Color"] . " " . $repor["Fabric"] . " " . $repor["Brand"]; ?>">
				<?php if ($item_image != NULL || "") { ?>
					<img src="<?php echo $imghost . $item_image; ?>" alt="">
					<?php } else { ?>
					<span class="glyphicon glyphicon-picture"></span><span> No Preview</span>
				<?php } ?>
					<span class="sr-only"><?php echo $repor["item_keyword"]; ?></span>
				</td>
				<td> <a href=""></a> <?php echo $repor["Style"]; ?></td>
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
		<?php } } ?>
		</table>

	</div>
</div>

<?php
$paradox_mysql_link->close();

$dataTables = TRUE;

include '../admin/footer.php';
?>

<script type="text/javascript">
pageHeight = window.innerHeight - 200 + "px";

$(document).ready(function(){
	body = $('body');
	body.removeClass('loading');

	var query_box = function () {
		return $('<input type="hidden" name="query_box[]">');
	};

	var custom_catalog_controls = $('#custom_catalog_controls');
	var item_print_count = $('#item_print_count');

	var print_form = $('#print_this');
	var item_row = $('.item-row');
	var item_checkbox = $('.item-checkbox');

	var queryArr = [];
	var queryCount = 0;

	item_row.on(
		'click',
		function (event) {
			var _act_item = $(this);
			var _act_check = _act_item.find('.item-checkbox');

			_act_item.toggleClass('active');
			_act_check.trigger('click');
		});

	item_checkbox.on(
		'click',
		function (event) {
			event.stopPropagation();

			var val = $(this).attr('id');
			var item_name = $(this).attr('data-item-name');
			var message = "";

			if (this.checked) {
				var i = new query_box();
				i.val(val).attr('id', val);

				print_form.prepend(i);
				queryArr.push(val);
				queryCount++;

				var message = "Added \"";
			} else {
				$('input#' + val).remove();

				_removeFromArr(queryArr, val);
				queryCount--;

				var message = "Removed \"";
			}

			var message = message + item_name + "\" to Custom Catalog";

			new _disp_info(message);

			if (queryArr.length > 0) {
				custom_catalog_controls.addClass('active');

				item_print_count.html(queryArr.length);
			} else {
				custom_catalog_controls.removeClass('active');
			}
		});

	var report_table = $('#report_table');

	if (report_table) {
		report_table.DataTable({
			"pageLength": 100,
			stateSave: true,
			"scrollY": pageHeight,
			"scrollX": true,
			"tabIndex": 1,
			"search": {
				"regex": true,
				"smart": true
			}
		});
	}

});

</script>