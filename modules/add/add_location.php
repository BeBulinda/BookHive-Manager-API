<?php
if (!App::isLoggedIn()) App::redirectTo("?");
require_once WPATH . "modules/classes/System_Administration.php";
$system_administration = new System_Administration();
if (!empty($_POST)) {
    $success = $system_administration->execute();
    if (is_bool($success) && $success == true) {
        $_SESSION['add_success'] = true;
    }
    App::redirectTo("?view_locations");
}
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="?home" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="?view_locations">Locations</a> <a href="?add_location" class="current">Add Location</a> </div>
        <h1>Add Location</h1>
    </div>
    <div class="container-fluid"><hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">          
                    <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" name="basic_validate" id="basic_validate" novalidate="novalidate">
                            <input type="hidden" name="action" value="add_location"/>
                            <input type="hidden" name="createdby" value="<?php echo 01; //  echo $_SESSION['userid'];    ?>"/>
              
                            <div class="control-group">
                                <label class="control-label">Location Name</label>
                                <div class="controls">
                                    <input type="text" name="name" id="name">
                                </div>
                            </div>
                           <div class="control-group">
                                <label class="control-label">County</label>
                                <div class="controls">
                                    <select class="county" id="country-list" name="county" class="demoInputBox" onChange="getState(this.value);">
                                        <?php // echo $system_administration->getCounties();  ?>
                                        <option value="">Select County</option>
                                        <?php
                                        foreach ($results as $county) {
                                            ?>
                                            <option value="<?php echo $county["id"]; ?>"><?php echo $county["name"]; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Sub-County</label>
                                <div class="controls">
                                    <select name="sub_county" id="county-list" class="demoInputBox" onChange="getLocation(this.value);">
                                        <?php //echo $system_administration->getSubCounties(); ?>
                                        <option value="">Select Sub-County</option>
                                    </select>
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