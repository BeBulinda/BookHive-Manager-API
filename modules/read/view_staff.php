<?php
if (!App::isLoggedIn()) App::redirectTo("?");
require_once WPATH . "modules/classes/Users.php";
require_once WPATH . "modules/classes/System_Administration.php";
$system_administration = new System_Administration();
$users = new Users();

unset($_SESSION['staff']);
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="?home" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="?view_staff" class="current">Staff Members</a> </div>
        <h1>Staff Members</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>Staff Members</h5>
                        <?php require_once('modules/menus/sub-sub-menu-buttons.php'); ?>
                    </div>
                    
                    <?php
                    if (isset($_SESSION['add_success'])) {
                        echo "Record successfully added...";
                        unset($_SESSION['add_success']);
                    } else if (!empty($_POST)) {
                        echo "Error adding record...";
                    }
                    ?>
                    
                    <div class="widget-content nopadding">

                        <table class="table table-bordered data-table">
                            <tbody>
                                <tr>
                                    <th><h5>Name</h5></th>
                                    <th><h5>Staff Level</h5></th>
                                    <th><h5>Institution</h5></th>
                                    <th><h5>Created At</h5></th>
                                    <th><h5>Status</h5></th>
                                </tr>
                                
                                <?php
                                if (!empty($_POST)) {
                                    $staff[] = $users->execute();
                                } else {
                                    $staff[] = $users->getAllStaff();
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
                                    foreach ($staff as $key => $value) {
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
                                            
                                            $user_type_details = $system_administration->fetchUserTypeDetails($value2['reference_type']);
                                            if ($user_type_details['name'] == "PUBLISHER") {
                                                $institution_details = $users->fetchPublisherDetails($value2['reference_id']);
                                                $institution_name = $institution_details['company_name'];
                                            } else if ($user_type_details['name'] == "BOOK SELLER") {
                                                $institution_details = $users->fetchBookSellerDetails($value2['reference_id']);
                                                $institution_name = $institution_details['company_name'];
                                            } else if ($user_type_details['name'] == "CORPORATE") {
                                                $institution_details = $users->fetchCorporateDetails($value2['reference_id']);
                                                $institution_name = $institution_details['company_name'];
                                            } else if ($user_type_details['name'] == "SELF PUBLISHER") {
                                                $institution_details = $users->fetchSelfPublisherDetails($value2['reference_id']);
                                                $institution_name = $institution_details['firstname'] . " " . $institution_details['lastname'];
                                            } else if ($user_type_details['name'] == "SCHOOL") {
                                                $institution_details = $users->fetchSchoolDetails($value2['reference_id']);
                                                $institution_name = $institution_details['school_name'];
                                            } else if ($user_type_details['name'] == "BOOKHIVE") {
                                                $institution_name = "BOOKHIVE";
                                            }
                                            
                                            echo "<tr>";
//                                            echo "<td> <a href='?individual_staff&code=" . $value2['id'] . "'>" . $value2['firstname'] . " " . $value2['lastname'] . "</td>";
                                            echo "<td> <a href='#'>" . $value2['firstname'] . " " . $value2['lastname'] . "</td>";
                                            echo "<td>" . $user_type_details['name'] . "</td>";
                                            echo "<td>" . $institution_name . "</td>";
                                            echo "<td>" . $value2['createdat'] . "</td>";
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