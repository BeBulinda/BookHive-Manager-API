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
                $values = array("id" => $data['id'], "reporter_type" => $data['reporter_type'], "reported_by" => $data['reported_by'], "seller_name" => $data['seller_name'], "book_photo" => $data['book_photo'], "receipt_photo" => $data['receipt_photo'], "description" => $data['description'], "createdat" => $data['createdat'], "reviewedat" => $data['reviewedat'], "reviewedby" => $data['reviewedby'], "status" => $data['status']);
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
                $values = array("id" => $data['id'], "name" => $data['name'], "email" => $data['email'], "subject" => $data['subject'], "message" => $data['message'], "createdat" => $data['createdat'], "reviewedat" => $data['reviewedat'], "reviewedby" => $data['reviewedby'], "status" => $data['status']);
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
                $values = array("id" => $data['id'], "transaction_type" => $data['transaction_type'], "amount" => $data['amount'], "buyer_type" => $data['buyer_type'], "buyer_id" => $data['buyer_id'], "payment_option" => $data['payment_option'], "createdat" => $data['createdat'], "authorizedat" => $data['authorizedat'], "authorizedby" => $data['authorizedby'], "status" => $data['status']);
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
                $values = array("id" => $data['id'], "transaction_id" => $data['transaction_id'], "book_id" => $data['book_id'], "quantity" => $data['quantity'], "unit_price" => $data['unit_price'], "book_version" => $data['book_version'], "publisher_type" => $data['publisher_type'], "publisher" => $data['publisher'], "expireat" => $data['expireat']);
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
