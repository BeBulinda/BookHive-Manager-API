<?php
//if (!App::isLoggedIn()) {
//    App::redirectTo("?");
//}
require_once WPATH . "modules/classes/System_Administration.php";
$system_administration = new System_Administration();

unset($_SESSION['status']);
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="?home" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="?view_status_codes" class="current">Status Codes</a> </div>
        <h1>Status Codes</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>Status Codes</h5>
                        <?php require_once('modules/menus/sub-sub-menu-buttons.php'); ?>
                    </div>
                    <div class="widget-content nopadding">

                        <table class="table table-bordered data-table">
                            <tbody>
                                <tr>
                                    <th><h5>Code</h5></th>
                                    <th><h5>Description</h5></th>
                                    <th><h5>Update</h5></th>
                                    <th><h5>Activate</h5></th>
                                    <th><h5>Delete</h5></th>
                                </tr>

                                <?php
                                if (!empty($_POST)) {
                                    $statuses[] = $system_administration->execute();
                                } else {
                                    $statuses[] = $system_administration->getAllStatuses();
                                }
                                if (isset($_SESSION['no_records']) AND $_SESSION['no_records'] == true) {
                                    echo "<tr>";
                                    echo "<td>  No record found...</td>";
                                    echo "<td> </td>";
                                    echo "<td> </td>";
                                    echo "<td> </td>";
                                    echo "<td> </td>";
                                    echo "</tr>";
                                    unset($_SESSION['no_records']);
                                } else if (isset($_SESSION['yes_records']) AND $_SESSION['yes_records'] == true) {
                                    foreach ($statuses as $key => $value) {
                                        $inner_array[$key] = json_decode($value, true); // this will give key val pair array
                                        foreach ((array) $inner_array[$key] as $key2 => $value2) {
//                                            if ($value2['status'] == 1000) {
//                                                $status = "DELETED";
//                                            } else if ($value2['status'] == 1001) {
//                                                $status = "AWAITING APPROVAL";
//                                            } else if ($value2['status'] == 1002) {
//                                                $status = "NOT ACTIVE";
//                                            } else if ($value2['status'] == 1021) {
//                                                $status = "ACTIVE";
//                                            } else if ($value2['status'] == 1011) {
//                                                $status = "APPROVAL ACCEPTED";
//                                            } else if ($value2['status'] == 1010) {
//                                                $status = "APPROVAL REJECTED";
//                                            }
                                            echo "<tr>";
                                            echo "<td> <a href='?individual_status&code=" . $value2['id'] . "'>" . $value2['status_code'] . "</td>";
                                            echo "<td>" . $value2['description'] . "</td>";
                                            echo "<td> <a href='?update_status&update_type=edit&code=" . $value2['id'] . "'> EDIT </td>";
                                            
                                            if ($value2['status'] == 1002) {
                                                echo "<td> <a href='?update_status&update_type=activate&code=" . $value2['id'] . "'> ACTIVATE </td>";
                                            } else if ($value2['status'] == 1021) { 
                                                echo "<td> <a href='?update_status&update_type=deactivate&code=" . $value2['id'] . "'> DEACTIVATE </td>";
                                            }
                                            
                                            echo "<td> <a href='?update_status&update_type=delete&code=" . $value2['id'] . "'> DElETE </td>";
                                            echo "</tr>";
                                        }
                                    }
                                    unset($_SESSION['yes_records']);
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>