<?php
require_once('admin/database.php');
?>

Please Wait ...

<script type='text/javascript'>
/* alert('Because of security measures, you may be asked to login again. This is a standard procedure. '); */
window.top.location.href = '<?php echo ABSOLUTE_PATH; ?>/survey.php?sid=<?php echo $_GET['sid'];?>&NoviFormName=<?php echo $_GET['FormName'];?>&PangiaID=<?php echo $_GET['PangiaID'];?>';
</script>