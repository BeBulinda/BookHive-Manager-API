<?php
$currentYear = date('Y');
foreach (range(1940, $currentYear) as $value) {
    echo "<option value=" . $value . ">" . $value . "</option>";
}
?>