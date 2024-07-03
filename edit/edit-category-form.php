<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

$home = '../';
$home2 = '../';

$title = 'Edit Category';
$desc = '';
$keywords = '';

include '../utilities/inventory_menu.php';

include_once('../db/config.php');
$category_id = $_GET['id'];

$sql = "SELECT CategoryID, Name, Description FROM categories WHERE CategoryID = ? AND StoreID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $category_id, $_SESSION['store_id']);
$stmt->execute();
$result = $stmt->get_result();
$category = $result->fetch_assoc();
$stmt->close();
$conn->close();

?>

<div class="container content">

    <div class="row justify-content-center">
        <div class="col-12">
            <header class="header">
                <div>
                    <!-- <h1 id="title" class="text-center" style="text-align:center;">Inventory Management</h1>
                    <hr> -->

                    <p id="description" class="text-center">
                        Edit Category
                    </p>
                </div>
            </header>
        </div>


        <div class="form-wrap">
            <form id="survey-form" method="post" action="edit-category-response.php">

                <input type="hidden" name="category_id" value="<?php echo $category['CategoryID']; ?>">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label id="name-label" for="name">Name</label>
                            <input type="text" name="category-name" id="category-name" class="form-control"
                                value="<?php echo $category['Name']; ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea id="category-desc" class="form-control"
                                name="category-desc"><?php echo $category['Description']; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 container text-center">
                        <button type="submit" id="submit" class="btn btn-primary btn-block">Save
                            Category Changes</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

</div>

<?php

include '../utilities/inventory_footer.php'
    ?>
</body>

</html>