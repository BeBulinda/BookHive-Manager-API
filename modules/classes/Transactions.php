<?php

date_default_timezone_set("Africa/Nairobi");
require_once WPATH . "modules/classes/Users.php";

class Transactions extends Database {

    public function execute() {
        if ($_POST['action'] == "add_transaction") {
            return $this->addTransaction();
        } else if ($_POST['action'] == "add_piracy_report") {
            return $this->addPiracyReport();
        } else if ($_POST['action'] == "create_csv") {
            
            argDump("test");
            argDump("test");
            argDump("test");
            argDump("test");
            argDump("test");
            exit();
            
            return $this->createCSV();
        }
    }

    private function createCSV() {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=data.csv');

        $output = fopen("php://output", "w");
        $fputcsv($output, array("Transaction ID", "Buyer's Name", "Book Title", "Quantity", "Unit Price", "Created At", "Status"));

        if (isset($_SESSION['publisher_staff']) && $_SESSION['publisher_staff'] == true) {
            $publisher_code = $_SESSION['user_details']['reference_id'];
        } else {
            $publisher_code = $_SESSION['userid'];
        }

        $transaction_data[] = $this->getAllPublisherTransactions($publisher_code);

//        if (isset($_SESSION['no_records']) AND $_SESSION['no_records'] == true) {
//            echo "<tr>";
//            echo "<td>  No record found...</td>";
//            echo "<td> </td>";
//            echo "<td> </td>";
//            echo "<td> </td>";
//            echo "<td> </td>";
//            echo "<td> </td>";
//            echo "<td> </td>";
//            echo "</tr>";
//            unset($_SESSION['no_records']);
//        } else if (isset($_SESSION['yes_records']) AND $_SESSION['yes_records'] == true) {
            foreach ($transaction_data as $key => $value) {
                $inner_array[$key] = json_decode($value, true); // this will give key val pair array
                foreach ((array) $inner_array[$key] as $key2 => $value2) {
                    if ($value2['status'] == 1000) {
                        $delivery_status = "DELETED";
                    } else if ($value2['status'] == 1001) {
                        $delivery_status = "AWAITING APPROVAL";
                    } else if ($value2['status'] == 1002) {
                        $delivery_status = "NOT ACTIVE";
                    } else if ($value2['status'] == 1021) {
                        $delivery_status = "ACTIVE";
                    } else if ($value2['status'] == 1010) {
                        $delivery_status = "APPROVAL REJECTED";
                    } else if ($value2['status'] == 1011) {
                        $delivery_status = "DELIVERY IN PROGRESS";
                    } else if ($value2['status'] == 1012) {
                        $delivery_status = "ASSIGNED";
                    } else if ($value2['status'] == 1030) {
                        $delivery_status = "DELIVERY REJECTED";
                    } else if ($value2['status'] == 1031) {
                        $delivery_status = "DELIVERY CONFIRMED";
                    }
                    
                    $fputcsv($output, $value2);
//                    echo "<tr>";
//                    echo "<td> <a href='#'>" . $value2['transaction_id'] . "</td>";
//                    echo "<td>" . $value2['buyer_id'] . "</td>";
//                    echo "<td>" . $value2['book_id'] . "</td>";
//                    echo "<td>" . $value2['quantity'] . "</td>";
////                                                echo "<td>" . $value2['unit_price'] . "</td>";
//                    echo "<td>" . $value2['createdat'] . "</td>";
//                    echo "<td>" . $delivery_status . "</td>";
//                    echo "</tr>";
                }
                fclose($output);
            }
//            unset($_SESSION['yes_records']);
//        }
    }

    public function fetchTransactionItemDetails($code) {
        $sql = "SELECT * FROM transaction_details WHERE id=:code";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindParam("code", $code);
        $stmt->execute();
        $info = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $info[0];
    }

    public function fetchTransactionDetails($code) {
        $sql = "SELECT * FROM transactions WHERE id=:code";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindParam("code", $code);
        $stmt->execute();
        $info = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $info[0];
    }

