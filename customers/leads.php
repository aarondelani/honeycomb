<?php
	// Need page preferences here
	$page_title .= "Leads";
	$body_class = "";
	$lead_page_active = TRUE;
	$autocomplete = TRUE;
	$view_lead = FALSE;

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
	 					$english_timestamp = date('D, F jS, Y, g:ia T', strtotime($lead["timestamp"]));
		?>
				<strong><?php echo $english_timestamp; ?></strong><br>
				<strong>Company:</strong> <?php echo $lead["company"]; ?><br>

				<strong>Event:</strong> <?php echo $lead["event"]; ?><br>

				<strong>Contact:</strong> <?php echo $lead["first_name"]; ?> <?php echo $lead["last_name"]; ?> <br>
				<div class="message">
					<h4>Message:</h4>
					<?php echo $lead["message"]; ?>
				</div>
				<hr>
				<div class="notes">
					<h4>Notes</h4>
				</div>



		<?php }}} else { ?>
		<h1>Leads</h1>

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