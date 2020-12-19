<?php  include 'connection.php'; 
 
if (isset($_POST['submit'])) {
  $val = $_POST['disease'];
  $token = openssl_random_pseudo_bytes(8);
  $token = bin2hex($token);
  $order_id =openssl_random_pseudo_bytes(12);
  $order_id = "YGK".bin2hex($order_id);   
  $date = date('Y:m:d');
  $time = date("H:i:s");
  
  $name = $_POST['disease'];
  
 //data inserting in main table
    $inmain = "INSERT INTO `male` (`id`, `order_id`, `token`, `Date`, `time`, `datetime`, `status`) VALUES (NULL, '$order_id', '$token', '$date', '$time', current_timestamp(), '0')";

  $mainrun = mysqli_query($conn , $inmain);
  if ($mainrun) {
      echo "data inserted succcesfully";
  }else {
     echo "data not inserted";
  }   
  //data inserting in display table
   $name = $_POST['disease'];

   foreach ($name as  $value ) {
     $display = " INSERT INTO `display` (`id`, `value`, `datetime`, `status`) VALUES (NULL, '$value', current_timestamp(), '0')";
     $res = mysqli_query($conn , $display);
   }
   if($res){
     echo "<br> data inserted in display table ";
   } 

   
  //data inserting in disease table
 
  $get = mysqli_query($conn , "select * from mon_dis");
  while ( $id= mysqli_fetch_assoc($get) ) {
 
     $id = $id['D_id'];
     $name = $_POST['disease'];
     foreach ($name as  $value) {

      $dissql = "INSERT INTO `disease` (`id`, `order_id`, `token`, `D_id`, `value`, `date`, `time`, `datetime`) VALUES (NULL, '$order_id', '$token', '$id', '$value', '$date', '$time', current_timestamp())";
      $res = mysqli_query($conn , $dissql);
    }
     
     
    
    

} 

if ($res) {
     echo "data inserted";
   }else {
      echo "data not inserted " .  mysqli_error($conn);
   }

}   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>disease</title>
    <style>
    form{
        position : absolute;
        top:10%;
        left: 20%;
        }
    </style>
</head>
<body >
<form action="index.php" method="post">
<table class="table" border="1px" cellspacing="0px" cellpadding="5px">
  <thead class="thead-dark">
    <tr >
      <th scope="col"> Id</th>
      <th scope="col"> Disease Name</th>
      <th scope="col"> Result</th>
    </tr>
  </thead>
 
  <tbody>
  <?php 
   
   $select = "SELECT * FROM `mon_dis` where status= 1";
   $run = mysqli_query($conn , $select);
 
   while (  $data = mysqli_fetch_assoc($run) ) { ?>
       <tr>
            <th scope="row" name="Ds_id"><?php echo $data['D_id']; ?></th>
             <td><?php echo $data['D_Name']; ?></td>
             <td><input type="text" name="disease[]" id=" " placeholder="Enter value">
            
             </td>
      </tr>

   <?php }  ?>
</tbody>
</table>
  <input type="submit" value="submit" name="submit" id="submit">
</form>
<script>
  window.onbeforeunload = function  () {
    return "are you sure";
  }
  $(document).on("submit" , "form" , function  (event) {
    window.onbeforeunload = null;
  })
</script>


</body>
</html>