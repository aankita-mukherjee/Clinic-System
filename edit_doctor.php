<?php require_once("Templates/MainPage_Template.php"); ?>


<div id="content"> 
    <h2>                 
        Edit Doctors <br/> <br/>
    </h2>            
        <table>
            <tr>
                <th>Name</th>
                <th>ID Number</th>
                <th>Contact</th>
                <th>Specialization</th>
                <th>Department</th>
                <td></td>
            </tr>
        <?php
            $doctor_set = get_all_doctors();
            while ($doctor = sqlsrv_fetch_array($doctor_set)) {
                $output = "<tr>";
                $output .= "<td>" . $doctor["name"] . "</td>";
                $output .= "<td>" . $doctor["id_number"] . "</td>";
                $output .= "<td>" . $doctor["contact_number"] . "</td>";
                $output .= "<td>" . $doctor["specialization"] . "</td>";
                $output .= "<td>" . $doctor["department"] . "</td>";
                $output .= "<td> <a class=\"edit\" href=edit_doctor.php?doctor_id=" . $doctor["id_number"] . "\">Edit</a> </td>";
                $output .= "</tr>";
                echo $output;
            }
        ?>
        </table>
    
</div>

<?php include("includes/footer.php"); ?>