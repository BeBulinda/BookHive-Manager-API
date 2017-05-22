
<!--<tr>
    <td> <a href='?individual_book&code= <?php // echo $value2['id'];  ?>'> <?php // echo $value2['title'];  ?> </td>
    <td><?php // echo $value2['publisher'];  ?></td>
    <td><?php // echo $value2['price'];  ?></td>
    <td>
        <label class="checkbox"> <input type="checkbox"> </label>
    </td>
    <td>
        <input type="text" name="quantity" value="1" size="2" /><input type="submit" value="Add to cart" class="btnAddAction" />
        <div class="input-append"><input type="text" name="quantity" class="span1" style="max-width:34px" placeholder="0" id="appendedInputButtons" size="16"><button type="submit" class="btn"><i class="icon-minus"></i></button><button type="submit" class="btn"><i class="icon-plus"></i></button><button type="submit" class="btn btn-danger"><i class="icon-remove icon-white"></i></button></div>
    </td>
    <td><?php // echo $value2['price'];  ?></td>
</tr>-->









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

    if ($_POST['book_level'] == 1) {
        $location = 'modules/images/books/ecd/';
    } else if ($_POST['book_level'] == 2) {
        $location = 'modules/images/books/primary/';
    } else if ($_POST['book_level'] == 3) {
        $location = 'modules/images/books/secondary/';
    } else if ($_POST['book_level'] == 4) {
        $location = 'modules/images/books/adult/';
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
                            <input type="hidden" name="createdby" value="<?php echo 01; //  echo $_SESSION['userid'];        ?>"/>

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
                                <label class="control-label">Publisher</label>
                                <div class="controls">
                                    <select name="publisher" id="publisher">
                                        <?php echo $users->getPublishers(); ?>
                                    </select>
                                </div>
                            </div>
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