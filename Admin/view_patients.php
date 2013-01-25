<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../Templates/Admin_Template.php"); ?>
<link href="../stylesheets/TableStyles.css" rel="stylesheet" type="text/css" />


<div id="content">
    <h2>                 
        View all patients <br/> <br/>
    </h2>
        <form action="Welcome.php" method="post">
            <input type="submit" name="back" value="<< BACK">
        </form>
        <form action="edit_patient.php" method="post">
        <div class="datagrid">            
        <table>
        <thead>
			<tr>
                <th>Select</th>
                <th>Name</th>
                <th>ID Number</th>
                <th>Gender</th>
                <th>Contact</th>
                <th>Address</th>
                <th>DOB</th>
                <th>Blood Group</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
                <td colspan="2"></td>
                <td colspan="2">
                    <input type="submit" name="edit" value="EDIT SELECTED PATIENT">
                </td>
			</tr>
		</tfoot>
        
        <tbody>
        <?php
            $patient_set = get_all_patients();
            while ($patient = sqlsrv_fetch_array($patient_set)) {
                $id = $patient["id_number"]; 
                $output = "<tr>";
                $output .= "<td><input type=\"radio\" name=\"patient_id\" value=" . $id . "></td>";
                $output .= "<td>" . $patient["name"] . "</td>";
                $output .= "<td>" . $patient["id_number"] . "</td>";
                $output .= "<td>" . $patient["gender"] . "</td>";
                $output .= "<td>" . $patient["contact_number"] . "</td>";
                $output .= "<td>" . $patient["address"] . "</td>";
                $output .= "<td>" . date_format($patient["date_of_birth"], 'dS M, Y') . "</td>";
                $output .= "<td>" . $patient["blood_group"] . "</td>";

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