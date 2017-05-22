<?php
//if (!App::isLoggedIn()) {
//    App::redirectTo("?");
//}
require_once WPATH . "modules/classes/Users.php";
require_once WPATH . "modules/classes/System_Administration.php";
$users = new Users();
$system_administration = new System_Administration();
$ref_type = $_GET['ref_type'];  //If Publisher, Book seller etc

if (!empty($_POST)) {
    $_SESSION['phone_number'] = $_POST['phone_number'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['postal_number'] = $_POST['postal_number'];
    $_SESSION['postal_code'] = $_POST['postal_code'];
    $_SESSION['town'] = $_POST['town'];
    $_SESSION['county'] = $_POST['county'];
    $_SESSION['sub_county'] = $_POST['sub_county'];
    $_SESSION['location'] = $_POST['location'];
    $_SESSION['landmark_feature'] = $_POST['landmark_feature'];

    if (($ref_type == "PUBLISHER" OR $ref_type == "BOOK SELLER") AND isset($_SESSION['email'])) {
        $_SESSION['phone_number2'] = $_POST['phone_number2'];
        $_SESSION['phone_number3'] = $_POST['phone_number3'];
        $_SESSION['email2'] = $_POST['email2'];
        $_SESSION['email3'] = $_POST['email3'];
        $_SESSION['website'] = $_POST['website'];
        App::redirectTo("?add_system_administrator&ref_type=" . $_SESSION['user_type']);
    } else if ($ref_type == "GUEST USER") {
        $success = $users->execute();
        if (is_bool($success) && $success == true) {
            $_SESSION['add_success'] = true;
        }
        App::redirectTo("?view_guest_users");
    } else if ($ref_type == "INDIVIDUAL USER") {
        $success = $users->execute();
        if (is_bool($success) && $success == true) {
            $_SESSION['add_success'] = true;
        }
        App::redirectTo("?view_individual_users");
    } else if ($ref_type == "STAFF") {
        $success = $users->execute();
        if (is_bool($success) && $success == true) {
            $_SESSION['add_success'] = true;
        }
        App::redirectTo("?view_staff");
    }
}
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="?home" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="?view_contacts">Contacts</a> <a href="?add_contact" class="current">Add Contact</a> </div>
        <h1>Add Contact Details</h1>
    </div>
    <div class="container-fluid"><hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">          
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" name="basic_validate" id="basic_validate" novalidate="novalidate">
                            <input type="hidden" name="createdby" value="<?php echo 01; //  echo $_SESSION['userid'];           ?>"/>
                            <?php if ($ref_type == "GUEST USER") { ?>
                                <input type="hidden" name="action" value="add_guest_user"/>
                            <?php } else if ($ref_type == "INDIVIDUAL USER") { ?>
                                <input type="hidden" name="action" value="add_individual_user"/>
                            <?php } else if ($ref_type == "STAFF") { ?>
                                <input type="hidden" name="action" value="add_staff_member"/>
                                <?php
                            }
                            ?>
                            <div class="control-group">
                                <label class="control-label">Phone Number</label>
                                <div class="controls">
                                    <input type="text" name="phone_number" id="phone_number">
                                </div>
                            </div>
                            <?php if ($ref_type == "PUBLISHER" OR $ref_type == "BOOK SELLER") { ?>
                                <div class="control-group">
                                    <label class="control-label">Second Phone Number</label>
                                    <div class="controls">
                                        <input type="text" name="phone_number2" id="phone_number2">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Third Phone Number</label>
                                    <div class="controls">
                                        <input type="text" name="phone_number3" id="phone_number3">
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="control-group">
                                <label class="control-label">Email Address</label>
                                <div class="controls">
                                    <input type="email" name="email" id="email">
                                </div>
                            </div>

                            <?php if ($ref_type == "PUBLISHER" OR $ref_type == "BOOK SELLER") { ?>
                                <div class="control-group">
                                    <label class="control-label">Second Email Address</label>
                                    <div class="controls">
                                        <input type="email" name="email2" id="email2">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Third Email Address</label>
                                    <div class="controls">
                                        <input type="email" name="email3" id="email3">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Website</label>
                                    <div class="controls">
                                        <input type="text" name="website" id="website">
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="control-group">
                                <label class="control-label">Postal Number</label>
                                <div class="controls">
                                    <input type="text" name="postal_number" id="postal_number">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Postal Code</label>
                                <div class="controls">
                                    <input type="text" name="postal_code" id="postal_code">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Town</label>
                                <div class="controls">
                                    <input type="text" name="town" id="town">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">County</label>
                                <div class="controls">
                                    <select name="county" id="gender">
                                        <?php echo $system_administration->getCounties(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Sub-County</label>
                                <div class="controls">
                                    <select name="sub_county" id="gender">
                                        <?php echo $system_administration->getSubCounties(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Location</label>
                                <div class="controls">
                                    <select name="location" id="gender">
                                        <?php echo $system_administration->getLocations(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Landmark Feature</label>
                                <div class="controls">
                                    <input type="text" name="landmark_feature" id="name">
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