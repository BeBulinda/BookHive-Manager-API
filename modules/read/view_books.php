<?php
//if (!App::isLoggedIn()) {
//    App::redirectTo("?");
//}
require_once WPATH . "modules/classes/Books.php";
require_once WPATH . "modules/classes/Users.php";
require_once WPATH . "modules/classes/System_Administration.php";
$system_administration = new System_Administration();
$users = new Users();
$books = new Books();

unset($_SESSION['book']);
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="?home" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="?view_books" class="current">Books</a> </div>
        <h1>Books</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>Books</h5>
                        <?php require_once('modules/menus/sub-sub-menu-buttons.php'); ?>
                    </div>
                    <div class="widget-content nopadding">

                        <table class="table table-bordered data-table">
                            <tbody>
                                <tr>
                                    <th><h5>ID</h5></th>
                                    <th><h5>Title</h5></th>
                                    <th><h5>Publisher</h5></th>
                                    <th><h5>Author</h5></th>
                                    <th><h5>ISBN Number</h5></th>
                                    <th><h5>Level</h5></th>
                                    <th><h5>Status</h5></th>
                                </tr>

                                <?php
                                if (!empty($_POST)) {
                                    $books_data[] = $books->execute();
                                } else {
                                    $books_data[] = $books->getAllBooks();
                                }
                                if (isset($_SESSION['no_records']) AND $_SESSION['no_records'] == true) {
                                    echo "<tr>";
                                    echo "<td>  No record found...</td>";
                                    echo "<td> </td>";
                                    echo "<td> </td>";
                                    echo "<td> </td>";
                                    echo "<td> </td>";
                                    echo "<td> </td>";
                                    echo "</tr>";
                                    unset($_SESSION['no_records']);
                                } else if (isset($_SESSION['yes_records']) AND $_SESSION['yes_records'] == true) {
                                    foreach ($books_data as $key => $value) {
                                        $inner_array[$key] = json_decode($value, true); // this will give key val pair array
                                        foreach ((array) $inner_array[$key] as $key2 => $value2) {
                                            if ($value2['status'] == 1000) {
                                                $status = "DELETED";
                                            } else if ($value2['status'] == 1001) {
                                                $status = "AWAITING APPROVAL";
                                            } else if ($value2['status'] == 1002) {
                                                $status = "NOT ACTIVE";
                                            } else if ($value2['status'] == 1021) {
                                                $status = "ACTIVE";
                                            } else if ($value2['status'] == 1011) {
                                                $status = "APPROVAL ACCEPTED";
                                            } else if ($value2['status'] == 1010) {
                                                $status = "APPROVAL REJECTED";
                                            }

                                            if ($value2['publisher_type'] == "COMPANY") {
                                                $publisher_details = $users->fetchPublisherDetails($value2['publisher']);
                                                $publisher_name = $publisher_details['company_name'];
                                            } else if ($value2['publisher_type'] == "SELF") {
                                                $publisher_details = $users->fetchSelfPublisherDetails($value2['publisher']);
                                                $publisher_name = $publisher_details['firstname'] . " " . $publisher_details['lastname'];
                                            }

                                            
//                                            $book_type_details = $system_administration->fetchBookTypeDetails($value2['type_id']);
                                            $book_level_details = $system_administration->fetchBookLevelDetails($value2['level_id']);

                                            echo "<tr>";
                                            echo "<td> <a href='?individual_book&code=" . $value2['id'] . "'>" . $value2['id'] . "</td>";
                                            echo "<td>" . $value2['title'] . "</td>";
                                            echo "<td>" . $publisher_name . "</td>";
//                                            echo "<td>" . $book_type_details['name'] . "</td>";
                                            echo "<td>" . $value2['author'] . "</td>";
                                            echo "<td>" . $value2['isbn_number'] . "</td>";
                                            echo "<td>" . $book_level_details['name'] . "</td>";
                                            echo "<td>" . $status . "</td>";
                                            echo "</tr>";
                                        }
                                    }
                                    unset($_SESSION['yes_records']);
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>