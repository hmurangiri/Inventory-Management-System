<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

$home = '../';
$home2 = '../';

$title = 'Import Product';
$desc = '';
$keywords = '';

include '../utilities/inventory_menu.php';
include_once '../db/config.php';
?>

<div class="container content">

    <div class="row justify-content-center">
        <div class="col-12">
            <header class="header">
                <div>
                    <p id="description" class="text-center">
                        Import Products
                    </p>
                </div>
            </header>
        </div>


        <div class="form-wrap">
            <form id="survey-form" method="post" enctype="multipart/form-data" onsubmit="return validateFileSize()">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label id="product-import-label" for="name">Select Csv File To Import:</label>
                            <input type="file" name="csvfile" id="fileToUpload">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label id="product-delimiter-label" for="name">Delimiter: </label>
                            <input type="text" name="delimiter" id="delimiter" value=","
                                placeholder="Specify the delimiter used" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 container text-center">
                        <button type="submit" id="submit" name="preview"
                            class="btn btn-primary btn-block">Preview</button>
                    </div>

                    <div class="col-md-4 container text-center">
                        <button type="submit" id="submit" name="upload"
                            class="btn btn-primary btn-block">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="message-info">
    <h1>Expected Columns:</h1>
    <table style="width:100%;">
        <tr>
            <th>Name</th>
            <th>Desc</th>
            <th>Category</th>
        </tr>
    </table>
</div>

<script>
    function validateFileSize() {
        const fileInput = document.getElementById('fileToUpload');
        const maxSize = 2 * 1024 * 1024; // 2 MB in bytes

        if (fileInput.files[0].size > maxSize) {
            alert("The file is too large. Maximum size is 2MB.");
            fileInput.value = ''; // Clear the file input
            return false;
        }
        return true;
    }
</script>

<?php
function sanitize($input)
{
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    $input = trim($input);
    $input = substr($input, 0, 255); // Limit to 255 characters
    return $input;
}

if (((isset($_POST['preview'])) or (isset($_POST['upload']))) && isset($_FILES['csvfile'])) {
    $filename = $_FILES['csvfile']['tmp_name'];
    $fileType = pathinfo($_FILES['csvfile']['name'], PATHINFO_EXTENSION);
    $delimiter = htmlspecialchars($_POST['delimiter']); ?>
    
    <script>
       document.getElementById("message-info").innerHTML = "";
    </script>

    <?php
    // Check if the file is a CSV
    if (!empty($filename) && $fileType == 'csv') {
        // Attempt to open the uploaded file

        if (($handle = fopen($filename, "r")) !== FALSE) {
            if (isset($_POST['preview'])) {
                echo "<h1>CSV File Content:</h1>";
                echo "<table border='1'>";
                $preview_line = 0;

                // Read the file line by line
                while (($data = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                    $preview_line += 1;
                    
                    echo "<tr>";
                    if ($preview_line == 1) {
                        echo "<th>" . htmlspecialchars(sanitize($data[0])) . "</th>";
                        echo "<th>" . htmlspecialchars(sanitize($data[1])) . "</th>";
                        echo "<th>" . htmlspecialchars(sanitize($data[2])) . "</th>";
                    } else {
                        echo "<td>" . htmlspecialchars(sanitize($data[0])) . "</td>";
                        echo "<td>" . htmlspecialchars(sanitize($data[1])) . "</td>";
                        echo "<td>" . htmlspecialchars(sanitize($data[2])) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else if (isset($_POST['upload'])) {
                include_once "../db/config.php";
                $skipfirstline = true;
                $total_rows = 0;
                $imported_rows = 0;
                $not_imported = 0;
                while (($data = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                    if ($skipfirstline) {
                        $skipfirstline = false;
                        continue;
                    }

                    $total_rows += 1;

                    $name = htmlspecialchars(sanitize($data[0]));
                    $desc = htmlspecialchars(sanitize($data[1]));
                    $category = htmlspecialchars(sanitize($data[2]));

                    $sql = "SELECT CategoryID FROM categories WHERE Name = ? AND StoreID = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ss", $category, $_SESSION["store_id"]);
                    $stmt->execute();
                    $stmt->bind_result($category_id);

                    if ($stmt->fetch()) {
                        $stmt->close();

                        $sql = "INSERT INTO products (Name, Description, CategoryID, StoreID) VALUES (?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ssii", $name, $desc, $category_id, $_SESSION["store_id"]);

                        if ($stmt->execute()) {
                            $stmt->close();
                            $imported_rows += 1;
                        } else {
                            $stmt->close();
                            continue;
                            // echo "Could not be imported!";
                        }
                    } else {
                        $stmt->close();
                        $not_imported += 1;
                        
                        if ($not_imported == 1) {
                            echo "<h1>Errors Encountered: </h1>";
                            echo "<table border='1'>";
                            echo "<tr>";
                            echo "<th>Name</th>";
                            echo "<th>Desc</th>";
                            echo "<th>Category</th>";
                            echo "<th>Error</th>";
                            echo "<tr>";
                        }
                        
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars(sanitize($data[0])) . "</td>";
                        echo "<td>" . htmlspecialchars(sanitize($data[1])) . "</td>";
                        echo "<td>" . htmlspecialchars(sanitize($data[2])) . "</td>";
                        echo "<td>Category not found</td>";
                        echo "</tr>";
                        
                        continue;
                        
                        // echo "Category not found";
                    }
                }
                
                if ($not_imported == 1) {
                    echo "</table>";
                }
                
                echo "<table style='margin-top:10px;border:none;'>";
                echo "<tr style='border:none;'><td style='border:none;'>" . $imported_rows . " out of " . $total_rows . " imported! </td></tr>";
                echo "</table>";
                
                // echo $imported_rows . " out of " . $total_rows . " imported! ";
                $conn->close();
                fclose($handle);
            }
        } else {
            echo "Failed to open the file.";
        }
    } else {
        echo "Please upload a valid CSV file.";
    }
}
?>

<?php


if (isset($_GET['message'])) {
    $msg = '<script>';
    $msg = $msg . 'setTimeout(function(){ alert("' . htmlspecialchars($_GET['message']) . '"); }, 1000);';
    $msg = $msg . '</script>';

    echo $msg;
}

include_once "../utilities/inventory_footer.php";
?>