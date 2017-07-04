<?php
if (!App::isLoggedIn()) App::redirectTo("?");
require_once WPATH . "modules/classes/Users.php";
$users = new Users();

unset($_SESSION['contact']);
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="?home" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="?view_contacts" class="current">Contacts</a> </div>
        <h1>Contacts</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>Contacts</h5>
                        <?php require_once('modules/menus/sub-sub-menu-buttons.php'); ?>
                    </div>
                    <div class="widget-content nopadding">

                        <table class="table table-bordered data-table">
                            <tbody>
                                <tr>
                                    <th><h5>ID</h5></th>
                                    <th><h5>User Type</h5></th>
                                    <th><h5>Phone Number</h5></th>
                                    <th><h5>Email</h5></th>
                                    <th><h5>Physical Location</h5></th>
                                    <th><h5>Status</h5></th>
                                </tr>
                                
                                <?php
                                if (!empty($_POST)) {
                                    $contacts[] = $users->execute();
                                } else {
                                    $contacts[] = $users->getAllContacts();
                                }
                                if (isset($_SESSION['no_records']) AND $_SESSION['no_records'] == true) {
                                    echo "<tr>";
                                    echo "<td>  No record found...</td>";
                                    echo "<td> </td>";
                                    echo "<td> </td>";
                                    echo "<td> </td>";
                                    echo "<td> </td>";
                                    echo "<td> </td>";
                                    echo "</tr>";
                                    unset($_SESSION['no_records']);
                                } else if (isset($_SESSION['yes_records']) AND $_SESSION['yes_records'] == true) {
                                    foreach ($contacts as $key => $value) {
                                        $inner_array[$key] = json_decode($value, true); // this will give key val pair array
                                        foreach ((array) $inner_array[$key] as $key2 => $value2) {
                                                if ($value2['status'] == 1000) {
                                                $status = "DELETED";
                                            } else if ($value2['status'] == 1001) {
                                                $status = "AWAITING APPROVAL";
                                            } else if ($value2['status'] == 1002) {
                                                $status = "NOT ACTIVE";
                                            } else if ($value2['status'] == 1021) {
                                                $status = "ACTIVE";
                                            } else if ($value2['status'] == 1011) {
                                                $status = "APPROVAL ACCEPTED";
                                            } else if ($value2['status'] == 1010) {
                                                $status = "APPROVAL REJECTED";
                                            }
                                            echo "<tr>";
                                            echo "<td> <a href='?individual_contact&code=" . $value2['id'] . "'>" . $value2['id'] . "</td>";
                                            echo "<td>" . $value2['reference_type'] . "</td>";
                                            echo "<td>" . $value2['phone_number'] . "</td>";
                                            echo "<td>" . $value2['email'] . "</td>";
                                            echo "<td>" . $value2['location'] . "</td>";
                                            echo "<td>" . $status . "</td>";
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