<?php $db = mysqli_connect("localhost", "root", "Anushka@25", "pr_exam"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Catering Items</title>
  </head>
  <body>
    <form method="post">
        <label>Name</label>
        <input type="text" name="name" placeholder="Enter Item Name" >
        <br><br>

        <label>Desc</label>
        <input type="text" name="desc" placeholder="Enter Item Description" >
        <br><br>

        <label>Image</label>
        <input type="text" name="imageUrl" placeholder="Enter Item Image URL" >
        <br><br>

        <label>Parent</label>
        <input type="text" name="itemParent" placeholder="Enter Item Parent" >
        <br><br>

        <label>Status</label>
        <input type="number" name="status" placeholder="Enter Item Status" >
        <br><br>

        <input type="submit" name="submit" value="Submit">
    </form>
    <hr>
    <h3>Item List</h3>
    <table style="width: 80%" border="1">
      <tr>
        <th>#s</th>
        <th>Name</th>
        <th>Desc</th>
        <th>Image Url</th>
        <th>Parent</th>
        <th>Status</th>
        <th>Operations</th>
  
      </tr>
      <?php
        $i = 1;
        $qry = "select * from pr_catering_items";
        $run = $db -> query($qry);
        if($run -> num_rows > 0){
          while ($row = $run -> fetch_assoc()) {
            $id = $row['pr_c_id'];
      ?>
      <tr>
        <td><?php echo $i++ ?></td>
        <td><?php echo $row['pr_c_name']?></td>
        <td><?php echo $row['pr_c_desc']?></td>
        <td><?php echo $row['pr_c_image']?></td>
        <td><?php echo $row['pr_c_parent']?></td>
        <td><?php echo $row['pr_c_status']?></td>
        <td>
          <a href="edit.php?id=<?php echo $id; ?>">Edit</a>
          <a href="delete.php?id=<?php echo $id; ?>" onclick = "return confirm('Are you sure?')">Delete</a>
        </td>

      </tr>
      <?php 
          }
        }
      ?>
    </table>
  </body>
</html>

<?php
if(isset($_POST['submit'])){
  $name = $_POST['name'];
  $desc = $_POST['desc'];
  $imageUrl = $_POST['imageUrl'];
  $itemParent = $_POST['itemParent'];
  $status = $_POST['status'];

  $qry = "insert into pr_catering_items values(null, '$name', '$desc', '$imageUrl', '$itemParent', '$status')";

  if(mysqli_query($db, $qry)){
    echo'<script>alert("User Registered Successfully");</script>';
    header('location: index.php');
  }else{
    echo mysqli_error($db);
  }


}

?>