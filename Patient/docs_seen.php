<?php
    include("../Templates/Patients_Template.php");
?>

<title>Doctors</title>
<div id="content">
    <h2>List of doctors seen...</h2><br /><br />
    <?php
         //$patient_id = "G0562934N";
         $query_docs = "SELECT d.name, d.contact_number, d.department, COUNT(v.doctor) FROM doctor d, visit v WHERE v.patient=(?) AND v.doctor=d.id_number GROUP BY d.name, d.contact_number, d.department";
         //$query_docs="SELECT name, contact_number, department, COUNT(*) FROM doctor GROUP BY name, contact_number, department";
         $params = array($patient_id);

        $query_results = sqlsrv_query($conn, $query_docs, $params);
        if(!sqlsrv_has_rows($query_results))
			   die("No doctors seen!");

    ?>   
   
    <div class="datagrid">
        <table id="doctors">
            <thead>
            <tr>
                <th>Doctor Name</th>
                <th>Contact</th>
                <th>Department</th>
                <th>Times visited</th>
            </tr> 
            </thead>
            
            <tbody>      
                <?php
                    while($row = sqlsrv_fetch_array($query_results)) {
                       //echo "<tr> <td> " . $row[0] . " </td> <td>" . $row[1] . "</td> <td>" . $row[2] . "</td> <td>" . $row[3] . "</td></tr>";
                       echo "<tr class=\"alt\"> <td>" . $row[0] . " </td> <td>" . $row[1] . "</td> <td>" . $row[2] . "</td> <td>" . $row[3] . "</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>

</div>
</div>
</body>
