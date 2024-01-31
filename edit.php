<?php
$db = mysqli_connect("localhost", "root", "Anushka@25", "pr_exam");
if (!$db) {
    die('error in db' . mysqli_error($db));
}

// Variables to store form data
$pr_c_id = $pr_c_name = $pr_c_desc = $pr_c_image = $pr_c_parent = $pr_c_status = '';

// Fetch data for editing when the page loads
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $qry = "SELECT * FROM pr_catering_items WHERE pr_c_id = $id";
    $run = $db->query($qry);
    if ($run->num_rows > 0) {
        $row = $run->fetch_assoc();
        $pr_c_id = $row['pr_c_id'];
        $pr_c_name = $row['pr_c_name'];
        $pr_c_desc = $row['pr_c_desc'];
        $pr_c_image = $row['pr_c_image'];
        $pr_c_parent = $row['pr_c_parent'];
        $pr_c_status = $row['pr_c_status'];
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch the old image path before updating the record
    $oldImagePathQuery = "SELECT pr_c_image FROM pr_catering_items WHERE pr_c_id = $pr_c_id";
    $oldImagePathResult = mysqli_query($db, $oldImagePathQuery);

    if ($oldImagePathResult && $oldImageRow = mysqli_fetch_assoc($oldImagePathResult)) {
        $oldImagePath = $_SERVER['DOCUMENT_ROOT'] . $oldImageRow['pr_c_image'];

        // Check if a new image is uploaded
        if (!empty($_FILES['imageUrl']['name'])) {
            $uploadDir = 'uploads/';
            $uploadedFile = $uploadDir . basename($_FILES['imageUrl']['name']);

            if (move_uploaded_file($_FILES['imageUrl']['tmp_name'], $uploadedFile)) {
                // File upload successful
                $pr_c_image = $uploadedFile;

                // Check if the old file exists and delete it
                if ($oldImagePath && is_file($oldImagePath)) {
                    if (unlink($oldImagePath)) {
                        echo "Old image deleted successfully.";
                    } else {
                        echo "Failed to delete old image.";
                    }
                } else {
                    echo "Old image path does not exist or is not a file.";
                }
            } else {
                // File upload failed
                echo "Error uploading file";
            }
        } else {
            // No new image uploaded, use the existing one
            $pr_c_image = $oldImageRow['pr_c_image'];
        }

        // Retrieve other form fields
        $pr_c_name = $_POST['name'];
        $pr_c_desc = $_POST['desc'];
        $pr_c_parent = $_POST['itemParent'];
        $pr_c_status = $_POST['status'];

        // Update data in the database
        $updateQuery = "UPDATE pr_catering_items SET pr_c_name = '$pr_c_name', pr_c_desc = '$pr_c_desc', pr_c_image = '$pr_c_image', pr_c_parent = '$pr_c_parent', pr_c_status = '$pr_c_status' WHERE pr_c_id = '$pr_c_id'";

        // Execute the SQL query
        if (mysqli_query($db, $updateQuery)) {
            echo '<script>alert("User Registered Successfully");</script>';
            header('location: index.php');
        } else {
            echo "Error updating record: " . mysqli_error($db);
        }
    } else {
        echo "Error fetching old image path.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Item</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="pr_c_id" value="<?php echo $pr_c_id; ?>">
        
        <label>Name</label>
        <input type="text" name="name" value="<?php echo $pr_c_name ?>" >
        <br><br>

        <label>Desc</label>
        <input type="text" name="desc" value="<?php echo $pr_c_desc ?>" >
        <br><br>

        <label>Image</label>
        <!-- Hidden input to store the existing image path -->
        <input type="hidden" name="existing_image" value="<?php echo $pr_c_image; ?>">
        <br><br>

        <!-- New image upload field -->
        <label>New Image</label>
        <input type="file" name="imageUrl">
        <br><br>

        <label>Parent</label>
        <input type="text" name="itemParent" value="<?php echo $pr_c_parent ?>" >
        <br><br>

        <label>Status</label>
        <input type="number" name="status" value="<?php echo $pr_c_status ?>" >
        <br><br>

        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>
