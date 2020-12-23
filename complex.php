<?php include 'connection.php';
  if (isset($_POST['submit'])) {
    $complex = $_POST['complex'];
    $token = openssl_random_pseudo_bytes(8);
    $token = bin2hex($token);
    $order_id = openssl_random_pseudo_bytes(12);
    $order_id = "YGK" . bin2hex($order_id);
    $date = date('Y:m:d');
    $time = date("H:i:s");  
    
   
  $complex = $_POST['complex'];
    
 

 
}
?>
 <!-- Complex Disease name Table -->
 <form action="" method="post">
 <table class="table" border="1px" cellspacing="0px" cellpadding="5px">
      <thead class="thead-dark">
        <tr>
          <th scope="col"> Id</th>
          <th scope="col"> Complex Disease Name</th>
          <th scope="col" colspan="3"> Result</th>
        </tr>
      </thead>

      <tbody>
        <?php

        $select = "SELECT * FROM `complex` where status= 1";
        $run = mysqli_query($conn, $select);

        while ($data = mysqli_fetch_assoc($run)) { ?>
          <tr>
            <th scope="row">
              <?php echo $data['com_id']; ?>
            </th>
            <td>
              <?php echo $data['ComDisName']; ?>
            </td>
            <td><input type="text" name="complex[<?php echo $data['com_id']; ?>][yourRisk]" id=" " placeholder="Your Risk" value="0"></td>
            <td><input type="text" name="complex[<?php echo $data['com_id']; ?>][AvgRisk]" id=" " placeholder="AverageRisk" value="0"></td>
            <td><input type="text" name="complex[<?php echo $data['com_id']; ?>][CompRisk]" id=" " placeholder="Compare to Average Risk"  ></td>
          </tr>

        <?php }  ?>
        
      </tbody>
    </table> 
    <input type="submit" value="submit" name="submit" id="submit">
 </form> 