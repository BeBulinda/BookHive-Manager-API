
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
if (!empty($_POST)) {

    $createdby = $_POST['createdby'];
    $filename = md5($createdby . time());
    $cover_photo_name = $_FILES['cover_photo']['name'];
    $tmp_name = $_FILES['cover_photo']['tmp_name'];
    $extension = substr($cover_photo_name, strpos($cover_photo_name, '.') + 1);
    $cover_photo = strtoupper($filename . '.' . $extension);
    $_SESSION['filename'] = $cover_photo;

    $url = "http://localhost/bookhive_web/";
//    $url = "http://live_url/bookhive_web/";

    if ($_POST['book_level'] == 1) {
        $location = $url . 'modules/images/books/ecd/';
    } else if ($_POST['book_level'] == 2) {
        $location = $url . 'modules/images/books/primary/';
    } else if ($_POST['book_level'] == 3) {
        $location = $url . 'modules/images/books/secondary/';
    } else if ($_POST['book_level'] == 4) {
        $location = $url . 'modules/images/books/adult/';
    }

    if (move_uploaded_file($tmp_name, $location . $cover_photo)) {
        $success = $books->execute();
        if (is_bool($success) && $success == true) {
            $_SESSION['add_success'] = true;
        }
        App::redirectTo("?view_books");
    } else {
        $_SESSION['create_error'] = "Error uploading photo. Kindly add the book again.";
    }
}
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="?home" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="?view_books">Books</a> <a href="?add_book" class="current">Add Book</a> </div>
        <h1>Add Book</h1>
    </div>

    <?php
    if (isset($_SESSION['add_success'])) {
        echo "Record successfully added...";
        unset($_SESSION['add_success']);
    } else if (!empty($_POST)) {
        echo "Error adding record...";
    }
    ?>

    <div class="container-fluid"><hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">          
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" name="basic_validate" id="basic_validate" novalidate="novalidate" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="add_book"/>
                            <input type="hidden" name="createdby" value="<?php echo 01; //  echo $_SESSION['userid'];         ?>"/>

                            <div class="control-group">
                                <label class="control-label">Title</label>
                                <div class="controls">
                                    <input type="text" name="title" id="title">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Author</label>
                                <div class="controls">
                                    <input type="text" name="author" id="author">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Description</label>
                                <div class="controls">
                                    <textarea class="span11" name="description" id="description"></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Publisher Type</label>
                                <div class="controls">
                                    <select name="publisher_type">
                                        <option value="none">Select publisher type</option>
                                        <option value="company">Company/Business</option>
                                        <option value="self">Self Publisher</option>
                                    </select>
                                </div>
                            </div>

                            --------------To implement show-hide for this------------------------------

                            <?php // if ($publisher_type == "company") { ?>
                            <div class="control-group">
                                <label class="control-label">Publisher</label>
                                <div class="controls">
                                    <select name="publisher" id="publisher">
                                        <?php echo $users->getPublishers(); ?>
                                    </select>
                                </div>
                            </div>
                            <?php // } else if ($publisher_type == "company") { ?>
                            <div class="control-group">
                                <label class="control-label">Publisher</label>
                                <div class="controls">
                                    <select name="self_publisher">
                                        <?php echo $users->getSelfPublishers(); ?>
                                    </select>
                                </div>
                            </div>
                            <?php // } ?>

                            ---------------------------------------------------------------------------

                            <div class="control-group">
                                <label class="control-label">Year of Publication</label>
                                <div class="controls">
                                    <input type="number" name="publication_year" id="publication_year">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">ISBN Number</label>
                                <div class="controls">
                                    <input type="text" name="isbn_number" id="isbn_number">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Book Type</label>
                                <div class="controls">
                                    <select name="book_type" id="book_type">
                                        <?php echo $system_administration->getBookTypes(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Book Level</label>
                                <div class="controls">
                                    <select name="book_level" id="book_level">
                                        <?php echo $system_administration->getBookLevels(); ?>
                                    </select>
                                </div>
                            </div>

                            --------------To implement show-hide for this------------------------------

                            <?php // if (book_level == "primary") { ?>
                            <div class="control-group">
                                <label class="control-label">Class</label>
                                <div class="controls">
                                    <select name="primary_class">
                                        <option value="none">Select Class</option>
                                        <option value="1">Class One</option>
                                        <option value="2">Class Two</option>
                                        <option value="3">Class Three</option>
                                        <option value="4">Class Four</option>
                                        <option value="5">Class Five</option>
                                        <option value="6">Class Six</option>
                                        <option value="7">Class Seven</option>
                                        <option value="8">Class Eight</option>
                                        <option value="revision">Revision Book</option>
                                        <option value="all">All Classes</option>
                                    </select>
                                </div>
                            </div>
                            <?php // } else if (book_level == "secondary") { ?>
                            <div class="control-group">
                                <label class="control-label">Class</label>
                                <div class="controls">
                                    <select name="secondary_class">
                                        <option value="none">Select Class</option>
                                        <option value="1">Form One</option>
                                        <option value="2">Form Two</option>
                                        <option value="3">Form Three</option>
                                        <option value="4">Form Four</option>
                                        <option value="revision">Revision Book</option>
                                        <option value="all">All Classes</option>
                                    </select>
                                </div>
                            </div>
                            <?php // } ?>

                            ---------------------------------------------------------------------------

                            <div class="control-group">
                                <label class="control-label">Print Type</label>
                                <div class="controls">
                                    <select name="print_type">
                                        <option value="none">Select Print Type</option>
                                        <option value="printed">Printed</option>
                                        <option value="digital">Digital</option>
                                        <option value="audio">Audio</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Price</label>
                                <div class="controls">
                                    <input type="number" name="price" id="price">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Cover Photo</label>
                                <div class="controls">
                                    <input type="file" name="cover_photo"/>
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