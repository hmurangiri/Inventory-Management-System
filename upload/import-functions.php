<?php
function sanitize($input)
{
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    $input = trim($input);
    $input = substr($input, 0, 255); // Limit to 255 characters
    return $input;
}

function generateHTML($tag, $number) {
    for($i = 0; $i < $number; $i++) {
        echo "<" . $tag . ">" . htmlspecialchars(sanitize($data[0])) . "</" . $tag . ">";
    }
}

function getInfo($message) {
    echo "<table style='margin-top:10px;border:none;'>";
    echo "<tr style='border:none;'><td style='border:none;'>";
    
    if ($message == "imported") {
        echo  $imported_rows . " out of " . $total_rows . " imported!";
    } else if ($message == "openError") {
        echo "Failed to open the file.";
    } else if ($message == "uploadError") {
        echo "Please upload a valid CSV file.";
    }
    
    echo "</td></tr></table>";
}



function getResponse($numberOfColumns) {
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
                    }
                }
                
                if ($not_imported == 1) {
                    echo "</table>";
                }
                
                getInfo("imported");
                
                $conn->close();
                fclose($handle);
            }
        } else {
            getInfo("openError");
        }
    } else {
        getInfo("uploadError");
    }
}
}