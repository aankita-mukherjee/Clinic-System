<?php
    require_once("../Templates/Patients_Template.php");
    //session_start();
?>

<title>Past Visits</title>
<div id="content">
    <?php
  
        //Find all visits by patient - display datetime, doctor  
        //$query = "SELECT name, datetime, diagnosis FROM vw_Patient WHERE patient=(?) ORDER BY datetime DESC";

        $query = "SELECT d.name, v.datetime, v.diagnosis FROM visit v, doctor d WHERE patient=(?) AND v.doctor = d.id_number ORDER BY datetime DESC";
        //$query = "SELECT datetime, name FROM vw_Patient WHERE patient=(?) GROUP BY datetime HAVING COUNT(*)>0";
        $params = array($patient_id);
        $query_results = sqlsrv_query($conn, $query, $params);
        if(!$query_results)
			   die("No results found!");

    ?>

    <div class="datagrid"> 
            
                <form method="post" action="visitDetails.php">
                    <table id="inner">
                    <thead>  
                        <tr>
                            <th>Select</th>
                            <th>Date-Time</th>
                            <th>Doctor</th>
                            <th>Diagnosis</th>
                        </tr>
                    </thead>
                    <tfoot>
			            <tr>
                            <td colspan="2"></td>
                            <td colspan="2">
                                <input type="submit" name="edit" value="View Details">
                            </td>
			            </tr>
		            </tfoot>
                    <tbody>
                        <?php
                            $i = 0;
                            $row = sqlsrv_fetch_array($query_results);
                         do {
                                $i = $i+1;
                                echo "<tr class=\"alt\"><td><input type=\"radio\" name=\"details\" value=\"" . $i . "\"></td> <td>" . date_format($row[1], 'dS M, Y') . " </td> <td>" . $row[0] . "</td> <td>" . $row[2] . "</td></tr>";
                                //echo "<tr class=\"alt\"><td><input type=\"submit\" value=\"Details\"></td> <td>" . date_format($row[0], 'dS M, Y') . " </td> <td>" . $row[1] . "</td></tr>";
                          } while($row = sqlsrv_fetch_array($query_results)); 
                          //showData(date_format($firstVal[0], 'dS, M, Y'), $patient_id, $firstVal[1], $firstVal[2]);           
                        ?>
                    </tbody>
             </table>
             </form>
               
    </div>
    
</div>
        
</div>
</body>
