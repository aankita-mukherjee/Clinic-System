<?php
    session_start();
    require_once("../Templates/Patients_Template.php");
?>

<title>Welcome!</title>
<div id="content">
    <?php 
      $query = "SELECT * FROM patient WHERE id_number=(?)";
      $params = array($patient_id);
      $query_results = sqlsrv_query($conn, $query, $params);
      if(!$query_results)
			   die("No results found!");
      $results = sqlsrv_fetch_array($query_results);

      ?>
      <h2>Welcome <span style="color: #B29B35"><?php echo $results['name']?></span>!</h2>
     <table id="displayinfo" cellpadding="5" cellspacing="7">
            <tr>
                <th>Name</th>
                <td><?php echo $results['name']?></td>
            </tr>
            <tr>
                <th>Gender</th>
                <td><?php echo $results['gender']?></td>
            </tr>
            <tr>
                <th>Blood Group</th>
                <td><?php echo $results['blood_group']?></td>
            </tr>
            <!--Check datetime later!!!-->
            <tr>
                <th>Address</th>
                <td><?php echo $results['address']?></td>
            </tr>
            <tr>
                <th>Contact</th>
                <td><?php echo $results['contact_number']?></td>
            </tr>
        </table>
        <br /> <br /> <br />
        <?php
               $query = "SELECT  v.datetime, d.name FROM visit v, doctor d WHERE v.doctor=d.id_number AND v.patient=(?)";
               $params = array($patient_id);
               $query_results = sqlsrv_query($conn, $query, $params);
                   if(!$query_results)
			              die("No results found!");
               $results = sqlsrv_fetch_array($query_results);        
        ?>
        <!--DATE-->
        <p>Your last visit to the clinic was on <?php echo date_format($results[0], 'dS M, Y'); ?>, seen by Dr.<?php echo $results[1]?>.</p>
      
</div>
 
</div>
</body>