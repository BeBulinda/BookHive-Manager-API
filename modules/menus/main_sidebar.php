<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
    <ul>

        <?php
        if ($_SESSION['logged_in_user_type_details']['name'] == "STAFF") {

//            if ($_SESSION['user_details']['level_type'] == "STAFF") {
//                $_SESSION['user_details']['level_type'];
//                $_SESSION['user_details']['level_ref_id'];
//            }
            
            ?>

            <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Books</span></a>
                <ul>
                    <li><a href="?add_book">Add Book</a></li>
                    <li><a href="?view_books">View Books</a></li>
                </ul>
            </li>
            <li class="submenu"> <a href="#"><i class="icon icon-file"></i> <span>User Types</span></a>
                <ul>
                    <li><a href="?view_publishers">Publishers</a></li>
                    <li><a href="?view_self_publishers">Self Publishers</a></li>
                    <li><a href="?view_book_sellers">Book Sellers</a></li>
                    <li><a href="?view_schools">Schools</a></li>
                    <li><a href="?view_corporates">Corporates</a></li>
                    <li><a href="?view_individual_users">Individual Users</a></li>
                    <li><a href="?view_staff">Staff Members</a></li>
                    <li><a href="?view_system_administrators">System Administrators</a></li>
                </ul>
            </li>
            <li class="submenu"> <a href="#"><i class="icon icon-file"></i> <span>Contacts</span></a>
                <ul>
                    <li><a href="?view_counties">Counties</a></li>
                    <li><a href="?view_sub_counties">Sub-Counties</a></li>
                    <li><a href="?view_locations">Locations</a></li>
                    <li><a href="?view_contacts">Contacts</a></li>
                </ul>
            </li>
            <li class="submenu"> <a href="#"><i class="icon icon-file"></i> <span>Transactions</span></a>
                <ul>
                    <li><a href="?view_piracy_reports">Piracy Reports</a></li>
                    <li><a href="?view_transactions">Transactions</a></li>
                    <li><a href="?view_inbox_messages">Inbox Messages</a></li>
                </ul>
            </li>
            <li class="submenu"> <a href="#"><i class="icon icon-file"></i> <span>Settings</span></a>
                <ul>
                    <li><a href="?view_statuses">Status Codes</a></li>
                    <li><a href="?view_roles">User Roles</a></li>
                    <li><a href="?view_system_components">System Components</a></li>
                    <li><a href="?view_system_privileges">System Privileges</a></li>
                    <li><a href="?view_user_types">User Types</a></li>
                    <li><a href="?view_book_levels">Book Levels</a></li>
                    <li><a href="?view_book_types">Book Types</a></li>
                    <li><a href="?view_payment_options">Payment Options</a></li> 
                </ul>
            </li>
        <?php } else if ($_SESSION['logged_in_user_type_details']['name'] == "PUBLISHER") { ?>
            <li> <a href="?view_books"><i class="icon icon-file"></i> <span>View Books</span></a> </li>
            <li> <a href="?add_book"><i class="icon icon-file"></i> <span>Add Book</span></a> </li>
            <li> <a href="?view_transactions"><i class="icon icon-file"></i> <span>Transactions</span></a> </li>
            <li> <a href="?view_piracy_reports"><i class="icon icon-file"></i> <span>Piracy Reports</span></a> </li>
            <li> <a href="?view_staff"><i class="icon icon-file"></i> <span>Staff Members</span></a> </li>
            <li> <a href="?view_system_administrators"><i class="icon icon-file"></i> <span>System Administrators</span></a> </li>
            <li> <a href="?view_inbox_messages"><i class="icon icon-file"></i> <span>Inbox Messages</span></a> </li>
            <li> <a href="?view_contacts"><i class="icon icon-file"></i> <span>Contacts</span></a> </li>
        <?php } else if ($_SESSION['logged_in_user_type_details']['name'] == "SELF PUBLISHER") { ?>
            <li> <a href="?view_books"><i class="icon icon-file"></i> <span>View Books</span></a> </li>
            <li> <a href="?add_book"><i class="icon icon-file"></i> <span>Add Book</span></a> </li>
            <li> <a href="?view_transactions"><i class="icon icon-file"></i> <span>Transactions</span></a> </li>
            <li> <a href="?view_piracy_reports"><i class="icon icon-file"></i> <span>Piracy Reports</span></a> </li>
            <li> <a href="?view_inbox_messages"><i class="icon icon-file"></i> <span>Inbox Messages</span></a> </li>        
            <li> <a href="?view_contacts"><i class="icon icon-file"></i> <span>Contacts</span></a> </li>
        <?php } else if ($_SESSION['logged_in_user_type_details']['name'] == "BOOK SELLER") { ?>
            <li> <a href="?view_books"><i class="icon icon-th-list"></i> <span>Books</span></a> </li>
            <li> <a href="?view_transactions"><i class="icon icon-file"></i> <span>Transactions</span></a> </li>
            <li> <a href="?view_staff"><i class="icon icon-file"></i> <span>Staff Members</span></a> </li>
            <li> <a href="?view_system_administrators"><i class="icon icon-file"></i> <span>System Administrators</span></a> </li>
            <li> <a href="?view_contacts"><i class="icon icon-file"></i> <span>Contacts</span></a> </li>
            <?php } ?>
    </ul>
</div>
<!--sidebar-menu-->
