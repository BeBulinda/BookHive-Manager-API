<?php
//if (!App::isLoggedIn()) {
//    App::redirectTo("?");
//}
require_once WPATH . "modules/classes/Users.php";
$users = new Users();
$ref_type = $_GET['ref_type'];  //If Publisher, Book seller etc

if (!empty($_POST)) {
    $_SESSION['createdby'] = $_POST['createdby'];
    $_SESSION['admin_firstname'] = $_POST['firstname'];
    $_SESSION['admin_lastname'] = $_POST['lastname'];
    $_SESSION['admin_idnumber'] = $_POST['idnumber'];
    $_SESSION['admin_phone_number'] = $_POST['phone_number'];
    $_SESSION['admin_email'] = $_POST['email'];    
    
    if ($ref_type == "PUBLISHER") {
        $success = $users->execute();
        if (is_bool($success) && $success == true) {
            $_SESSION['add_success'] = true;
        }
        App::redirectTo("?view_publishers");
    } else if ($ref_type == "BOOK SELLER") {
        $success = $users->execute();
        if (is_bool($success) && $success == true) {
            $_SESSION['add_success'] = true;
        }
        App::redirectTo("?view_book_sellers");
    }
}
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="?home" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="?view_system_administrators">System Administrators</a> <a href="?add_system_administrator" class="current">Add System Administrator</a> </div>
        <h1>Add System Administrator</h1>
    </div>
    <div class="container-fluid"><hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">          
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" name="basic_validate" id="basic_validate" novalidate="novalidate">             
                            <input type="hidden" name="createdby" value="<?php echo 01; //  echo $_SESSION['userid'];        ?>"/>
                            <?php if ($ref_type == "PUBLISHER") { ?>
                                <input type="hidden" name="action" value="add_publisher"/>
                            <?php } else if ($ref_type == "BOOK SELLER") { ?>
                                <input type="hidden" name="action" value="add_book_seller"/>
                            <?php } ?>

                            <div class="control-group">
                                <label class="control-label">First Name</label>
                                <div class="controls">
                                    <input type="text" name="firstname" id="firstname">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Last Name</label>
                                <div class="controls">
                                    <input type="text" name="lastname" id="lastname">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">ID/Passport Number</label>
                                <div class="controls">
                                    <input type="text" name="idnumber" id="idnumber">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Phone Number</label>
                                <div class="controls">
                                    <input type="text" name="phone_number" id="phone_number">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Email</label>
                                <div class="controls">
                                    <input type="text" name="email" id="email">
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