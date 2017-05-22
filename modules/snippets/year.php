<?php
$currentYear = date('Y');
foreach (range($currentYear, 1940) as $value) {
    echo "<option value=" . $value . ">" . $value . "</option>";
}
?>