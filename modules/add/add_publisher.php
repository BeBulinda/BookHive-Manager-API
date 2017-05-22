<?php
//if (!App::isLoggedIn()) {
//    App::redirectTo("?");
//}
require_once WPATH . "modules/classes/Users.php";
$users = new Users();
if (!empty($_POST)) {
    $createdby = 01; //$_POST['createdby'];
    $filename = md5($createdby . time());
    $logo_name = $_FILES['logo']['name'];
    $tmp_name = $_FILES['logo']['tmp_name'];
    $extension = substr($logo_name, strpos($logo_name, '.') + 1);
    $logo = strtoupper($filename . '.' . $extension);
    $_SESSION['filename'] = $logo;
    $location = 'modules/images/logos/publishers/';

    if (move_uploaded_file($tmp_name, $location . $logo)) {
        $_SESSION['publisher_company_name'] = $_POST['company_name'];
        $_SESSION['publisher_description'] = $_POST['description'];
//        $_SESSION['publisher_logo'] = $_POST['logo'];
        $_SESSION['user_type'] = 'PUBLISHER';
        if (isset($_SESSION['publisher_company_name'])) {
            App::redirectTo("?add_contact&ref_type=" . $_SESSION['user_type']);
        }
    } else {
        $_SESSION['create_error'] = "Error uploading photo. Kindly add the book again.";
    }
}
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="?home" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="?view_publishers">Publishers</a> <a href="?add_publisher" class="current">Add Publisher</a> </div>
        <h1>Add Publisher</h1>
    </div>
    <div class="container-fluid"><hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">          
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" name="basic_validate" id="basic_validate" novalidate="novalidate"  enctype="multipart/form-data">
                            <div class="control-group">
                                <label class="control-label">Company Name</label>
                                <div class="controls">
                                    <input type="text" name="company_name" id="company_name">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Description</label>
                                <div class="controls">
                                    <textarea class="span11" name="description" id="description"></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Company Logo</label>
                                <div class="controls">
                                    <input type="file" name="logo"/>
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