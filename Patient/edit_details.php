<?php
    include("../Templates/Patients_Template.php"); 
?>

<title>Edit Details</title>
<div id="content">
    <h2>Update Details</h2>
    <p>Please update your details to help us serve you better. Thank you.<br/></p>
     <?php 
      //$patient_id = "G0562934N";
      //$results = patient_info($patient_id);  
      $query = "SELECT * FROM patient WHERE id_number=(?)";
      $params = array($patient_id);
      $query_results = sqlsrv_query($conn, $query, $params);
      if(!$query_results)
		  echo("No results found!");
       $results = sqlsrv_fetch_array($query_results);
 
    ?>

    <form action="save.php" method="post">
      <table id="edit_details" cellpadding="5" cellspacing="7">
            <tr>
                <td>Name:</td>
                <td><?php echo $results['name']?></td>
            </tr>
            <tr>
                <td>Address:</td>
                <td><input type="text" name="address" value='<?php echo $results['address'];?>'</td>
            </tr>
             <tr>
                <td>Contact:</td>
                <td><input type="number" name="contact" value=<?php echo $results['contact_number']?>></td>
            </tr>
            <tr>
                <td>NRIC:</td>
                 <td><?php echo $results['id_number']?></td>
            </tr>
            
            <tr>
                <td>Blood Group</td>
                <td><input type="text" name="bloodgrp" value=<?php echo $results['blood_group']?>></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="save" value="Save"> 
                <a href="home.php"><input type="button" name="cancel" value="Cancel"></a></td>
            </tr>
     </table>
    </form>
</div>  
</body>