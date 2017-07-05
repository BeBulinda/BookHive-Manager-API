<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_POST["county_id"])) {
	$query ="SELECT * FROM sub_counties WHERE county_id = '" . $_POST["county_id"] . "'";
	$results = $db_handle->runQuery($query);
?>
	<option value="">Select County</option>
<?php
	foreach($results as $county) {
?>
	<option value="<?php echo $county["id"]; ?>"><?php echo $county["name"]; ?></option>
<?php
	}
}
?>