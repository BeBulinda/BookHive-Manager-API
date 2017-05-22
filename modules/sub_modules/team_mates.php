<?php
if (!App::isLoggedIn())
    App::redirectTo("?");
require_once WPATH . "modules/classes/Funding.php";
require_once WPATH . "modules/classes/Settings.php";
require_once WPATH . "modules/classes/Users.php";
$users = new Users();
$settings = new Settings();
$funding = new Funding();
?>
<div class="col-md-4">
    <div class="panel">
        <header class="panel-heading">
            <i class="fa fa-fighter-jet"></i> Top Investors
        </header>

        <ul class="list-group teammates">
            <?php
            if (!empty($_POST)) {
                $info = $funding->execute();
            } else if (is_menu_set('view_investors_notifications') != "") {
                $info = $funding->getAllTopInvestorNotifications();
            } else {
                $info = $funding->getAllTopInvestors();
            }
            $total_records = count($info);
            if (count($info) == 0) {
                echo "No record found.";
            } else {
                foreach ($info as $data) {
                    if ($data['status'] == 1000) {
                        $status = "DELETED";
                    } else if ($data['status'] == 1001 OR $data['status'] == 1032) {
                        $status = "AWAITING APPROVAL";
                    } else if ($data['status'] == 1010) {
                        $status = "APPROVAL REJECTED";
                    } else if ($data['status'] == 1011) {
                        $status = "APPROVAL ACCEPTED";
                    } else if ($data['status'] == 1020) {
                        $status = "NOT ACTIVE";
                    } else if ($data['status'] == 1021) {
                        $status = "ACTIVE";
                    }

                    $nationality_details = $settings->fetchNationalityDetails($data['nationality']);
                    $staff_details_createdby = $users->fetchStaffDetails($data['createdby']);
                    $investor_type_details = $funding->fetchInvestorTypeDetails($data['investor_type']);
                    ?>

                    <li class = "list-group-item">
                        <a href = '?view_investors_individual&code="<?php echo $data['id']; ?>'><img src = "img/26115.jpg" width = "50" height = "50"></a>
                        <span class = "pull-right label label-default inline m-t-15"><?php echo $investor_type_details['name']; ?></span>
                        <a href='?view_investors_individual&code="<?php echo $data['id']; ?>'><?php echo $data['firstname'] . " " . $data['lastname']; ?></a>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
        <div class="panel-footer bg-white">
                    <!-- <span class="pull-right badge badge-info">32</span> -->
<!--            <button class="btn btn-primary btn-addon btn-sm">
                <i class="fa fa-plus"></i>
                <a style="color: #fff;" href="?add_investor"> Add Investor</a>
            </button>-->
        </div>
    </div>
</div>