<?php
if (!App::isLoggedIn())
    App::redirectTo("?");
require_once WPATH . "modules/classes/Transactions.php";
$transactions = new Transactions();

unset($_SESSION['inbox_message']);
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="?home" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="?view_inbox_messages" class="current">Inbox Messages</a> </div>
        <h1>Inbox Messages</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>Inbox Messages</h5>
<?php require_once('modules/menus/sub-sub-menu-buttons.php'); ?>
                    </div>
                    <div class="widget-content nopadding">

                        <table class="table table-bordered data-table">
                            <tbody>
                                <tr>
                                    <th><h5>Message ID</h5></th>
                                    <th><h5>Sender's Name</h5></th>
                                    <th><h5>Sender's Email</h5></th>
                                    <th><h5>Subject</h5></th>
                                    <th><h5>Message</h5></th>
                                    <th><h5>Created At</h5></th>
                                    <th><h5>Status</h5></th>
                                    <th><h5>Action</h5></th>
                                </tr>

                                <?php
                                if (!empty($_POST)) {
                                    $inbox_messages[] = $transactions->execute();
                                } else {
                                    $inbox_messages[] = $transactions->getAllInboxMessages();
                                }
                                if (isset($_SESSION['no_records']) AND $_SESSION['no_records'] == true) {
                                    echo "<tr>";
                                    echo "<td>  No record found...</td>";
                                    echo "<td> </td>";
                                    echo "<td> </td>";
                                    echo "<td> </td>";
                                    echo "<td> </td>";
                                    echo "<td> </td>";
                                    echo "<td> </td>";
                                    echo "<td> </td>";
                                    echo "</tr>";
                                    unset($_SESSION['no_records']);
                                } else if (isset($_SESSION['yes_records']) AND $_SESSION['yes_records'] == true) {
                                    foreach ($inbox_messages as $key => $value) {
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
//                                            echo "<td> <a href='?individual_inbox_message&code=" . $value2['id'] . "'>" . $value2['id'] . "</td>";
                                            echo "<td> <a href='#'>" . $value2['id'] . "</td>";
                                            echo "<td>" . $value2['name'] . "</td>";
                                            echo "<td>" . $value2['email'] . "</td>";
                                            echo "<td>" . $value2['subject'] . "</td>";
                                            echo "<td>" . $value2['message'] . "</td>";
                                            echo "<td>" . $value2['createdat'] . "</td>";
                                            if ($value2['status'] == 1001) {
                                                echo "<td> OPEN </td>";
                                            } else {
                                                echo "<td> CLOSED </td>";
                                            }
                                            if ($value2['status'] == 1001) {
                                                echo "<td> <a href='?update_element&item=inbox_message&update_type=close&code=" . $value2['id'] . "'> CLOSE </td>";
                                            } else {
                                                echo "<td> CLOSED </td>";
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