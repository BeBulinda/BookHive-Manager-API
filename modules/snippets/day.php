<?php
$maxDate = 31;
foreach (range(1, $maxDate) as $value) {
    echo "<option value=" . $value . ">" . $value . "</option>";
}
?>