<?php

require WPATH . "core/include.php";
$currentPage = "";

if (is_menu_set('logout') != "") 
    App::logOut();
else if (is_menu_set('home') != "") {
    $currentPage = WPATH . "modules/home.php";
    set_title("Bookhive | Login");
}
else if (is_menu_set('dashboard') != "") {
    $currentPage = WPATH . "modules/home.php";
    set_title("Bookhive | Dashboard");
}
else if (is_menu_set('forgot_password') != "") {
    $currentPage = WPATH . "modules/forgot_password.php";
    set_title("StaqPesa | Update Password");
} 
else if ( is_menu_set('add_book') != ""){
    $currentPage = WPATH . "modules/add/add_book.php";
    set_title("Bookhive | Add Book");
}
else if ( is_menu_set('add_book_level') != ""){
    $currentPage = WPATH . "modules/add/add_book_level.php";
    set_title("Bookhive | Add Book Level");
}
else if ( is_menu_set('add_book_seller') != ""){
    $currentPage = WPATH . "modules/add/add_book_seller.php";
    set_title("Bookhive | Add Book Seller");
}
else if ( is_menu_set('add_book_type') != ""){
    $currentPage = WPATH . "modules/add/add_book_type.php";
    set_title("Bookhive | Add Book Type");
}
else if ( is_menu_set('add_contact') != ""){
    $currentPage = WPATH . "modules/add/add_contact.php";
    set_title("Bookhive | Add Contact");
}
else if ( is_menu_set('add_county') != ""){
    $currentPage = WPATH . "modules/add/add_county.php";
    set_title("Bookhive | Add County");
}
//else if ( is_menu_set('add_guest_user') != ""){
//    $currentPage = WPATH . "modules/add/add_guest_user.php";
//    set_title("Bookhive | Add Guest User");
//}
else if ( is_menu_set('add_individual_user') != ""){
    $currentPage = WPATH . "modules/add/add_individual_user.php";
    set_title("Bookhive | Add Individual User");
}
else if ( is_menu_set('add_location') != ""){
    $currentPage = WPATH . "modules/add/add_location.php";
    set_title("Bookhive | Add Location");
}
else if ( is_menu_set('add_payment_option') != ""){
    $currentPage = WPATH . "modules/add/add_payment_option.php";
    set_title("Bookhive | Add Payment Option");
}
else if ( is_menu_set('add_piracy_report') != ""){
    $currentPage = WPATH . "modules/add/add_piracy_report.php";
    set_title("Bookhive | Add Piracy Report");
}
else if ( is_menu_set('add_publisher') != ""){
    $currentPage = WPATH . "modules/add/add_publisher.php";
    set_title("Bookhive | Add Publisher");
}
else if ( is_menu_set('add_self_publisher') != ""){
    $currentPage = WPATH . "modules/add/add_self_publisher.php";
    set_title("Bookhive | Add Self Publisher");
}
else if ( is_menu_set('add_role') != ""){
    $currentPage = WPATH . "modules/add/add_role.php";
    set_title("Bookhive | Add Role");
}
else if ( is_menu_set('add_staff') != ""){
    $currentPage = WPATH . "modules/add/add_staff.php";
    set_title("Bookhive | Add Staff");
}
else if ( is_menu_set('add_status') != ""){
    $currentPage = WPATH . "modules/add/add_status.php";
    set_title("Bookhive | Add Status");
}
else if ( is_menu_set('add_sub_county') != ""){
    $currentPage = WPATH . "modules/add/add_sub_county.php";
    set_title("Bookhive | Add Sub-County");
}
else if ( is_menu_set('add_system_administrator') != ""){
    $currentPage = WPATH . "modules/add/add_system_administrator.php";
    set_title("Bookhive | Add System Administrator");
}
else if ( is_menu_set('add_system_component') != ""){
    $currentPage = WPATH . "modules/add/add_system_component.php";
    set_title("Bookhive | Add System Component");
}
else if ( is_menu_set('add_system_privilege') != ""){
    $currentPage = WPATH . "modules/add/add_system_privilege.php";
    set_title("Bookhive | Add System Privilege");
}
//else if ( is_menu_set('add_transaction') != ""){
//    $currentPage = WPATH . "modules/add/add_transaction.php";
//    set_title("Bookhive | Add Transaction");
//}
else if ( is_menu_set('add_user_type') != ""){
    $currentPage = WPATH . "modules/add/add_user_type.php";
    set_title("Bookhive | Add User Type");
}