    public function assignPiracy($publisher_type, $publisher, $code) {
        $sql = "UPDATE piracy_reports SET is_assigned=:is_assigned, assignedat=:assignedat, assignedby=:assignedby, assigned_publisher_type=:assigned_publisher_type, assigned_publisher=:assigned_publisher, status=1012 WHERE id=:code";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("code", $code);
        $stmt->bindValue("is_assigned", 'YES');
        $stmt->bindValue("assignedat", date("Y-m-d H:i:s"));
        $stmt->bindValue("assignedby", 01); //  echo $_SESSION['userid']);
        $stmt->bindValue("assigned_publisher_type", strtoupper($publisher_type));
        $stmt->bindValue("assigned_publisher", $publisher);
        if ($stmt->execute()) {
            return true;
        } else
            return false;
    }

    public function approveTransactionItem($code, $approval_comment, $delivery_time) {
        $transaction_item_details = $this->fetchTransactionItemDetails($code);
        $transaction_details = $this->fetchTransactionDetails($transaction_item_details['transaction_id']);

        $users = new Users();
        $contact_details = $users->fetchIndividualContactDetails($transaction_details['buyer_type'], $transaction_details['buyer_id']);

        $sql = "UPDATE transaction_details SET status=1011, authorizedat=:authorizedat, authorizedby=:authorizedby, approval_comment=:approval_comment, delivery_status=1011 WHERE id=:code";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("code", $code);
        $stmt->bindValue("authorizedby", 01); //  echo $_SESSION['userid']);
        $stmt->bindValue("authorizedat", date("Y-m-d H:i:s"));
        $stmt->bindValue("approval_comment", strtoupper($approval_comment));

        if ($stmt->execute()) {
            $sender = "hello@bookhivekenya.com";
            $headers = "From: Bookhive Kenya <$sender>\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $subject = "Order Processed Successfully";
            $message = "<html><body>"
//                    . "<p><b>Hello " . $_POST['firstname'] . ",</b><br/>"
                    . "<p><b>Hello,</b><br/>"
                    . "Your order referenced " . $transaction_item_details['transaction_id'] . " has been successfully processed. The delivery is in progress and your products will be delivered within the next " . $delivery_time . " day(s). <br/><br/>"
                    . "Once delivered, click on <a href='"
                    . " http://test.bookhivekenya.com/?confirm_delivery&item=delivery&update_type=approve&code=" . $code . "'>CONFIRM DELIVERY</a> to confirm receipt of your order<br/><br/>"
                    . "If the delivery is not in the expected mode, click on the link below: <a href='"
                    . " http://test.bookhivekenya.com/?confirm_delivery&item=delivery&update_type=reject&code=" . $code . "'>REJECT DELIVERY</a> to reject receipt of your order<br/><br/>"
                    . "Kindly contact us on +254 736 249665 for any assistance. <br/>"
                    . "Visit <a href='http://www.bookhivekenya.com'>bookhivekenya.com</a> for more information.<br/>"
//                . "Powered by: <img style='vertical-align: middle;' src='http://www.kitambulisho.com/images/reflex_logo_black.png' width='50' alt='Reflex Concepts Logo'>"
                    . "</body></html>";

            mail(strtoupper($contact_details['email']), $subject, $message, $headers);

            return true;
        } else
            return false;
    }

