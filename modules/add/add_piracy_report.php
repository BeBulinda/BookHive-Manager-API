<?php
//if (!App::isLoggedIn()) {
//    App::redirectTo("?");
//}
require_once WPATH . "modules/classes/Transactions.php";
require_once WPATH . "modules/classes/System_Administration.php";
$system_administration = new System_Administration();
$transactions = new Transactions();
if (!empty($_POST)) {

    $createdby = $_POST['createdby'];
    $_SESSION['createdby'] = $createdby;
    $book = md5("book" . $createdby . time());
    $book_photo_name = $_FILES['book_photo']['name'];
    $tmp_name_book = $_FILES['book_photo']['tmp_name'];
    $extension_book = substr($book_photo_name, strpos($book_photo_name, '.') + 1);
    $book_photo = strtoupper($book . '.' . $extension_book);
    $_SESSION['book_photo'] = $book_photo;
    $location1 = 'modules/images/piracy/books/';

    $receipt = md5("receipt" . $createdby . time());
    $receipt_photo_name = $_FILES['receipt_photo']['name'];
    $tmp_name_receipt = $_FILES['receipt_photo']['tmp_name'];
    $extension_receipt = substr($receipt_photo_name, strpos($receipt_photo_name, '.') + 1);
    $receipt_photo = strtoupper($receipt . '.' . $extension_receipt);
    $_SESSION['receipt_photo'] = $receipt_photo;
    $location2 = 'modules/images/piracy/receipts/';

    if (move_uploaded_file($tmp_name_book, $location1 . $book_photo) AND move_uploaded_file($tmp_name_receipt, $location2 . $receipt_photo)) {
        $success = $transactions->execute();
        if (is_bool($success) && $success == true) {
            $_SESSION['add_success'] = true;
        }
        App::redirectTo("?view_piracy_reports");
    } else {
        $_SESSION['create_error'] = "Error uploading attachments. Kindly create account holder again.";
    }
}
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="?home" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="?view_piracy_reports">Piracy Reports</a> <a href="?add_piracy_report" class="current">Add Piracy Report</a> </div>
        <h1>Add Piracy Report</h1>
    </div>
    <div class="container-fluid"><hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">          
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" name="basic_validate" id="basic_validate" novalidate="novalidate" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="add_piracy_report"/>
                            <input type="hidden" name="createdby" value="<?php echo 01; //  echo $_SESSION['userid'];      ?>"/>

                            <div class="control-group">
                                <label class="control-label">Reporter's User Type</label>
                                <div class="controls">
                                    <select name="reporter_type" id="reporter_type">
                                        <?php echo $system_administration->getUserTypes(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Reporter's Name</label>
                                <div class="controls">
                                    <input type="text" name="reported_by" id="reportedby">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Seller's Name</label>
                                <div class="controls">
                                    <input type="text" name="seller_name" id="seller_name">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Book Photo</label>
                                <div class="controls">
                                    <input type="file" name="book_photo" id="book_photo"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Receipt Photo</label>
                                <div class="controls">
                                    <input type="file" name="receipt_photo" id="receipt_photo"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Description</label>
                                <div class="controls">
                                    <textarea class="span11" name="description" id="description"></textarea>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" value="Save" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>