else if ( is_menu_set('update_book') != ""){
    $currentPage = WPATH . "modules/update/update_book.php";
    set_title("Bookhive | Update Book");
}

else if ( is_menu_set('update_element') != ""){
    $currentPage = WPATH . "modules/update/update_element.php";
    set_title("Bookhive | Update Book");
}
else if ( is_menu_set('update_book_level') != ""){
    $currentPage = WPATH . "modules/update/update_book_level.php";
    set_title("Bookhive | Update Book Level");
}
else if ( is_menu_set('update_book_seller') != ""){
    $currentPage = WPATH . "modules/update/update_book_seller.php";
    set_title("Bookhive | Update Book Seller");
}
else if ( is_menu_set('update_book_type') != ""){
    $currentPage = WPATH . "modules/update/update_book_type.php";
    set_title("Bookhive | Update Book Type");
}
else if ( is_menu_set('update_contact') != ""){
    $currentPage = WPATH . "modules/update/update_contact.php";
    set_title("Bookhive | Update Contact");
}
else if ( is_menu_set('update_county') != ""){
    $currentPage = WPATH . "modules/update/update_county.php";
    set_title("Bookhive | Update County");
}
//else if ( is_menu_set('update_guest_user') != ""){
//    $currentPage = WPATH . "modules/update/update_guest_user.php";
//    set_title("Bookhive | Update Guest User");
//}
else if ( is_menu_set('update_individual_user') != ""){
    $currentPage = WPATH . "modules/update/update_individual_user.php";
    set_title("Bookhive | Update Individual User");
}
else if ( is_menu_set('update_location') != ""){
    $currentPage = WPATH . "modules/update/update_location.php";
    set_title("Bookhive | Update Location");
}
else if ( is_menu_set('update_payment_option') != ""){
    $currentPage = WPATH . "modules/update/update_payment_option.php";
    set_title("Bookhive | Update Payment Option");
}
else if ( is_menu_set('update_piracy_report') != ""){
    $currentPage = WPATH . "modules/update/update_piracy_report.php";
    set_title("Bookhive | Update Piracy Report");
}
else if ( is_menu_set('update_publisher') != ""){
    $currentPage = WPATH . "modules/update/update_publisher.php";
    set_title("Bookhive | Update Publisher");
}
else if ( is_menu_set('update_role') != ""){
    $currentPage = WPATH . "modules/update/update_role.php";
    set_title("Bookhive | Update Role");
}
else if ( is_menu_set('update_staff') != ""){
    $currentPage = WPATH . "modules/update/update_staff.php";
    set_title("Bookhive | Update Staff");
}
else if ( is_menu_set('update_status') != ""){
    $currentPage = WPATH . "modules/update/update_status.php";
    set_title("Bookhive | Update Status");
}
else if ( is_menu_set('update_sub_county') != ""){
    $currentPage = WPATH . "modules/update/update_sub_county.php";
    set_title("Bookhive | Update Sub-County");
}
else if ( is_menu_set('update_system_administrator') != ""){
    $currentPage = WPATH . "modules/update/update_system_administrator.php";
    set_title("Bookhive | Update System Administrator");
}
else if ( is_menu_set('update_system_component') != ""){
    $currentPage = WPATH . "modules/update/update_system_component.php";
    set_title("Bookhive | Update System Component");
}
else if ( is_menu_set('update_system_privilege') != ""){
    $currentPage = WPATH . "modules/update/update_system_privilege.php";
    set_title("Bookhive | Update System Privilege");
}
else if ( is_menu_set('update_transaction') != ""){
    $currentPage = WPATH . "modules/update/update_transaction.php";
    set_title("Bookhive | Update Transaction");
}
else if ( is_menu_set('update_user_type') != ""){
    $currentPage = WPATH . "modules/update/update_user_type.php";
    set_title("Bookhive | Update User Type");
}