    public function rejectTransactionItem($code, $approval_comment) {
        $transaction_item_details = $this->fetchTransactionItemDetails($code);
        $transaction_details = $this->fetchTransactionDetails($transaction_item_details['transaction_id']);

        $users = new Users();
        $contact_details = $users->fetchIndividualContactDetails($transaction_details['buyer_type'], $transaction_details['buyer_id']);

        $sql = "UPDATE transaction_details SET status=1010, authorizedat=:authorizedat, authorizedby=:authorizedby, approval_comment=:approval_comment, delivery_status=1010 WHERE id=:code";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("code", $code);
        $stmt->bindValue("authorizedby", 01); //  echo $_SESSION['userid']);
        $stmt->bindValue("authorizedat", date("Y-m-d H:i:s"));
        $stmt->bindValue("approval_comment", strtoupper($approval_comment));

        if ($stmt->execute()) {
            $sender = "hello@bookhivekenya.com";
            $headers = "From: Bookhive Kenya <$sender>\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $subject = "Order Rejected";
            $message = "<html><body>"
//                    . "<p><b>Hello " . $_POST['firstname'] . ",</b><br/>"
                    . "<p><b>Hello,</b><br/>"
                    . "Your order referenced " . $transaction_item_details['transaction_id'] . " was rejected. The reason(s) for rejection is/are: <br/>"
                    . $approval_comment . "<br/>"
                    . "Kindly contact us on +254 736 249665 for any assistance. <br/>"
                    . "Visit <a href='http://www.bookhivekenya.com'>bookhivekenya.com</a> for more information.<br/>"
//                . "Powered by: <img style='vertical-align: middle;' src='http://www.kitambulisho.com/images/reflex_logo_black.png' width='50' alt='Reflex Concepts Logo'>"
                    . "</body></html>";

            mail(strtoupper($contact_details['email']), $subject, $message, $headers);

            return true;
        } else
            return false;
    }

    public function deletePiracy($code) {
        $sql = "UPDATE piracy_reports SET status=1000 WHERE id=:code";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("code", $code);
        if ($stmt->execute()) {
            return true;
        } else
            return false;
    }

    public function closePiracy($code) {
        $sql = "UPDATE piracy_reports SET status=1002 WHERE id=:code";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("code", $code);
        if ($stmt->execute()) {
            return true;
        } else
            return false;
    }

    public function closeInboxMessage($code) {
        $sql = "UPDATE inbox_messages SET status=1002 WHERE id=:code";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("code", $code);
        if ($stmt->execute()) {
            return true;
        } else
            return false;
    }

    public function approveBook($code) {
        $sql = "UPDATE books SET status=1021 WHERE id=:code";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("code", $code);
        if ($stmt->execute()) {
            return true;
        } else
            return false;
    }

    public function rejectBook($code) {
        $sql = "UPDATE books SET status=1010 WHERE id=:code";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("code", $code);
        if ($stmt->execute()) {
            return true;
        } else
            return false;
    }

    public function activateBook($code) {
        $sql = "UPDATE books SET status=1021 WHERE id=:code";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("code", $code);
        if ($stmt->execute()) {
            return true;
        } else
            return false;
    }

