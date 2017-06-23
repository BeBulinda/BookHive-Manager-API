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

    private function addBook() {

        $ecd_code = $this->getBookLevelRefTypeId("ECD");
        $primary_code = $this->getBookLevelRefTypeId("PRIMARY LEVEL");
        $secondary_code = $this->getBookLevelRefTypeId("SECONDARY LEVEL");
        $adult_code = $this->getBookLevelRefTypeId("ADULT READER");

        if ($_POST['book_level'] == $primary_code) {
            $class = $_POST['primary_class'];
        } else if ($_POST['book_level'] == $secondary_code) {
            $class = $_POST['secondary_class'];
        }

        if ($_POST['publisher_type'] == "company") {
            $publisher = $_POST['publisher'];
        } else if ($_POST['publisher_type'] == "self") {
            $publisher = $_POST['self_publisher'];
        }

        $sql = "INSERT INTO books (title, description, author, publisher_type, publisher, publication_year, isbn_number, type_id, level_id, class, print_type, price, cover_photo, createdby, lastmodifiedby)"
                . " VALUES (:title, :description, :author, :publisher_type, :publisher, :publication_year, :isbn_number, :type_id, :level_id, :class, :print_type, :price, :cover_photo, :createdby, :lastmodifiedby)";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("title", strtoupper($_POST['title']));
        $stmt->bindValue("description", strtoupper($_POST['description']));
        $stmt->bindValue("author", strtoupper($_POST['author']));
        $stmt->bindValue("publisher_type", strtoupper($_POST['publisher_type']));
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

    public function getStaffDetails($code) {
        $users = new Users();
        return $users->fetchStaffDetails($code);
    }

    public function getCollectionPointDetails($code) {
        $system_administration = new System_Administration();
        return $system_administration->fetchCollectionPointDetails($code);
    }

    private function editDocumentType() {
        $sql = "UPDATE document_types SET category=:category, lastmodifiedat=:lastmodifiedat, lastmodifiedby=:lastmodifiedby WHERE id=:id";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("id", $_SESSION['document_type']);
        $stmt->bindValue("category", strtoupper($_POST['name']));
        $stmt->bindValue("lastmodifiedby", $_POST['createdby']);
        $stmt->bindValue("lastmodifiedat", date("Y-m-d H:i:s"));
        if ($stmt->execute()) {
            return true;
        } else
            return false;
    }

    private function editSavedDocument() {
//        if ($_SESSION['item_type'] === "STUDENT ID") {
//        $institution = strtoupper($_POST['institution_name']);
//        } else {
//        $institution = 0;    
//        }

        $sql = "UPDATE saved_documents SET item_type=:item_type, institution=:institution, item_no=:item_no, item_name=:item_name, owner=:owner, description=:description, lastmodifiedat=:lastmodifiedat, lastmodifiedby=:lastmodifiedby WHERE id=:id";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("id", $_SESSION['saved_document']);
        $stmt->bindValue("item_type", $_POST['item_type']);
//        $stmt->bindValue("institution", $institution);
        $stmt->bindValue("institution", strtoupper($_POST['institution_name']));
        $stmt->bindValue("item_no", strtoupper($_POST['item_no']));
        $stmt->bindValue("item_name", strtoupper($_POST['item_name']));
        $stmt->bindValue("owner", strtoupper($_POST['owner']));
        $stmt->bindValue("description", strtoupper($_POST['description']));
        $stmt->bindValue("lastmodifiedby", $_POST['createdby']);
        $stmt->bindValue("lastmodifiedat", date("Y-m-d H:i:s"));
        if ($stmt->execute()) {
            return true;
        } else
            return false;
    }

    private function editReportedDocument() {
        $item_type_details = $this->fetchDocumentTypeDetails($_POST['item_type']);
        if ($item_type_details['category'] === "STUDENT ID") {
            $institution = strtoupper($_POST['institution_name']);
        } else {
            $institution = 0;
        }

        if ($_POST['system_drop_point'] == 0) {
            $other_drop_point = strtoupper($_POST['other_drop_point']);
        } else {
            $other_drop_point = 0;
        }

        $sql = "UPDATE reported_documents SET item_type=:item_type, institution=:institution, item_no=:item_no, item_name=:item_name, reportedby=:reportedby, reporter_phone_no=:reporter_phone_no, "
                . "reporter_email=:reporter_email, system_drop_point=:system_drop_point, other_drop_point=:other_drop_point, lastmodifiedat=:lastmodifiedat, lastmodifiedby=:lastmodifiedby  WHERE id=:id";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("id", $_SESSION['reported_document']);
        $stmt->bindValue("item_type", $_POST['item_type']);
        $stmt->bindValue("institution", $institution);
        $stmt->bindValue("item_no", strtoupper($_POST['item_no']));
        $stmt->bindValue("item_name", strtoupper($_POST['item_name']));
        $stmt->bindValue("reportedby", strtoupper($_POST['reportedby']));
        $stmt->bindValue("system_drop_point", strtoupper($_POST['system_drop_point']));
        $stmt->bindValue("other_drop_point", $other_drop_point);
        $stmt->bindValue("reporter_phone_no", strtoupper($_POST['phone_number']));
        $stmt->bindValue("reporter_email", strtoupper($_POST['email']));
        $stmt->bindValue("lastmodifiedby", $_POST['createdby']);
        $stmt->bindValue("lastmodifiedat", date("Y-m-d H:i:s"));
        if ($stmt->execute()) {
            return true;
        } else
            return false;
    }

    public function updateDocumentType($code, $update_type) {
        if ($update_type == "deactivate") {
            $sql = "UPDATE document_types SET status=1002, lastmodifiedby=:lastmodifiedby, lastmodifiedat=:lastmodifiedat WHERE id=:code";
        } else if ($update_type == "activate") {
            $sql = "UPDATE document_types SET status=1021, lastmodifiedby=:lastmodifiedby, lastmodifiedat=:lastmodifiedat WHERE id=:code";
        } else if ($update_type == "delete") {
            $sql = "UPDATE document_types SET status=1000, lastmodifiedby=:lastmodifiedby, lastmodifiedat=:lastmodifiedat WHERE id=:code";
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

    public function updateSavedDocument($code, $update_type) {
        if ($update_type == "deactivate") {
            $sql = "UPDATE saved_documents SET del_status=1002, lastmodifiedby=:lastmodifiedby, lastmodifiedat=:lastmodifiedat WHERE id=:code";
        } else if ($update_type == "activate") {
            $sql = "UPDATE saved_documents SET del_status=1021, lastmodifiedby=:lastmodifiedby, lastmodifiedat=:lastmodifiedat WHERE id=:code";
        } else if ($update_type == "delete") {
            $sql = "UPDATE saved_documents SET del_status=1000, lastmodifiedby=:lastmodifiedby, lastmodifiedat=:lastmodifiedat WHERE id=:code";
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

    public function updateReportedDocument($field, $code, $update_type) {
        if ($update_type == "deactivate") {
            $sql = "UPDATE reported_documents SET " . $field . "=1002, lastmodifiedby=:lastmodifiedby, lastmodifiedat=:lastmodifiedat WHERE id=:code";
        } else if ($update_type == "activate") {
            $sql = "UPDATE reported_documents SET " . $field . "=1021, lastmodifiedby=:lastmodifiedby, lastmodifiedat=:lastmodifiedat WHERE id=:code";
        } else if ($update_type == "claim") {
            $sql = "UPDATE reported_documents SET " . $field . "=1010, lastmodifiedby=:lastmodifiedby, lastmodifiedat=:lastmodifiedat WHERE id=:code";
        } else if ($update_type == "delete") {
            $sql = "UPDATE reported_documents SET " . $field . "=1000, lastmodifiedby=:lastmodifiedby, lastmodifiedat=:lastmodifiedat WHERE id=:code";
        } else if ($update_type == "approve_custody") {
            $sql = "UPDATE reported_documents SET " . $field . "=1021, lastmodifiedby=:lastmodifiedby, lastmodifiedat=:lastmodifiedat WHERE id=:code";
        } else if ($update_type == "disapprove_custody") {
            $sql = "UPDATE reported_documents SET " . $field . "=1020, lastmodifiedby=:lastmodifiedby, lastmodifiedat=:lastmodifiedat WHERE id=:code";
        } else if ($update_type == "collect_document") {
            $sql = "UPDATE reported_documents SET " . $field . "=1030, lastmodifiedby=:lastmodifiedby, lastmodifiedat=:lastmodifiedat WHERE id=:code";
        }
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("code", $code);
        $stmt->bindValue("lastmodifiedby", 01); //  echo $_SESSION['userid']);
        $stmt->bindValue("lastmodifiedat", date("Y-m-d H:i:s"));
        if ($stmt->execute()) {
            if ($field == "custody_status") {
                $sql2 = "UPDATE reported_documents SET custody_approved_at=:custody_approved_at, custody_approved_by=:custody_approved_by WHERE id=:code";
                $stmt2 = $this->prepareQuery($sql2);
                $stmt2->bindValue("code", $code);
                $stmt2->bindValue("custody_approved_at", date("Y-m-d H:i:s"));
                $stmt2->bindValue("custody_approved_by", 01); //$_SESSION['userid']); 
                $stmt2->execute();
            } else if ($field == "claim_status") {

                //    $claimedby = $this->getStaffDetails($_SESSION['userid']);
                $claimedby = $this->getStaffDetails(1);

                $sql2 = "UPDATE reported_documents SET claimedat=:claimedat, claimedby=:claimedby WHERE id=:code";
                $stmt2 = $this->prepareQuery($sql2);
                $stmt2->bindValue("code", $code);
                $stmt2->bindValue("claimedat", date("Y-m-d H:i:s"));
                $stmt2->bindValue("claimedby", $claimedby['firstname'] . " " . $claimedby['lastname'] . " (STAFF MEMBER)"); //$_SESSION['userid']); 
                $stmt2->execute();

                $phone_number = "+254 710 534013";
                $email_address = "info@kitambulisho.com";
                $document_details = $this->fetchReportedDocumentDetails($code);
                $drop_point_details = $this->getCollectionPointDetails($document_details['system_drop_point']);
                $item_type = $this->fetchDocumentTypeDetails($document_details['item_type']);
                ;

                $headers = "From: Kitambulisho <$email_address>\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                $subject = "Document Claimed";
                $message = "<html><body>"
                        . "<p /><b>Hello,</b>"
                        . "<p />"
                        . "A reported lost and found document that is in your custody has been claimed for collection. "
                        . "The claimer details are as below: <br />"
                        . "<ul>"
                        . "<li><b>Document Type :       </b>" . $item_type['category'] . "</li>"
                        . "<li><b>Document Number :     </b>" . $document_details['item_no'] . "</li>"
                        . "<li><b>Name(s) on Document : </b>" . $document_details['item_name'] . "</li>"
                        . "<li><b>Claim Date/Time :     </b>" . $document_details['claimedat'] . "</li>"
                        . "<li><b>Claimed By :          </b>" . $claimedby['firstname'] . " " . $claimedby['lastname'] . " (Staff Member)</li>"
                        . "</ul> <br />"
                        . "For any enquiries, kindly contact us on:   <br/>"
                        . "<ul>"
                        . "<li><b>Telephone Number(s): </b>" . $phone_number . "</li>"
                        . "<li><b>Email Address: </b>" . $email_address . "</li>"
                        . "</ul>"
                        . "Visit <a href='http://www.kitambulisho.com'>www.kitambulisho.com</a> for more information.<br/>"
                        . "</body></html>";

                mail($drop_point_details['email'], $subject, $message, $headers);
            } else if ($field == "collection_status") {
                $sql2 = "UPDATE reported_documents SET collection_approved_at=:collection_approved_at, collection_approved_by=:collection_approved_by WHERE id=:code";
                $stmt2 = $this->prepareQuery($sql2);
                $stmt2->bindValue("code", $code);
                $stmt2->bindValue("collection_approved_at", date("Y-m-d H:i:s"));
                $stmt2->bindValue("collection_approved_by", 01); //$_SESSION['userid']); 
                $stmt2->execute();
            }
            return true;
        } else
            return false;
    }

    public function fetchDocumentTypeDetails($code) {
        $sql = "SELECT * FROM document_types WHERE id=:code";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindParam("code", $code);
        $stmt->execute();
        $info = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $info[0];
    }

    public function fetchReportedDocumentDetails($code) {
        $sql = "SELECT * FROM reported_documents WHERE id=:code";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindParam("code", $code);
        $stmt->execute();
        $info = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $info[0];
    }

    public function fetchSavedDocumentDetails($code) {
        $sql = "SELECT * FROM saved_documents WHERE id=:code";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindParam("code", $code);
        $stmt->execute();
        $info = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $info[0];
    }

    public function getNextReportedDocumentId() {
        $reported_document_id = $this->executeQuery("SELECT max(id) as reported_document_id_max FROM reported_documents");
        $reported_document_id = $reported_document_id[0]['reported_document_id_max'] + 1;
        return $reported_document_id;
    }

    private function addReportedDocument() {
        $item_type_details = $this->fetchDocumentTypeDetails($_POST['item_type']);
        $reported_document_id = $this->getNextReportedDocumentId();

        if ($item_type_details['category'] === "STUDENT ID") {
            if ($_POST['system_institution'] == 0) {
                $system_institution = 0;
                $other_institution = strtoupper($_POST['other_institution']);
            } else {
                $system_institution = strtoupper($_POST['system_institution']);
                $other_institution = 0;
            }
        } else {
            $system_institution = 0;
            $other_institution = 0;
        }

        if ($_POST['system_drop_point'] == 0) {
            $other_drop_point = strtoupper($_POST['other_drop_point']);
        } else {
            $other_drop_point = 0;
        }

        $sql = "INSERT INTO reported_documents(item_type, system_institution, other_institution, item_no, item_name, reportedby, system_drop_point, other_drop_point, reporter_phone_no, reporter_email, lastmodifiedby, lastmodifiedat) "
                . "VALUES(:item_type, :system_institution, :other_institution, :item_no, :item_name, :reportedby, :system_drop_point, :other_drop_point, :reporter_phone_no, :reporter_email, :lastmodifiedby, :lastmodifiedat)";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("item_type", $_POST['item_type']);
        $stmt->bindValue("system_institution", $system_institution);
        $stmt->bindValue("other_institution", $other_institution);
        $stmt->bindValue("item_no", strtoupper($_POST['item_no']));
        $stmt->bindValue("item_name", strtoupper($_POST['item_name']));
        $stmt->bindValue("reportedby", strtoupper($_POST['reportedby']));
        $stmt->bindValue("system_drop_point", strtoupper($_POST['system_drop_point']));
        $stmt->bindValue("other_drop_point", $other_drop_point);
        $stmt->bindValue("reporter_phone_no", strtoupper($_POST['phone_number']));
        $stmt->bindValue("reporter_email", strtoupper($_POST['email']));
        $stmt->bindValue("lastmodifiedby", 01); //  echo $_SESSION['userid']);
        $stmt->bindValue("lastmodifiedat", date("Y-m-d H:i:s"));
        $stmt->execute();
        if ($_POST['system_drop_point'] != 0) {
            $url = "http://dash.kitambulisho.com/?individual_reported_document&code={$reported_document_id}";
            $phone_number = "+254 710 534013";
            $email_address = "info@kitambulisho.com";
            $drop_point_details = $this->getCollectionPointDetails(strtoupper($_POST['system_drop_point']));

            $headers = "From: Kitambulisho <$email_address>\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $subject = "Document Reported";
            $message = "<html><body>"
                    . "<p /><b>Hello,</b>"
                    . "<p />"
                    . "A lost and found document has been reported on Kitambulisho and indicated to be placed at your center (" . $drop_point_details['name'] . "). "
                    . "The reported document bears the below details: <br/>"
                    . "<ul>"
                    . "<li><b>Document Type: </b>" . $item_type_details['category'] . "</li>"
                    . "<li><b>Document Number: </b>" . strtoupper($_POST['item_no']) . "</li>"
                    . "<li><b>Name on document: </b>" . strtoupper($_POST['item_name']) . "</li>"
                    . "</ul>"
                    . "Click on this link: <a href=' " . $url . "'>Document Custody Verification</a> to approve/reject custody of the document. <br/>"
                    . "For any enquiries, kindly contact us on:   <br/>"
                    . "<ul>"
                    . "<li><b>Telephone Number(s): </b>" . $phone_number . "</li>"
                    . "<li><b>Email Address: </b>" . $email_address . "</li>"
                    . "</ul>"
                    . "Visit <a href='http://www.kitambulisho.com'>www.kitambulisho.com</a> for more information.<br/>"
                    . "</body></html>";

            mail($drop_point_details['email'], $subject, $message, $headers);
        }
        return true;
    }

    private function addSavedDocument() {

//        if ($_SESSION['item_type'] === "STUDENT ID") {
//        $institution = strtoupper($_POST['institution_name']);
//        } else {
//        $institution = 0;    
//        }

        $sql = "INSERT INTO saved_documents(item_type, institution, item_no, item_name, owner, description, lastmodifiedat, lastmodifiedby) "
                . "VALUES(:item_type, :institution, :item_no, :item_name, :owner, :description, :lastmodifiedat, :lastmodifiedby)";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("item_type", $_POST['item_type']);
//        $stmt->bindValue("institution", $institution);
        $stmt->bindValue("institution", strtoupper($_POST['institution_name']));
        $stmt->bindValue("item_no", strtoupper($_POST['item_no']));
        $stmt->bindValue("item_name", strtoupper($_POST['item_name']));
        $stmt->bindValue("owner", strtoupper($_POST['owner']));
        $stmt->bindValue("description", strtoupper($_POST['description']));
        $stmt->bindValue("lastmodifiedby", $_POST['createdby']); //  echo $_SESSION['userid']);
        $stmt->bindValue("lastmodifiedat", date("Y-m-d H:i:s"));
        $stmt->execute();
        return true;
    }

    private function addDocumentType() {
        $sql = "INSERT INTO document_types (category, createdby, lastmodifiedat, lastmodifiedby)"
                . " VALUES (:category, :createdby, :lastmodifiedat, :lastmodifiedby)";
        $stmt = $this->prepareQuery($sql);
        $stmt->bindValue("category", strtoupper($_POST['name']));
        $stmt->bindValue("createdby", $_POST['createdby']);
        $stmt->bindValue("lastmodifiedby", $_POST['createdby']); //  echo $_SESSION['userid']);
        $stmt->bindValue("lastmodifiedat", date("Y-m-d H:i:s"));
        $stmt->execute();
        $info = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($info) == 0) {
            $_SESSION['no_records'] = true;
        } else {
            $_SESSION['yes_records'] = true;
            $values2 = array();
            foreach ($info as $data) {
                $values = array("id" => $data['id'], "category" => $data['category']);
                //What's this doing?
                array_push($values2, $values);
            }
            return json_encode($values2);
        }
        return true;
    }

    public function getDocumentTypes() {
        $sql = "SELECT id, category, status FROM document_types WHERE status=1021 "
                . " ORDER BY category ASC";
        $stmt = $this->prepareQuery($sql);
        $stmt->execute();
        $currentGroup = null;
        $html = "";
        while ($row = $stmt->fetch()) {
            if (is_null($currentGroup)) {
                $currentGroup = $row['category'];
                $html .= "<option value=\"{$row['id']}\" selected>{$row['category']}</option>";
            } else {
                $html .= "<option value=\"{$row['id']}\">{$row['category']}</option>";
            }
        }
        if ($html == "")
            $html = "<option value=\"\">No document type entered into the database!</option>";
        echo $html;
        return $currentGroup;
    }

    public function getAllDocumentTypes() {
        $sql = "SELECT * FROM document_types ORDER BY id ASC";
        $stmt = $this->prepareQuery($sql);
        $stmt->execute();
        $info = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($info) == 0) {
            $_SESSION['no_records'] = true;
        } else {
            $_SESSION['yes_records'] = true;
            $values2 = array();
            foreach ($info as $data) {
                $values = array("id" => $data['id'], "category" => $data['category'], "status" => $data['status'], "createdat" => $data['createdat'], "createdby" => $data['createdby']);
                array_push($values2, $values);
            }
            return json_encode($values2);
        }
    }

    public function getAllSavedDocuments() {
        $sql = "SELECT * FROM saved_documents ORDER BY createdat DESC";
        $stmt = $this->prepareQuery($sql);
        $stmt->execute();
        $info = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($info) == 0) {
            $_SESSION['no_records'] = true;
        } else {
            $_SESSION['yes_records'] = true;
            $values2 = array();
            foreach ($info as $data) {
                $values = array("id" => $data['id'], "item_type" => $data['item_type'], "institution" => $data['institution'], "item_no" => $data['item_no'], "item_name" => $data['item_name'], "owner" => $data['owner'], "description" => $data['description'], "createdat" => $data['createdat'], "del_status" => $data['del_status']);
                array_push($values2, $values);
            }
            return json_encode($values2);
        }
    }

    public function getAllReportedDocuments() {
        $sql = "SELECT * FROM reported_documents ORDER BY reportedat DESC";
        $stmt = $this->prepareQuery($sql);
        $stmt->execute();
        $info = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($info) == 0) {
            $_SESSION['no_records'] = true;
        } else {
            $_SESSION['yes_records'] = true;
            $values2 = array();
            foreach ($info as $data) {
                if ($data['system_institution'] == 0) {
                    $institution = $data['other_institution'];
                } else {
                    $system_administration = new System_Administration();
                    $institution_details = $system_administration->fetchInstitutionDetails($data['system_institution']);
                    $institution = $institution_details['name'];
                }
                $values = array("id" => $data['id'], "item_type" => $data['item_type'], "institution" => $institution, "item_no" => $data['item_no'], "item_name" => $data['item_name'], "reportedby" => $data['reportedby'], "system_drop_point" => $data['system_drop_point'], "other_drop_point" => $data['other_drop_point'],
                    "claim_status" => $data['claim_status'], "reporter_phone_no" => $data['reporter_phone_no'], "reporter_email" => $data['reporter_email'], "reportedat" => $data['reportedat'], "custody_status" => $data['custody_status'], "custody_approved_by" => $data['custody_approved_by'],
                    "custody_approved_at" => $data['custody_approved_at'], "claimedat" => $data['claimedat'], "claimedby" => $data['claimedby'], "collection_status" => $data['collection_status'], "collection_approved_by" => $data['collection_approved_by'], "collection_approved_at" => $data['collection_approved_at']);
                array_push($values2, $values);
            }
            return json_encode($values2);
        }
    }

}
