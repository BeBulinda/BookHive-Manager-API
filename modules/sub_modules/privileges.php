<?php
if (!App::isLoggedIn())
    App::redirectTo("?");
require_once WPATH . "modules/classes/System_Administration.php";
require_once WPATH . "modules/classes/Users.php";
$users = new Users();
$system_administration = new System_Administration();
?>
<div class="col-lg-5">
    <div class="panel">
        <header class="panel-heading">
            <i class="fa fa-shield"></i>  System Privileges
            <a href="?view_system_privileges" class="btn btn-success sub-sub-menu-buttons">
                <i class="fa fa-edit"></i> 
                Edit System Privileges
            </a>
        </header>
        <div class="panel-body">
            <table class="table table-striped">
                <tr>
                    <th>Privilege ID</th>
                    <th>Name</th>
                    <th>Component</th>

                </tr> 
                <?php
                if (!empty($_POST)) {
                    $info = $system_administration->execute();
                } else if (is_menu_set('view_system_privileges_notifications') != "") {
                    $info = $system_administration->getAllSystemPrivilegeNotifications();
                } else {
                    $info = $system_administration->getAllSystemPrivileges();
                }
                $total_records = count($info);
                if (count($info) == 0) {
                    echo "<tr>";
                    echo "<td>  No record found...</td>";
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

                        $createdby = $users->fetchStaffDetails($data['createdby']);

                        echo "<tr>";
                        echo "<td> <a href='?view_system_privileges_individual&code=" . $data['id'] . "'>" . $data['id'] . "</td>";
                        echo "<td>" . $data['name'] . "</td>";
                        echo "<td>" . $data['component'] . "</td>";
                        echo "</tr>";
                    }
                }
                ?>

            </table>
        </div><!-- /.panel-body -->
    </div><!-- /.panel -->
</div>
