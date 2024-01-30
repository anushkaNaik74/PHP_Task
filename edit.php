<?php
    $db = mysqli_connect("localhost", "root", "Anushka@25", "pr_exam");
    if (!$db) {
        die('error in db' . mysqli_error($db));
    }else{
        $id = $_GET['id'];
        $qry = "select * from pr_catering_items where pr_c_id = $id";
        $run = $db -> query($qry);
        if($run -> num_rows > 0){
          while ($row = $run -> fetch_assoc()) {
                $name = $row['pr_c_name'];
                $desc = $row['pr_c_desc'];
                $imageUrl = $row['pr_c_image'];
                $itemParent = $row['pr_c_parent'];
                $status = $row['pr_c_status'];
            }
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
    <form method="post">
        <label>Name</label>
        <input type="text" name="name" value="<?php echo $name ?>" >
        <br><br>

        <label>Desc</label>
        <input type="text" name="desc" value="<?php echo $desc ?>" >
        <br><br>

        <label>Image</label>
        <input type="text" name="imageUrl" value="<?php echo $imageUrl ?>" >
        <br><br>

        <label>Parent</label>
        <input type="text" name="itemParent" value="<?php echo $itemParent ?>" >
        <br><br>

        <label>Status</label>
        <input type="number" name="status" value="<?php echo $status ?>" >
        <br><br>

        <input type="submit" name="update" value="Update">
    </form>
    </body>
</html>

<?php
if(isset($_POST['update'])){
  $name = $_POST['name'];
  $desc = $_POST['desc'];
  $imageUrl = $_POST['imageUrl'];
  $itemParent = $_POST['itemParent'];
  $status = $_POST['status'];

  $qry = "update pr_catering_items set pr_c_name = '$name', pr_c_desc='$desc', pr_c_image='$imageUrl', pr_c_parent='$itemParent', pr_c_status='$status' where pr_c_id = $id";

  if(mysqli_query($db, $qry)){
    header('location: index.php');
  }else{
    echo mysqli_error($db);
  }


}

?>