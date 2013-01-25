<?php
    include("../Templates/Patients_Template.php");
?>

<title>Doctors</title>
<div id="content">
     <h2>List of doctors not seen...</h2><br /> <br />
    <?php
        //List of all doctors not visited
        $query_docs = "SELECT DISTINCT d.name, d.contact_number, d.department, d.specialization FROM doctor d, visit v WHERE v.patient=(?) AND d.id_number NOT IN (SELECT doctor FROM visit)";      
        $param = array($patient_id);
        $result = sqlsrv_query($conn, $query_docs, $param);
        if(!sqlsrv_has_rows($result)) {
            die( "No doctors not seen");
        }

    ?>   
    
    <div class="datagrid">
        <table id="doctors" cellpadding="5">
            <thead>
            <tr>
                <th>Name</th>
                <th>Contact</th>
                <th>Department</th>
                <th>Specialization</th>
            </tr>
            </thead>
            <tbody>
            <?php
                while($row = sqlsrv_fetch_array( $result)) {
                   echo "<tr class=\"alt\"><td>" . $row[0] ."</td> <td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] ."</td></tr>";
               
                }

            ?>
            </tbody>
        </table>
    </div>

</div>
</body>
