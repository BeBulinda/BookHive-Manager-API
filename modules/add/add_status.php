<?php
//if (!App::isLoggedIn()) {
//    App::redirectTo("?");
//}
require_once WPATH . "modules/classes/System_Administration.php";
$system_administration = new System_Administration();
if (!empty($_POST)) {
    $success = $system_administration->execute();
    if (is_bool($success) && $success == true) {
        $_SESSION['add_success'] = true;
    }
    App::redirectTo("?view_statuses");
}
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="?home" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="?view_statuses">Status Codes</a> <a href="?add_status" class="current">Add Status Code</a> </div>
        <h1>Add Status Code</h1>
    </div>
    <div class="container-fluid"><hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">          
                    <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" name="basic_validate" id="basic_validate" novalidate="novalidate">
                            <input type="hidden" name="action" value="add_status_code"/>
                            <input type="hidden" name="createdby" value="<?php echo 01; //  echo $_SESSION['userid'];    ?>"/>
              
                            <div class="control-group">
                                <label class="control-label">Status Code</label>
                                <div class="controls">
                                    <input type="text" name="status_code" id="status_code">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Status Description</label>
                                <div class="controls">
                                    <input type="text" name="description" id="description">
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