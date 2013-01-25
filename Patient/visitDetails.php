
<?php
    require_once("../Templates/Patients_Template.php");
    //session_start();
?>

<title>Past Visits</title>
<div id="content">
    <a href="visit_list.php"><input type="button" name="cancel" value="Back to Visits"></a><br><br>
    <?php
        $row_num_str = $_POST['details'];
        $row_num = (int) $row_num_str;
     
        $i = 0;
        $i = (int)$i;
        $datetime="test";
        $docName="test";
        $diagnosis="test";
             
        $query = "SELECT d.name, v.datetime, v.diagnosis FROM visit v, doctor d WHERE patient=(?) AND v.doctor = d.id_number ORDER BY datetime DESC";
        //$query = "SELECT name, datetime, diagnosis FROM vw_Patient WHERE patient=(?) ORDER BY datetime DESC";
        $params = array($patient_id);
        $query_results = sqlsrv_query($conn, $query, $params);
        echo (string)sqlsrv_num_rows($query_results);
        while($row = sqlsrv_fetch_array($query_results))
        {   
            $i = $i+1;
            if((int)$i == $row_num)
                {   //echo "Here";
                    $datetime = $row[1];
                    //echo date_format($datetime, 'dS M, Y');
                    $docName = $row[0];
                    $diagnosis = $row[2]; 
                    break;
                }
        }
        

        
        $query = "SELECT drug, manufacturer, period, frequency, dosage, usage_method, other_instruction FROM vw_Patient WHERE patient=(?) AND datetime=CONVERT(datetime, ?)";
        $params = array($patient_id, $datetime);
        $query_results = sqlsrv_query($conn, $query, $params);
        
        if(!sqlsrv_has_rows($query_results))
            die("Sorry, you have no prescriptions");

        $html = "<table><tr><td>Date:</td><td>". date_format($datetime, 'dS M, Y') ."</td></tr><tr><td>Doctor Seen:</td><td>". $docName ."</td></tr><tr><td>Diagnosis:</td><td>" . $diagnosis. "</td></tr></table><br><br>";
        echo $html;

        ?>

        <?php
        $pres = "<div class=\"datagrid\"><table>
                <thead><tr><th>Drug Name</th>
                <th>Manufacturer</th>
                <th>Period</th>
                <th>Freq.</th>
                <th>Dosage</th>
                <th>Usage Method</th>
                <th>Instruction<th></tr>
                </thead>";
        $pres = $pres . "<tbody>";

        $row = sqlsrv_fetch_array($query_results);
               
        do
        {   
            $p = "<tr><td>".$row['drug']."</td><td>".$row['manufacturer']."</td><td>".$row['period']."</td><td>".$row['frequency']."</td><td>".$row['dosage']."</td><td>".$row['usage_method']."</td><td>".$row['other_instruction']."</td></tr>";
            $pres = $pres . $p;
            //echo $p;
        } while($row = sqlsrv_fetch_array($query_results));
        $pres = $pres . "</tbody></table></div>";
        echo $pres;

   ?>
</div>

</div>
</body>

