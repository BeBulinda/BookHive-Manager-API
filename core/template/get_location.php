<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_POST["location_id"])) {
	$query ="SELECT * FROM locations WHERE sub_county_id = '" . $_POST["location_id"] . "'";
	$results = $db_handle->runQuery($query);
?>
	<option value="">Select Location</option>
<?php
	foreach($results as $location) {
?>
	<option value="<?php echo $location["id"]; ?>"><?php echo $location["name"]; ?></option>
<?php
	}
}
?>