    public function deactivateBook($code) {
        $sql = "UPDATE books SET status=1002 WHERE id=:code";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("code", $code);
        if ($stmt->execute()) {
            return true;
        } else
            return false;
    }

//    public function approveTransactionItem($code) {
//        $sql = "UPDATE transaction_details SET status=1011, authorizedat=:authorizedat, authorizedby=:authorizedby WHERE id=:code";
//        $stmt = $this->prepareQuery($sql);
//        $stmt->bindValue("code", $code);
//        $stmt->bindValue("authorizedby", 01); //  echo $_SESSION['userid']);
//        $stmt->bindValue("authorizedat", date("Y-m-d H:i:s"));
//        if ($stmt->execute()) {
//            
//        
//        $sender = "hello@bookhivekenya.com";
//        $headers = "From: Bookhive Kenya <$sender>\r\n";
//        $headers .= "MIME-Version: 1.0\r\n";
//        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
//        $subject = "Order Processed Successfully";
//        $message = "<html><body>"
//                . "<p><b>Hello " . $_POST['firstname'] . ",</b><br/>"
//                . "Your order referenced {} has been successfully processed. The delivery is in progress and your products will be delivered within the next 24 hours. <br/>"
//                . "Once delivered, click on the link below: <a href='"
//                . " http://access.bookhivekenya.com/??update_element&item=delivery&update_type=approve&code=" . $code . "'>CONFIRM DELIVERY</a> to confirm receipt of your order<br/>"
//                . "If the delivery is not in the expected mode, click on the link below: <a href='"
//                . " http://access.bookhivekenya.com/?update_element&item=delivery&update_type=reject&code=" . $code . "'>REJECT DELIVERY</a> to reject receipt of your order<br/>"
//                . "Kindly contact us on +254 736 249665 for any assistance. <br/>"
//                . "Visit <a href='http://www.bookhivekenya.com'>bookhivekenya.com</a> for more information.<br/>"
////                . "Powered by: <img style='vertical-align: middle;' src='http://www.kitambulisho.com/images/reflex_logo_black.png' width='50' alt='Reflex Concepts Logo'>"
//                . "</body></html>";
//
//        mail(strtoupper($_POST['email']), $subject, $message, $headers);
//        
//            
//            return true;
//        } else
//            return false;
//    }
//    public function rejectTransactionItem($code) {
//        $sql = "UPDATE transaction_details SET status=1010, authorizedat=:authorizedat, authorizedby=:authorizedby WHERE id=:code";
//        $stmt = $this->prepareQuery($sql);
//        $stmt->bindValue("code", $code);
//        $stmt->bindValue("authorizedby", 01); //  echo $_SESSION['userid']);
//        $stmt->bindValue("authorizedat", date("Y-m-d H:i:s"));
//        if ($stmt->execute()) {
//            return true;
//        } else
//            return false;
//    }

    public function approveItemDelivery($code) {
        $sql = "UPDATE transaction_details SET delivery_status=1031, deliveredat=:deliveredat WHERE id=:code";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("code", $code);
        $stmt->bindValue("deliveredat", date("Y-m-d H:i:s"));
        if ($stmt->execute()) {
            return true;
        } else
            return false;
    }

    public function rejectItemDelivery($code) {
        $sql = "UPDATE transaction_details SET delivery_status=1030, deliveredat=:deliveredat WHERE id=:code";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("code", $code);
        $stmt->bindValue("deliveredat", date("Y-m-d H:i:s"));
        if ($stmt->execute()) {
            return true;
        } else
            return false;
    }

    public function updateTransaction($item, $code, $update_type) {
        if ($update_type == "deactivate") {
            $sql = "UPDATE transactions SET status=1002, lastmodifiedby=:lastmodifiedby, lastmodifiedat=:lastmodifiedat WHERE id=:code";
        } else if ($update_type == "activate") {
            $sql = "UPDATE transactions SET status=1001, lastmodifiedby=:lastmodifiedby, lastmodifiedat=:lastmodifiedat WHERE id=:code";
        } else if ($update_type == "delete") {
            $sql = "UPDATE transactions SET status=1000, lastmodifiedby=:lastmodifiedby, lastmodifiedat=:lastmodifiedat WHERE id=:code";
        }
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("code", $code);
        $stmt->bindValue("lastmodifiedby", 01); //  echo $_SESSION['userid']);
        $stmt->bindValue("lastmodifiedat", date("Y-m-d H:i:s"));
        if ($stmt->execute()) {
            return true;
        } else
            return false;
    }

    private function addPiracyReport() {
        $sql = "INSERT INTO piracy_reports (reporter_type, reported_by, seller_name, book_photo, receipt_photo, description)"
                . " VALUES (:reporter_type, :reported_by, :seller_name, :book_photo, :receipt_photo, :description)";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("reporter_type", strtoupper($_POST['reporter_type']));
        $stmt->bindValue("reported_by", strtoupper($_POST['reported_by']));
        $stmt->bindValue("seller_name", strtoupper($_POST['seller_name']));
        $stmt->bindValue("book_photo", $_SESSION['book_photo']);
        $stmt->bindValue("receipt_photo", $_SESSION['receipt_photo']);
        $stmt->bindValue("description", strtoupper($_POST['description']));
        $stmt->execute();
        return true;
    }

