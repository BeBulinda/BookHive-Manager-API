<?php
if (!App::isLoggedIn())
    App::redirectTo("?");
require_once WPATH . "modules/classes/Transactions.php";
$transactions = new Transactions();

unset($_SESSION['piracy_report']);
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="?home" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="?view_piracy_reports" class="current">Piracy Reports</a> </div>
        <h1>Piracy Reports</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>Piracy Reports</h5>
                        <?php require_once('modules/menus/sub-sub-menu-buttons.php'); ?>
                    </div>
                    <div class="widget-content nopadding">

                        <table class="table table-bordered data-table">
                            <tbody>
                                <tr>
                                    <th><h5>Report ID</h5></th>
                                    <th><h5>Reporter Type</h5></th>
                                    <th><h5>Reported By</h5></th>
                                    <th><h5>Seller's Name</h5></th>
                                    <th><h5>Created At</h5></th>
                                    <th><h5>Status</h5></th>
                                    <?php if (!isset($_SESSION['publisher_staff']) AND $_SESSION['logged_in_user_type_details']['name'] <> "PUBLISHER") { ?> 
                                        <th><h5>Assign</h5></th>
                                    <?php } ?>
                                    <th><h5>Action</h5></th>
                                </tr>

                                <?php
                                if (!empty($_POST)) {
                                    $piracy_reports[] = $transactions->execute();
                                } else if (($_SESSION['logged_in_user_type_details']['name'] == "PUBLISHER") OR ( isset($_SESSION['publisher_staff']) && $_SESSION['publisher_staff'] == true)) {
                                    if (isset($_SESSION['publisher_staff']) && $_SESSION['publisher_staff'] == true) {
                                        $publisher_code = $_SESSION['user_details']['reference_id'];
                                    } else {
                                        $publisher_code = $_SESSION['userid'];
                                    }
                                    $piracy_reports[] = $transactions->getAllPublisherPiracyReports($publisher_code);
                                } else {
                                    $piracy_reports[] = $transactions->getAllPiracyReports();
                                }
                                if (isset($_SESSION['no_records']) AND $_SESSION['no_records'] == true) {
                                    echo "<tr>";
                                    echo "<td>  No record found...</td>";
                                    echo "<td> </td>";
                                    echo "<td> </td>";
                                    echo "<td> </td>";
                                    echo "<td> </td>";
                                    echo "<td> </td>";
                                    if (!isset($_SESSION['publisher_staff']) AND $_SESSION['logged_in_user_type_details']['name'] <> "PUBLISHER") {
                                        echo "<td> </td>";
                                    }
                                    echo "<td> </td>";
                                    echo "</tr>";
                                    unset($_SESSION['no_records']);
                                } else if (isset($_SESSION['yes_records']) AND $_SESSION['yes_records'] == true) {
                                    foreach ($piracy_reports as $key => $value) {
                                        $inner_array[$key] = json_decode($value, true); // this will give key val pair array
                                        foreach ((array) $inner_array[$key] as $key2 => $value2) {
                                            if ($value2['status'] == 1000) {
                                                $status = "DELETED";
                                            } else if ($value2['status'] == 1001) {
                                                $status = "PENDING";
                                            } else if ($value2['status'] == 1002) {
                                                $status = "NOT ACTIVE";
                                            } else if ($value2['status'] == 1021) {
                                                $status = "ACTIVE";
                                            } else if ($value2['status'] == 1011) {
                                                $status = "APPROVAL ACCEPTED";
                                            } else if ($value2['status'] == 1010) {
                                                $status = "APPROVAL REJECTED";
                                            } else if ($value2['status'] == 1012) {
                                                $status = "ASSIGNED";
                                            }
                                            echo "<tr>";
                                            echo "<td> <a href='?individual_piracy_report&code=" . $value2['id'] . "'>" . $value2['id'] . "</td>";
                                            echo "<td>" . $value2['reporter_type'] . "</td>";
                                            echo "<td>" . $value2['reported_by'] . "</td>";
                                            echo "<td>" . $value2['seller_name'] . "</td>";
                                            echo "<td>" . $value2['createdat'] . "</td>";
                                            if (isset($_SESSION['publisher_staff']) OR $_SESSION['logged_in_user_type_details']['name'] == "PUBLISHER") {
                                                if ($value2['status'] == 1012) {
                                                    echo "<td> OPEN </td>";
                                                } else {
                                                    echo "<td> CLOSED </td>";
                                                }
                                                if ($value2['status'] == 1012) {
                                                    echo "<td> <a href='?update_element&item=piracy&update_type=close&code=" . $value2['id'] . "'> CLOSE </td>";
                                                } else {
                                                    echo "<td> CLOSED </td>";
                                                }
                                            } else {
                                                echo "<td>" . $status . "</td>";
                                                echo "<td> <a href='?update_element&item=piracy&update_type=assign&code=" . $value2['id'] . "'> ASSIGN </td>";
                                                echo "<td> <a href='?update_element&item=piracy&update_type=close&code=" . $value2['id'] . "'> CLOSE </td>";
                                                
//                                                echo "<td> <a href='?update_element&item=piracy&update_type=delete&code=" . $value2['id'] . "'> DELETE </td>";
                                            }
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