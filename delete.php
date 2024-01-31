<?php
$db = mysqli_connect("localhost", "root", "Anushka@25", "pr_exam");
if (!$db) {
    die('error in db' . mysqli_error($db));
}

$id = $_GET['id'];

// Fetch the image path before deleting the record
$imagePathQuery = "SELECT pr_c_image FROM pr_catering_items WHERE pr_c_id = $id";
$imagePathResult = mysqli_query($db, $imagePathQuery);

if ($imagePathResult && $imagePathRow = mysqli_fetch_assoc($imagePathResult)) {
    $imagePath = $imagePathRow['pr_c_image'];

    // If the file path doesn't start with 'uploads/', prepend it
    if (!preg_match('/^uploads\//', $imagePath)) {
        $imagePath = 'uploads/' . $imagePath;
    }

    // Check if the file exists and delete it
    if (is_file($imagePath)) {
        unlink($imagePath);
    }
}

$qry = "DELETE FROM pr_catering_items WHERE pr_c_id = $id";

if (mysqli_query($db, $qry)) {
    echo '<script>alert("User Deleted Successfully");</script>';
    header('location: index.php');
} else {
    echo mysqli_error($db);
}
?>
