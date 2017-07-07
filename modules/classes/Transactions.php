<?php

date_default_timezone_set("Africa/Nairobi");

class Transactions extends Database {

    public function execute() {
        if ($_POST['action'] == "add_transaction") {
            return $this->addTransaction();
        } else if ($_POST['action'] == "add_piracy_report") {
            return $this->addPiracyReport();
        }
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
        $sql = "SELECT A.id, A.buyer_id, A.createdat, B.book_id, B.quantity, B.unit_price, B.assigned_staff, B.authorizedat, B.authorizedby, B.status FROM transactions A RIGHT OUTER JOIN transaction_details B ON A.id=B.transaction_id WHERE B.publisher=:publisher ORDER BY A.createdat DESC";
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
                $values = array("id" => $data['id'], "buyer_id" => $data['buyer_id'], "book_id" => $data['book_id'], "quantity" => $data['quantity'], "unit_price" => $data['unit_price'], "createdat" => $data['createdat'], "authorizedat" => $data['authorizedat'], "authorizedby" => $data['authorizedby'], "status" => $data['status']);
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
                $values = array("id" => $data['id'], "transaction_type" => $data['transaction_type'], "amount" => $data['amount'], "buyer_type" => $data['buyer_type'], "buyer_id" => $data['buyer_id'], "payment_option" => $data['payment_option'], "createdat" => $data['createdat'], "status" => $data['status']);
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
                $values = array("id" => $data['id'], "transaction_id" => $data['transaction_id'], "book_id" => $data['book_id'], "quantity" => $data['quantity'], "unit_price" => $data['unit_price'], "print_type" => $data['print_type'], "publisher_type" => $data['publisher_type'], "publisher" => $data['publisher'], "expireat" => $data['expireat']);
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
                $values = array("id" => $data['id'], "transaction_id" => $data['transaction_id'], "book_id" => $data['book_id'], "quantity" => $data['quantity'], "unit_price" => $data['unit_price']);
                array_push($values2, $values);
            }
            return json_encode($values2);
        }
    }

}