else if ( is_menu_set('view_books') != ""){
    $currentPage = WPATH . "modules/read/view_books.php";
    set_title("Bookhive | Books");
}
else if ( is_menu_set('view_book_levels') != ""){
    $currentPage = WPATH . "modules/read/view_book_levels.php";
    set_title("Bookhive | Book Levels");
}
else if ( is_menu_set('view_book_sellers') != ""){
    $currentPage = WPATH . "modules/read/view_book_sellers.php";
    set_title("Bookhive | Book Sellers");
}
else if ( is_menu_set('view_book_types') != ""){
    $currentPage = WPATH . "modules/read/view_book_types.php";
    set_title("Bookhive | Book Types");
}
else if ( is_menu_set('view_contacts') != ""){
    $currentPage = WPATH . "modules/read/view_contacts.php";
    set_title("Bookhive | Contacts");
}
else if ( is_menu_set('view_counties') != ""){
    $currentPage = WPATH . "modules/read/view_counties.php";
    set_title("Bookhive | Counties");
}
//else if ( is_menu_set('view_guest_users') != ""){
//    $currentPage = WPATH . "modules/read/view_guest_users.php";
//    set_title("Bookhive | Guest Users");
//}
else if ( is_menu_set('view_individual_users') != ""){
    $currentPage = WPATH . "modules/read/view_individual_users.php";
    set_title("Bookhive | Individual Users");
}
else if ( is_menu_set('view_locations') != ""){
    $currentPage = WPATH . "modules/read/view_locations.php";
    set_title("Bookhive | Locations");
}
else if ( is_menu_set('view_payment_options') != ""){
    $currentPage = WPATH . "modules/read/view_payment_options.php";
    set_title("Bookhive | Payment Options");
}
else if ( is_menu_set('view_piracy_reports') != ""){
    $currentPage = WPATH . "modules/read/view_piracy_reports.php";
    set_title("Bookhive | Piracy Reports");
}
else if ( is_menu_set('view_inbox_messages') != ""){
    $currentPage = WPATH . "modules/read/view_inbox_messages.php";
    set_title("Bookhive | Inbox Messages");
}
else if ( is_menu_set('view_publishers') != ""){
    $currentPage = WPATH . "modules/read/view_publishers.php";
    set_title("Bookhive | Publishers");
}
else if ( is_menu_set('view_self_publishers') != ""){
    $currentPage = WPATH . "modules/read/view_self_publishers.php";
    set_title("Bookhive | Self Publishers");
}
else if ( is_menu_set('view_schools') != ""){
    $currentPage = WPATH . "modules/read/view_schools.php";
    set_title("Bookhive | Schools");
}
else if ( is_menu_set('view_corporates') != ""){
    $currentPage = WPATH . "modules/read/view_corporates.php";
    set_title("Bookhive | Corporates");
}
else if ( is_menu_set('view_roles') != ""){
    $currentPage = WPATH . "modules/read/view_roles.php";
    set_title("Bookhive | Roles");
}
else if ( is_menu_set('view_staff') != ""){
    $currentPage = WPATH . "modules/read/view_staff.php";
    set_title("Bookhive | Staff Members");
}
else if ( is_menu_set('view_statuses') != ""){
    $currentPage = WPATH . "modules/read/view_statuses.php";
    set_title("Bookhive | Statuses");
}
else if ( is_menu_set('view_sub_counties') != ""){
    $currentPage = WPATH . "modules/read/view_sub_counties.php";
    set_title("Bookhive | Sub-Counties");
}
else if ( is_menu_set('view_system_administrators') != ""){
    $currentPage = WPATH . "modules/read/view_system_administrators.php";
    set_title("Bookhive | System Administrators");
}
else if ( is_menu_set('view_system_components') != ""){
    $currentPage = WPATH . "modules/read/view_system_components.php";
    set_title("Bookhive | System Components");
}
else if ( is_menu_set('view_system_privileges') != ""){
    $currentPage = WPATH . "modules/read/view_system_privileges.php";
    set_title("Bookhive | System Privileges");
}
else if ( is_menu_set('view_transactions') != ""){
    $currentPage = WPATH . "modules/read/view_transactions.php";
    set_title("Bookhive | Transactions");
}
else if ( is_menu_set('view_transaction_details') != ""){
    $currentPage = WPATH . "modules/read/view_transaction_details.php";
    set_title("Bookhive | Transaction Details");
}
else if ( is_menu_set('view_individual_transaction') != ""){
    $currentPage = WPATH . "modules/read/view_transaction_details.php";
    set_title("Bookhive | Transaction Details");
}
else if ( is_menu_set('view_user_types') != ""){
    $currentPage = WPATH . "modules/read/view_user_types.php";
    set_title("Bookhive | User Types");
}

