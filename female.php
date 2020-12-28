<?php include 'connection.php';
if (isset($_POST['submit'])) {

    $token = openssl_random_pseudo_bytes(8);
    $token = bin2hex($token);
    $order_id = openssl_random_pseudo_bytes(12);
    $order_id = "YGK" . bin2hex($order_id);
    $date = date('Y:m:d');
    $time = date("H:i:s");

    // 1 data inserting in female_report table
    $inmain = "INSERT INTO `female_report` (`F_id`, `order_id`, `token`, `Date`, `time`, `datetime`, `status`) VALUES (NULL, '$order_id', '$token', '$date', '$time', current_timestamp(), '0')";

    $mainrun = mysqli_query($conn, $inmain);
    if ($mainrun) {
        echo "data inserted succcesfully in female_report";
    } else {
        echo "data not inserted in female_report" . mysqli_error($conn);
    }

    // 2 data inserting in disease_input_female table
    $name = $_POST['disease'];
    $val = $_POST['disease'];
    foreach ($name as  $value) {
        $display = " INSERT INTO `disease_input_female` (`id`, `value`, `datetime`, `status`) VALUES (NULL, '$value', current_timestamp(), '1')";
        $res = mysqli_query($conn, $display);
    }
    if ($res) {
        echo "<br> data inserted in disease_input_female table ";
    }
    // 3 data inserting in disease_female table
    $get = mysqli_query($conn, "select * from mon_dis_female");
    //getting disease id in loop
    $name = $_POST['disease'];
    //getting input data in foreach loop   
    foreach ($name as $key => $value) {
        $dissql = "INSERT INTO `disease_female` (`id`, `order_id`, `token`, `D_id`, `DiseaseValue`, `date`, `time`, `datetime`) VALUES (NULL, '$order_id', '$token', '$key', '$value', '$date', '$time', current_timestamp())";
        $res = mysqli_query($conn, $dissql);
    }
    if ($res) {
        echo "<br> data inserted in disease_female";
    } else {
        echo "data not inserted in disease_female " .  mysqli_error($conn);
    }
    //inserting into  drug_input_female   table
    $drugName = $_POST['drugs'];
    foreach ($drugName as  $Dname) {
        $drugsdata = " INSERT INTO `drug_input_female` (`id`, `value`,  `status` ,`datetime`) VALUES (NULL, '$Dname',  '1' ,current_timestamp())";
        $res = mysqli_query($conn, $drugsdata);
    }
    if ($res) {
        echo "<br> data inserted in drugs_input_female table ";
    } else {
        echo "<br> data  not inserted in  drugs_input_female table " . mysqli_error($conn);
    }
    //data inserting in drugs_female table 

    foreach ($drugName as $drg_id => $value) {
        $maleDrug = "INSERT INTO `drugs_female` (`id`, `order_id`, `token`, `drg_id`, `DrugValue`, `date`, `time`, `datetime`) VALUES (NULL, '$order_id', '$token', '$drg_id', '$value', '$date', '$time', current_timestamp())";

        $run = mysqli_query($conn, $maleDrug);
    }
    if ($run) {
        echo "data inserted in drugs_female table <br>";
    } else {
        echo "<br> data not inserted into drugs_female due to " . mysqli_error($conn);
    }

    //getting complex disease data from form 
    $complex = $_POST['complex'];

    foreach ($complex as $key => $value) {

        $yrRisk = $complex[$key]['yourRisk'];
        $avgRisk = $complex[$key]['AvgRisk'];
        $compRisk = $complex[$key]['CompRisk'];
        //data inserting in  complex_disease_female table  
        $insert = "INSERT INTO `complex_disease_female` (`id`, `order_id`, `token`, `com_id`, `yourRisk`, `Avg Risk`, `CompAvgRisk`, `Date`, `time`, `DateTime`) VALUES (NULL, '$order_id', '$token', $key, '$yrRisk', '$avgRisk', '$compRisk', '$date', '$time', current_timestamp());";
        $run = mysqli_query($conn, $insert);
    }
    if ($run) {
        echo "data inserted in table female_compelx_disease succesfully";
    } else {
        echo "data not inserted in complex disease table " . mysqli_error($conn);
    }

    //getting trait values from table
    $trait = $_POST['trait'];
    //inserting data into male_trait_input table
    foreach ($trait as $value) {
        $trait = "INSERT INTO `female_trait_input` (`id`, `value`, `status`, `datetime`) VALUES (NULL, '$value', '1', current_timestamp());";
        $run = mysqli_query($conn, $trait);
    }
    if ($run) {
        echo "data enter in trait table";
    } else {
        echo "data not inserted due to : " . mysqli_error($conn);
    }

    //inserting trait id and value into female_trait table 
    $trait = $_POST['trait'];
    foreach ($trait as $key => $value) {
        $male_trait = "INSERT INTO `female_trait` (`id`, `order_id`, `token`, `trait_id`, `trait_value`, `date`, `time`, `datetime`) VALUES (NULL, '$order_id', '$token', '$key', '$value', '$date', '$time', current_timestamp())";
        $run = mysqli_query($conn, $male_trait);
    }
    if ($run) {
        echo "data entered in female_trait table succesfully";
    } else {
        echo "data not inserted due to : " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="refresh.js"></script>
    <style>
         #submit {
      padding: 5px 3px;
      width: 40%;
      font-weight: bold;
      text-transform: uppercase;
      margin: 12px 0;
      background-color:  #bdc3c7;
      cursor: pointer;
      border-radius: 12px;
    }
    </style>
    <title>YouTurn | Genetic Testing Kit (female)</title>
</head>

<body>
    <form action="female.php" method="post">
        <!-- Disease name table  (female) -->
        <table class="table" border="1px" cellspacing="0px" cellpadding="5px">
            <h2>GENERAL REPORT FOR MONOGENIC DISEASES </h2>
            <thead class="thead-dark">
                <tr>
                    <th scope="col"> Id</th>
                    <th scope="col"> Disease Name</th>
                    <th scope="col"> Result</th>
                </tr>
            </thead>

            <tbody>
                <?php

                $select = "SELECT * FROM `mon_dis_female` where status= 1";
                $run = mysqli_query($conn, $select);

                while ($data = mysqli_fetch_assoc($run)) { ?>
                    <tr>
                        <th scope="row" name="Ds_id">
                            <?php echo $data['D_id']; ?>
                        </th>
                        <td>
                            <?php echo $data['D_Name']; ?>
                        </td>
                        <td><input type="text" name="disease[<?php echo $data['D_id'] ?>]" id=" " placeholder="Enter value">

                        </td>
                    </tr>

                <?php }  ?>
            </tbody>
        </table>

        <!-- Drugs name Table (female) -->
        <h2>GENERAL REPORT FOR DRUGS </h2>
        <table class="table" border="1px" cellspacing="0px" cellpadding="5px">
            <thead class="thead-dark">
                <tr>
                    <th scope="col"> Id</th>
                    <th scope="col"> Drugs Name</th>
                    <th scope="col"> Result</th>
                </tr>
            </thead>

            <tbody>
                <?php

                $select = "SELECT * FROM `drugsname_female` where status= 1";
                $run = mysqli_query($conn, $select);

                while ($data = mysqli_fetch_assoc($run)) { ?>
                    <tr>
                        <th scope="row">
                            <?php echo $data['drg_id']; ?>
                        </th>
                        <td>
                            <?php echo $data['Drg_name']; ?>
                        </td>
                        <td><input type="text" name="drugs[<?php echo $data['drg_id']; ?>]" id=" " placeholder="Enter value">

                        </td>
                    </tr>

                <?php }  ?>
            </tbody>
        </table>

        <!-- Complex Disease name Table -->
        <h2>GENERAL REPORT FOR COMPLEX DISEASES </h2>
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

                $select =  'SELECT * FROM `complex_dis_name_female` WHERE status = 1';
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
                        <td><input type="text" name="complex[<?php echo $data['com_id']; ?>][AvgRisk]" id=" " placeholder="Average Risk" value="0"></td>
                        <td><input type="text" name="complex[<?php echo $data['com_id']; ?>][CompRisk]" id=" " placeholder="Compare to Average Risk"></td>
                    </tr>

                <?php }  ?>

            </tbody>
        </table>
        <!-- traits name Table -->
        <h2>GENERAL REPORT FOR TRAITS </h2>
        <table class="table" border="1px" cellspacing="0px" cellpadding="5px">
            <thead class="thead-dark">
                <tr>
                    <th scope="col"> Id</th>
                    <th scope="col"> Traits</th>
                    <th scope="col"> Result</th>
                </tr>
            </thead>

            <tbody>
                <?php

                $select = "SELECT * FROM `traits_name_female` where status= 1";
                $run = mysqli_query($conn, $select);

                while ($data = mysqli_fetch_assoc($run)) { ?>
                    <tr>
                        <th scope="row">
                            <?php echo $data['trait_id']; ?>
                        </th>
                        <td>
                            <?php echo $data['Trait_Name']; ?>
                        </td>
                        <td><input type="text" name="trait[<?php echo $data['trait_id']; ?>]" id=" " placeholder="Enter Value"></td>
                    </tr>

                <?php }  ?>
            </tbody>
        </table>


        <input type="submit" value="submit" name="submit" id="submit">
    </form>
   
    
</body>

</html>