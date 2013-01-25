<?php
    require_once("../Templates/Patients_Template.php");
    //session_start();
?>

<title>Past Visits</title>
<div id="content">
    <?php
        //$patient_id = "G1234567A";
        //Find all visits by patient - display datetime, doctor
        //Make it clickable list
        //Display all details on the right     
        $query = "SELECT  v.datetime, d.name, v.diagnosis FROM visit v, doctor d WHERE patient=(?) AND v.doctor = d.id_number ORDER BY datetime DESC";
        //$query = "SELECT v.datetime, d.name, v.diagnosis FROM visit v, doctor";
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
                                echo "<tr class=\"alt\"><td><input type=\"radio\" name=\"details\" value=\"" . $i . "\"></td> <td>" . date_format($row[0], 'dS M, Y') . " </td> <td>" . $row[1] . "</td> <td>" . $row[2] . "</td></tr>";
                                //echo "<tr class=\"alt\"><td><input type=\"submit\" value=\"Details\"></td> <td>" . date_format($row[0], 'dS M, Y') . " </td> <td>" . $row[1] . "</td></tr>";
                          } while($row = sqlsrv_fetch_array($query_results)); 
                                    
                        ?>
                    </tbody>
             </table>
             </form>
               
    </div>
    
</div>
        
</div>
</body>
