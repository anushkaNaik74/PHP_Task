<?php
    $db = mysqli_connect("localhost", "root", "Anushka@25", "pr_exam");
    if (!$db) {
        die('error in db' . mysqli_error($db));
    }

    $id = $_GET['id'];

    $qry = "delete from pr_catering_items where pr_c_id = $id";

    if(mysqli_query($db, $qry)){
        echo'<script>alert("User Deleted Successfully");</script>';
        header('location: index.php');
      }else{
        echo mysqli_error($db);
      }
?>