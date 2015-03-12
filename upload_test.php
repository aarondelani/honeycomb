<?php
	// Need page preferences here
	$errs = TRUE;
	$home_page_active = TRUE;
	$page_title = "Testing Upload";
	$body_class = "";

	include 'admin/vars.php';
	include 'admin/headers.php';
	include 'navigation.php';

	$upload_dir = "uploads/";
	$target_file = $upload_dir . basename($_FILES["files"]["name"]);
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	$file_state_upload = false;

// Check if image file is a actual image or fake image
$upload_result_msg = "";

if(isset($_POST["upload"]) && $_POST["action"] == "upload_file") {
	if (move_uploaded_file($_FILES["files"]['tmp_name'], $target_file)) {
	    $upload_result_msg .= "File is valid, and was successfully uploaded.\n";
	    $file_state_upload = TRUE;
	} else {
	    $upload_result_msg .= "Possible file upload attack!\n";
	}
}
?>
<div id="wrapper">
	<div id="content" class="container" role="main">
		<h1>Testing Upload</h1>

		<form action="upload_test.php" id="upload_form" method="post" enctype="multipart/form-data">
			<input type="hidden" name="action" value="upload_file">
			<input class="form-control" type="file" name="files[]">
			<input class="btn btn-primary" type="submit" name="upload" value="Upload">
		</form>

		<?php if ($file_state_upload):
		print_r($_FILES);
		echo $upload_result_msg;
		endif ?>
	</div>
</div>

<?php include 'admin/footer.php'; ?>

<script type="text/javascript">
$(document).ready(function(){

});
</script>