<?php
//if (!App::isLoggedIn()) {
//    App::redirectTo("?");
//}
require_once WPATH . "modules/classes/Transactions.php";
$transactions = new Transactions();

unset($_SESSION['transaction']);
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Transactions</a> </div>
        <h1>Transactions</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>Transactions</h5>
                        <?php require_once('modules/menus/sub-sub-menu-buttons.php'); ?>
                    </div>
                    <div class="widget-content nopadding">

                        <table class="table table-bordered data-table">
                            <tbody>
                                <tr>
                                    <th><h5>Transaction ID</h5></th>
                                    <th><h5>Transacted By</h5></th>   
                                    <th><h5>Amount</h5></th>                                 
                                    <th><h5>Payment Option</h5></th>
<!--                                    <th><h5>Created At</h5></th>
                                    <th><h5>Status</h5></th>-->
                                    <th><h5>Update</h5></th>
                                    <th><h5>Approve</h5></th>
                                    <th><h5>Reject</h5></th>
                                    <th><h5>Activate</h5></th>
                                    <th><h5>Delete</h5></th>
                                </tr>

                                <?php
                                if (!empty($_POST)) {
                                    $transaction_data[] = $transactions->execute();
                                } else {
                                    $transaction_data[] = $transactions->getAllTransactions();
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
                                    foreach ($transaction_data as $key => $value) {
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
                                            echo "<td> <a href='?individual_transaction&code=" . $value2['id'] . "'>" . $value2['id'] . "</td>";
                                            echo "<td>" . $value2['transactedby'] . "</td>";
                                            echo "<td>" . $value2['amount'] . "</td>";
                                            echo "<td>" . $value2['payment_option'] . "</td>";
//                                            echo "<td>" . $value2['createdat'] . "</td>";
//                                            echo "<td>" . $status . "</td>";
                                            echo "<td> <a href='?update_transaction&update_type=edit&code=" . $value2['id'] . "'> EDIT </td>";

                                            if ($value2['status'] == 1001) {
                                                echo "<td> <a href='?update_transaction&update_type=accept_approval&code=" . $value2['id'] . "'> APPROVE </td>";
                                                echo "<td> <a href='?update_transaction&update_type=reject_approval&code=" . $value2['id'] . "'> REJECT </td>";
                                            }

                                            if ($value2['status'] == 1002) {
                                                echo "<td> <a href='?update_transaction&update_type=activate&code=" . $value2['id'] . "'> ACTIVATE </td>";
                                            } else if ($value2['status'] == 1021) {
                                                echo "<td> <a href='?update_transaction&update_type=deactivate&code=" . $value2['id'] . "'> DEACTIVATE </td>";
                                            }

                                            echo "<td> <a href='?update_transaction&update_type=delete&code=" . $value2['id'] . "'> DElETE </td>";

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