    public function getAllPublisherPiracyReports($publisher_code) {
        $sql = "SELECT * FROM piracy_reports WHERE assigned_publisher=:assigned_publisher ORDER BY id ASC";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("assigned_publisher", $publisher_code);
        $stmt->execute();
        $info = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($info) == 0) {
            $_SESSION['no_records'] = true;
        } else {
            $_SESSION['yes_records'] = true;
            $values2 = array();
            foreach ($info as $data) {
                $values = array("id" => $data['id'], "reporter_type" => $data['reporter_type'], "reported_by" => $data['reported_by'], "seller_name" => $data['seller_name'], "book_title" => $data['book_title'], "book_photo" => $data['book_photo'], "receipt_photo" => $data['receipt_photo'], "county" => $data['county'], "sub_county" => $data['sub_county'], "location" => $data['location'], "description" => $data['description'], "createdat" => $data['createdat'], "is_assigned" => $data['is_assigned'], "assignedat" => $data['assignedat'], "assignedby" => $data['assignedby'], "assigned_publisher_type" => $data['assigned_publisher_type'], "assigned_publisher" => $data['assigned_publisher'], "assigned_staff" => $data['assigned_staff'], "status" => $data['status']);
                array_push($values2, $values);
            }
            return json_encode($values2);
        }
    }

    public function getAllPiracyReports() {
        $sql = "SELECT * FROM piracy_reports ORDER BY id ASC";
        $stmt = $this->prepareQuery($sql);
        $stmt->execute();
        $info = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($info) == 0) {
            $_SESSION['no_records'] = true;
        } else {
            $_SESSION['yes_records'] = true;
            $values2 = array();
            foreach ($info as $data) {
                $values = array("id" => $data['id'], "reporter_type" => $data['reporter_type'], "reported_by" => $data['reported_by'], "seller_name" => $data['seller_name'], "book_title" => $data['book_title'], "book_photo" => $data['book_photo'], "receipt_photo" => $data['receipt_photo'], "county" => $data['county'], "sub_county" => $data['sub_county'], "location" => $data['location'], "description" => $data['description'], "createdat" => $data['createdat'], "is_assigned" => $data['is_assigned'], "assignedat" => $data['assignedat'], "assignedby" => $data['assignedby'], "assigned_publisher_type" => $data['assigned_publisher_type'], "assigned_publisher" => $data['assigned_publisher'], "assigned_staff" => $data['assigned_staff'], "status" => $data['status']);
                array_push($values2, $values);
            }
            return json_encode($values2);
        }
    }

    public function getAllInboxMessages() {
        $sql = "SELECT * FROM inbox_messages ORDER BY id ASC";
        $stmt = $this->prepareQuery($sql);
        $stmt->execute();
        $info = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($info) == 0) {
            $_SESSION['no_records'] = true;
        } else {
            $_SESSION['yes_records'] = true;
            $values2 = array();
            foreach ($info as $data) {
                $values = array("id" => $data['id'], "name" => $data['name'], "email" => $data['email'], "subject" => $data['subject'], "message" => $data['message'], "createdat" => $data['createdat'], "is_assigned" => $data['is_assigned'], "assignedat" => $data['assignedat'], "assignedby" => $data['assignedby'], "assigned_publisher" => $data['assigned_publisher'], "assigned_staff" => $data['assigned_staff'], "status" => $data['status']);
                array_push($values2, $values);
            }
            return json_encode($values2);
        }
    }

    public function getAllPublisherTransactions($publisher_code) {
        $sql = "SELECT A.id AS transaction_id, A.buyer_id, A.createdat, B.id AS transaction_detail_id, B.book_id, B.quantity, B.unit_price, B.assigned_staff, B.authorizedat, B.authorizedby, B.status, B.delivery_status FROM transactions A RIGHT OUTER JOIN transaction_details B ON A.id=B.transaction_id WHERE B.publisher=:publisher ORDER BY A.createdat DESC";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("publisher", $publisher_code);
        $stmt->execute();
        $info = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($info) == 0) {
            $_SESSION['no_records'] = true;
        } else {
            $_SESSION['yes_records'] = true;
            $values2 = array();
            foreach ($info as $data) {
                $values = array("transaction_id" => $data['transaction_id'], "transaction_detail_id" => $data['transaction_detail_id'], "buyer_id" => $data['buyer_id'], "book_id" => $data['book_id'], "quantity" => $data['quantity'], "unit_price" => $data['unit_price'], "createdat" => $data['createdat'], "authorizedat" => $data['authorizedat'], "authorizedby" => $data['authorizedby'], "status" => $data['status'], "delivery_status" => $data['delivery_status']);
                array_push($values2, $values);
            }
            return json_encode($values2);
        }
    }

    public function getAllTransactions() {
        $sql = "SELECT * FROM transactions ORDER BY createdat DESC";
        $stmt = $this->prepareQuery($sql);
        $stmt->execute();
        $info = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($info) == 0) {
            $_SESSION['no_records'] = true;
        } else {
            $_SESSION['yes_records'] = true;
            $values2 = array();
            foreach ($info as $data) {
                $values = array("transaction_id" => $data['id'], "transaction_type" => $data['transaction_type'], "amount" => $data['amount'], "buyer_type" => $data['buyer_type'], "buyer_id" => $data['buyer_id'], "payment_option" => $data['payment_option'], "createdat" => $data['createdat'], "status" => $data['status']);
                array_push($values2, $values);
            }
            return json_encode($values2);
        }
    }

    public function getTransactionDetails($transaction_id) {
        $sql = "SELECT * FROM transaction_details WHERE transaction_id=:transaction_id ORDER BY id ASC";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("transaction_id", $transaction_id);
        $stmt->execute();
        $info = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($info) == 0) {
            $_SESSION['no_records'] = true;
        } else {
            $_SESSION['yes_records'] = true;
            $values2 = array();
            foreach ($info as $data) {
                $values = array("id" => $data['id'], "transaction_id" => $data['transaction_id'], "book_id" => $data['book_id'], "quantity" => $data['quantity'], "unit_price" => $data['unit_price'], "print_type" => $data['print_type'], "publisher_type" => $data['publisher_type'], "publisher" => $data['publisher'], "assigned_staff" => $data['assigned_staff'], "authorizedat" => $data['authorizedat'], "authorizedby" => $data['authorizedby'], "approval_comment" => $data['approval_comment'], "status" => $data['status'], "delivery_status" => $data['delivery_status'], "deliveredat" => $data['deliveredat'], "expireat" => $data['expireat']);
                array_push($values2, $values);
            }
            return json_encode($values2);
        }
    }

    public function getAllTransactionDetails() {
        $sql = "SELECT * FROM transaction_details ORDER BY id ASC";
        $stmt = $this->prepareQuery($sql);
        $stmt->execute();
        $info = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($info) == 0) {
            $_SESSION['no_records'] = true;
        } else {
            $_SESSION['yes_records'] = true;
            $values2 = array();
            foreach ($info as $data) {
                $values = array("id" => $data['id'], "transaction_id" => $data['transaction_id'], "book_id" => $data['book_id'], "quantity" => $data['quantity'], "unit_price" => $data['unit_price'], "print_type" => $data['print_type'], "publisher_type" => $data['publisher_type'], "publisher" => $data['publisher'], "assigned_staff" => $data['assigned_staff'], "authorizedat" => $data['authorizedat'], "authorizedby" => $data['authorizedby'], "approval_comment" => $data['approval_comment'], "status" => $data['status'], "delivery_status" => $data['delivery_status'], "deliveredat" => $data['deliveredat'], "expireat" => $data['expireat']);
                array_push($values2, $values);
            }
            return json_encode($values2);
        }
    }

}