else if ( is_menu_set('view_books_individual') != ""){
    $currentPage = WPATH . "modules/read/view_books_individual.php";
    set_title("Bookhive | Book Details");
}
else if ( is_menu_set('view_book_levels_individual') != ""){
    $currentPage = WPATH . "modules/read/view_book_levels_individual.php";
    set_title("Bookhive | Book Level Details");
}
else if ( is_menu_set('view_book_sellers_individual') != ""){
    $currentPage = WPATH . "modules/read/view_book_sellers_individual.php";
    set_title("Bookhive | Book Seller Details");
}
else if ( is_menu_set('view_book_types_individual') != ""){
    $currentPage = WPATH . "modules/read/view_book_types_individual.php";
    set_title("Bookhive | Book Type Details");
}
else if ( is_menu_set('view_contacts_individual') != ""){
    $currentPage = WPATH . "modules/read/view_contacts_individual.php";
    set_title("Bookhive | Contact Details");
}
else if ( is_menu_set('view_counties_individual') != ""){
    $currentPage = WPATH . "modules/read/view_counties_individual.php";
    set_title("Bookhive | County Details");
}
//else if ( is_menu_set('view_guest_users_individual') != ""){
//    $currentPage = WPATH . "modules/read/view_guest_users_individual.php";
//    set_title("Bookhive | Guest User Details");
//}
else if ( is_menu_set('view_individual_users_individual') != ""){
    $currentPage = WPATH . "modules/read/view_individual_users_individual.php";
    set_title("Bookhive | Individual User Details");
}
else if ( is_menu_set('view_locations_individual') != ""){
    $currentPage = WPATH . "modules/read/view_locations_individual.php";
    set_title("Bookhive | Location Details");
}
else if ( is_menu_set('view_payment_options_individual') != ""){
    $currentPage = WPATH . "modules/read/view_payment_options_individual.php";
    set_title("Bookhive | Payment Option Details");
}
else if ( is_menu_set('view_piracy_reports_individual') != ""){
    $currentPage = WPATH . "modules/read/view_piracy_reports_individual.php";
    set_title("Bookhive | Piracy Report Details");
}
else if ( is_menu_set('view_publishers_individual') != ""){
    $currentPage = WPATH . "modules/read/view_publishers_individual.php";
    set_title("Bookhive | Publisher Details");
}
else if ( is_menu_set('view_roles_individual') != ""){
    $currentPage = WPATH . "modules/read/view_roles_individual.php";
    set_title("Bookhive | Role Details");
}
else if ( is_menu_set('view_staff_individual') != ""){
    $currentPage = WPATH . "modules/read/view_staff_individual.php";
    set_title("Bookhive | Staff Member Details");
}
else if ( is_menu_set('view_statuses_individual') != ""){
    $currentPage = WPATH . "modules/read/view_statuses_individual.php";
    set_title("Bookhive | Status Details");
}
else if ( is_menu_set('view_sub_counties_individual') != ""){
    $currentPage = WPATH . "modules/read/view_sub_counties_individual.php";
    set_title("Bookhive | Sub-County Details");
}
else if ( is_menu_set('view_system_administrators_individual') != ""){
    $currentPage = WPATH . "modules/read/view_system_administrators_individual.php";
    set_title("Bookhive | System Administrator Details");
}
else if ( is_menu_set('view_system_components_individual') != ""){
    $currentPage = WPATH . "modules/read/view_system_components_individual.php";
    set_title("Bookhive | System Component Details");
}
else if ( is_menu_set('view_system_privileges_individual') != ""){
    $currentPage = WPATH . "modules/read/view_system_privileges_individual.php";
    set_title("Bookhive | System Privilege Details");
}
else if ( is_menu_set('view_transaction_individual') != ""){
    $currentPage = WPATH . "modules/read/view_transactions_individual.php";
    set_title("Bookhive | Transaction Details");
}
else if ( is_menu_set('view_transaction_details_individual') != ""){
    $currentPage = WPATH . "modules/read/view_transaction_details_individual.php";
    set_title("Bookhive | Transaction Details");
}
else if ( is_menu_set('view_user_types_individual') != ""){
    $currentPage = WPATH . "modules/read/view_user_types_individual.php";
    set_title("Bookhive | User Type Details");
}
else if ( is_menu_set('view_transactions_notifications') != ""){
    $currentPage = WPATH . "modules/read/view_transactions.php";
    set_title("Bookhive | Transactions");
}

else if (!empty($_GET)) {
    App::redirectTo("?");
}

else{
    $currentPage = WPATH . "modules/login.php";
    if ( App::isLoggedIn() ) {
		set_title("Bookhive | Home");                
	}        
}

if (App::isAjaxRequest())
    include $currentPage;
else {
    require WPATH . "core/template/layout.php";
}
?>