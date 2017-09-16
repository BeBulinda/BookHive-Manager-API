<?php

date_default_timezone_set("Africa/Nairobi");
require_once WPATH . "modules/classes/System_Administration.php";
require_once WPATH . "modules/classes/Users.php";

class Books extends Database {

    public function execute() {
        if ($_POST['action'] == "add_book") {
            return $this->addBook();
        } else if ($_POST['action'] == "edit_book") {
            return $this->editBook();
        }
    }

    public function getBookLevelRefTypeId($level) {
        $sql = "SELECT id, status FROM book_levels WHERE name=:level";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("level", $level);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data = $data[0];
        return strtoupper($data['id']);
    }

    private function addBook() {
        $ecd_code = $this->getBookLevelRefTypeId("ECD");
        $primary_code = $this->getBookLevelRefTypeId("PRIMARY LEVEL");
        $secondary_code = $this->getBookLevelRefTypeId("SECONDARY LEVEL");
        $adult_code = $this->getBookLevelRefTypeId("ADULT READER");

        if ($_POST['book_level'] == $primary_code) {
            $class = $_POST['primary_class'];
        } else if ($_POST['book_level'] == $secondary_code) {
            $class = $_POST['secondary_class'];
        } else {
            $class = "NONE";
        }

        if ($_SESSION['logged_in_user_type_details']['name'] == "BOOKHIVE") {
            $publisher_type = strtoupper($_POST['publisher_type']);
            $author = strtoupper($_POST['author']);
            if ($_POST['publisher_type'] == "company") {
                $publisher = $_POST['publisher'];
            } else if ($_POST['publisher_type'] == "self") {
                $publisher = $_POST['self_publisher'];
            }
        } else if ($_SESSION['logged_in_user_type_details']['name'] == "PUBLISHER") {
            $publisher_type = "COMPANY";
            $publisher = $_SESSION['userid'];
            $author = strtoupper($_POST['author']);
        } else if ($_SESSION['logged_in_user_type_details']['name'] == "SELF PUBLISHER") {
            $publisher_type = "SELF";
            $publisher = $_SESSION['userid'];
            $author = $_SESSION['user_details']['firstname'] . " " . $_SESSION['user_details']['lastname'];
        } else if ($_SESSION['logged_in_user_type_details']['name'] == "STAFF") {
            if ($_SESSION['user_details']['level_type'] == $this->getUserTypeRefId("BOOKHIVE")) {
                $publisher_type = strtoupper($_POST['publisher_type']);
                $author = strtoupper($_POST['author']);
                if ($_POST['publisher_type'] == "company") {
                    $publisher = $_POST['publisher'];
                } else if ($_POST['publisher_type'] == "self") {
                    $publisher = $_POST['self_publisher'];
                }
            } else if ($_SESSION['user_details']['level_type'] == $this->getUserTypeRefId("PUBLISHER")) {
                $publisher_type = "COMPANY";
                $publisher = $_SESSION['user_details']['level_ref_id'];
                $author = strtoupper($_POST['author']);
            } else if ($_SESSION['user_details']['level_type'] == $this->getUserTypeRefId("BOOK SELLER")) {
                
            }
        }

        $sql = "INSERT INTO books (title, description, author, publisher_type, publisher, publication_year, isbn_number, type_id, level_id, class, print_type, price, cover_photo, createdby, lastmodifiedby)"
                . " VALUES (:title, :description, :author, :publisher_type, :publisher, :publication_year, :isbn_number, :type_id, :level_id, :class, :print_type, :price, :cover_photo, :createdby, :lastmodifiedby)";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("title", strtoupper($_POST['title']));
        $stmt->bindValue("description", strtoupper($_POST['description']));
        $stmt->bindValue("author", $author);
        $stmt->bindValue("publisher_type", $publisher_type);
        $stmt->bindValue("publisher", $publisher);
        $stmt->bindValue("publication_year", $_POST['publication_year']);
        $stmt->bindValue("isbn_number", strtoupper($_POST['isbn_number']));
        $stmt->bindValue("type_id", $_POST['book_type']);
        $stmt->bindValue("level_id", $_POST['book_level']);
        $stmt->bindValue("class", strtoupper($class));
        $stmt->bindValue("print_type", strtoupper($_POST['print_type']));
        $stmt->bindValue("price", $_POST['price']);
        $stmt->bindValue("cover_photo", $_SESSION['filename']);
        $stmt->bindValue("createdby", $_POST['createdby']);
        $stmt->bindValue("lastmodifiedby", $_POST['createdby']); //  echo $_SESSION['userid']);
        $stmt->execute();
        return true;
    }

    public function getAllBooks() {
        $sql = "SELECT * FROM books ORDER BY id ASC";
        $stmt = $this->prepareQuery($sql);
        $stmt->execute();
        $info = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($info) == 0) {
            $_SESSION['no_records'] = true;
        } else {
            $_SESSION['yes_records'] = true;
            $values2 = array();
            foreach ($info as $data) {
                $values = array("id" => $data['id'], "title" => $data['title'], "description" => $data['description'], "author" => $data['author'], "publisher_type" => $data['publisher_type'], "publisher" => $data['publisher'], "publication_year" => $data['publication_year'], "isbn_number" => $data['isbn_number'], "type_id" => $data['type_id'], "level_id" => $data['level_id'], "price" => $data['price'], "cover_photo" => $data['cover_photo'], "status" => $data['status'], "createdat" => $data['createdat'], "createdby" => $data['createdby'], "lastmodifiedat" => $data['lastmodifiedat'], "lastmodifiedby" => $data['lastmodifiedby']);
                array_push($values2, $values);
            }
            return json_encode($values2);
        }
    }

    public function getAllPublisherBooks($publisher_code) {
        $sql = "SELECT * FROM books WHERE publisher=:publisher ORDER BY id ASC";
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
                $values = array("id" => $data['id'], "title" => $data['title'], "description" => $data['description'], "author" => $data['author'], "publisher_type" => $data['publisher_type'], "publisher" => $data['publisher'], "publication_year" => $data['publication_year'], "isbn_number" => $data['isbn_number'], "type_id" => $data['type_id'], "level_id" => $data['level_id'], "price" => $data['price'], "cover_photo" => $data['cover_photo'], "status" => $data['status'], "createdat" => $data['createdat'], "createdby" => $data['createdby'], "lastmodifiedat" => $data['lastmodifiedat'], "lastmodifiedby" => $data['lastmodifiedby']);
                array_push($values2, $values);
            }
            return json_encode($values2);
        }
    }

    public function getStaffDetails($code) {
        $users = new Users();
        return $users->fetchStaffDetails($code);
    }

    public function getCollectionPointDetails($code) {
        $system_administration = new System_Administration();
        return $system_administration->fetchCollectionPointDetails($code);
    }

    public function fetchBookDetails($code) {
        $sql = "SELECT * FROM books WHERE id=:code";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindParam("code", $code);
        $stmt->execute();
        $info = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $info[0];
    }

}
