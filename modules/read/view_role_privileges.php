<?php
if (!App::isLoggedIn()) App::redirectTo("?");
require_once WPATH . "modules/classes/System_Administration.php";
$system_administration = new System_Administration();

unset($_SESSION['role_privilege']);
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Book Levels</a> </div>
        <h1>Book Levels</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>Book Levels</h5>
                        <?php require_once('modules/menus/sub-sub-menu-buttons.php'); ?>
                    </div>
                    <div class="widget-content nopadding">

                        <table class="table table-bordered data-table">
                            <tbody>
                                <tr>
                                    <th><h5>Privilege ID</h5></th>
                                    <th><h5>Name</h5></th>
                                    <th><h5>Created At</h5></th>
                                    <th><h5>Status</h5></th>
                                </tr>

                                <?php
                                if (!empty($_POST)) {
                                    $role_privileges[] = $system_administration->execute();
                                } else {
                                    $role_privileges[] = $system_administration->getAllRolePrivileges($_SESSION['role']);
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
                                    foreach ($system_privileges as $key => $value) {
                                        $inner_array[$key] = json_decode($value, true); // this will give key val pair array
                                        foreach ((array) $inner_array[$key] as $key2 => $value2) {                                            
                                            if ($value2['status'] == 1000) {
                                                $status = "DELETED";
                                            } else if ($value2['status'] == 1021) {
                                                $status = "ACTIVE";
                                                $action = "<a href='?view_role_privileges&user_type={$value2['user_type']}&privilege={$value2['privilege']}&update_type=deactivate'>DEACTIVATE</a>";
                                            } else if ($value2['status'] == 1002) {
                                                $status = "NOT ACTIVE";
                                                $action = "<a href='?view_role_privileges&user_type={$value2['user_type']}&privilege={$value2['privilege']}&update_type=activate'>ACTIVATE</a>";
                                            }
                                            echo "<tr>";
                                            $privilege = $system_administration->fetchSystemPrivilegeDetails($value2['privilege']);
                                            echo "<td>" . $value2['id'] . "</td>";
                                            echo "<td>" . $privilege['name'] . "</td>";
                                            echo "<td>" . $value2['createdat'] . "</td>";
                                            echo "<td>" . $status . "</td>";
                                            echo "<td>" . $action . "</td>";
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