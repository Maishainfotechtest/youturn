 <?php 
 include 'connection.php';
 if (isset($_POST['submit'])) {
    $select = "SELECT * FROM `mon_dis` where status= 1";
    $run = mysqli_query($conn , $select);

     $name = $_POST['data'];
      echo "<pre>";
      print_r($name);
      echo "</pre>";
 }
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
 </head>
 <body>
 <form action="" method="post">
 <?php  while (  $data = mysqli_fetch_assoc($run) ) { ?>
     <input type="text" name="data[<?php echo $data['D_id'] ?>]" id="">   
     <?php } ?>
     <input type="submit" value="submit" name="submit">
 </form>
    
 </body>
 </html>