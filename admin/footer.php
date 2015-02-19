</body>
<script src="<?php echo "$host";?>/javascripts/bootstrap.js"></script>
<script src="<?php echo "$host";?>/javascripts/jquery.dataTables.min.js"></script>
<?php if ($dataTables) { ?>
<script src="<?php echo "$host";?>/javascripts/dataTables.tableTools.min.js"></script>
<script src="<?php echo "$host";?>/javascripts/dataTables.bootstrap.js"></script>
<?php } ?>
<?php if($charts) { ?>
<script src="<?php echo "$host";?>/javascripts/Chart.min.js"></script>
<?php } ?>
<?php if ($bootstrapWYSIWYG) { ?>
<script src="<?php echo "$host";?>/javascripts/bootstrap-wysiwyg.js"></script>
<script src="<?php echo "$host";?>/javascripts/jquery.hotkeys.js"></script>
<?php } ?>
<script src="<?php echo "$host";?>/javascripts/bees.js"></script>