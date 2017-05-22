<?php
if (!App::isLoggedIn())
    App::redirectTo("?");
require_once WPATH . "modules/classes/System_Administration.php";
$system_administration = new System_Administration();
?>
<div class="col-lg-7">
    <div class="panel">
        <header class="panel-heading">
            <i class="fa fa-cogs"></i> System Components
            <a href="?view_system_components" class="btn btn-success sub-sub-menu-buttons">
                <i class="fa fa-edit"></i> 
                Edit System Components
            </a>
        </header>
        <div class="panel-body">
            <table class="table table-striped">
                <tr>
                    <th>Component ID</th>
                    <th>Component Name</th>
                    <th>Status</th>
                </tr> 
                <?php
                if (!empty($_POST)) {
                    $info = $system_administration->execute();
                } else if (is_menu_set('view_system_components_notifications') != "") {
                    $info = $system_administration->getAllSystemComponentNotifications();
                } else {
                    $info = $system_administration->getAllSystemComponents();
                }
                $total_records = count($info);
                if (count($info) == 0) {
                    echo "<tr>";
                    echo "<td>  No record found...</td>";
                    echo "<td> </td>";
                    echo "<td> </td>";
                    echo "<td> </td>";
                    echo "</tr>";
                    unset($_SESSION['no_records']);
                } else {
                    foreach ($info as $data) {
                        if ($data['status'] == 1000) {
                            $status = "DELETED";
                        } else if ($data['status'] == 1001 OR $data['status'] == 1032) {
                            $status = "AWAITING APPROVAL";
                        } else if ($data['status'] == 1010) {
                            $status = "APPROVAL REJECTED";
                        } else if ($data['status'] == 1011) {
                            $status = "APPROVAL ACCEPTED";
                        } else if ($data['status'] == 1020) {
                            $status = "NOT ACTIVE";
                        } else if ($data['status'] == 1021) {
                            $status = "ACTIVE";
                        }
                        echo "<tr>";
                        echo "<td> <a href='?view_system_components_individual&code=" . $data['id'] . "'>" . $data['id'] . "</td>";
                        echo "<td>" . $data['name'] . "</td>";
                        echo "<td>" . $status . "</td>";
                        echo "</tr>";
                    }
                }
                ?>

            </table>
        </div><!-- /.panel-body -->
    </div><!-- /.panel -->
</div>        
