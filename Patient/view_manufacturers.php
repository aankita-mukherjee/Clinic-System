<?php
    require_once("../Templates/Patients_Template.php");
?>

<title>View Manufacturers of Prescribed Drugs...</title>
<div id="content">
    <?php
        //All manufacturers which produce drug d prescribed to patient

        /*$query = "SELECT d.commercial_name, d.manufacturer, d.active_ingredient, d.usage_unit
                    FROM drug d, prescribe p
                    WHERE p.patient=(?) AND p.drug=d.commercial_name
                    ORDER BY d.commercial_name";*/
 
        //$query = "SELECT d.commercial_name, d.manufacturer, d.active_ingredient, d.usage_unit FROM drug d WHERE d.commercial_name IN (SELECT p.drug FROM prescribe p WHERE p.patient=(?))  ORDER BY d.commercial_name";
         
        $query = "SELECT d.commercial_name, d.manufacturer, d.active_ingredient, d.usage_unit 
                   FROM drug d WHERE d.commercial_name IN (SELECT drug FROM vw_Patient WHERE patient=?) AND d.commercial_name = ANY (SELECT dr.commercial_name FROM drug dr GROUP BY dr.commercial_name HAVING COUNT(*)>1)";
                    
        $params = array($patient_id);
        $query_results = sqlsrv_query($conn, $query, $params);
        if(!$query_results)
			   die("Sorry, no drugs were prescribed to you!");

    ?>

    <div class="datagrid">
    <table id="manufacturers">
        <thead>
            <tr>
                <th>Name</th>
                <th>Manufacturer</th>
                <th>Active Ingredients</th>
                <th>Usage Unit</th>
            </tr>
        </thead>  
        <tbody>
         <?php
          if(sqlsrv_has_rows($query_results)){
              while($row = sqlsrv_fetch_array($query_results))
                echo "<tr class=\"alt\"><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td></tr>";
          
          }   
         ?>
        </tbody>
         
    </table>
    </div>

    
</div>

</div>
</body>

