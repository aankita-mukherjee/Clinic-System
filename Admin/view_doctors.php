<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../Templates/Admin_Template.php"); ?>
<link href="../stylesheets/TableStyles.css" rel="stylesheet" type="text/css" />


<div id="content">
    <h2>                 
        View all doctors <br/> <br/>
    </h2>
        <form action="Welcome.php" method="post">
            <input type="submit" name="back" value="<< BACK">
        </form>
        <form action="edit_doctor.php" method="post">
        <div class="datagrid">            
        <table>
        <thead>
			<tr>
                <th>Select</th>
                <th>Name</th>
                <th>ID Number</th>
                <th>Contact</th>
                <th>Specialization</th>
                <th>Department</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
                <td colspan="2"></td>
                <td colspan="2">
                    <input type="submit" name="edit" value="EDIT SELECTED DOCTOR">
                </td>
			</tr>
		</tfoot>
        
        <tbody>
        <?php
            $doctor_set = get_all_doctors();
            while ($doctor = sqlsrv_fetch_array($doctor_set)) {
                $id = $doctor["id_number"]; 
                $output = "<tr>";
                $output .= "<td><input type=\"radio\" name=\"doctor_id\" value=" . $id . "></td>";
                $output .= "<td>" . $doctor["name"] . "</td>";
                $output .= "<td>" . $doctor["id_number"] . "</td>";
                $output .= "<td>" . $doctor["contact_number"] . "</td>";
                $output .= "<td>" . $doctor["specialization"] . "</td>";
                $output .= "<td>" . $doctor["department"] . "</td>";
                $output .= "</tr>";
                echo $output;
            }
        ?>
              <tr><td></td></tr>
        </tbody>
        </table>
        </div>
        <input type="hidden" name="from_view" value=TRUE>
        </form>    
</div>

<?php include("../includes/footer.php"); ?>