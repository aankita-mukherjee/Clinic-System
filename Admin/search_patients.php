<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../Templates/Admin_Template.php"); ?>
<link href="../stylesheets/TableStyles.css" rel="stylesheet" type="text/css" />

<?php
    if (isset($_POST['back'])) {
        redirect_to("Welcome.php");
    }
    if (isset($_POST['search'])) {
        $errors = array();
        
        $fields_with_lengths = array('search_contact' => 8, 'search_id' => 9);
		foreach($fields_with_lengths as $fieldname => $length ) {
		    if (strlen(trim($_POST[$fieldname])) > $length) { $errors[] = $fieldname . "'s length is out of bound"; }
		}

        if (empty($errors)) {
			// Perform Update	
			search_patient();	
		} else {
			// Errors occurred
			$message = "There were " . count($errors) . " errors in the form.";
		}
    }
?>

<div id="content">
    <?php
        	// output a list of the fields that had errors
			if (!empty($errors)) {
                echo "<blockquote>" . $message . "</blockquote>";
				echo "<blockquote>";
				echo "Please review the following errors:</blockquote><ul>";
				foreach($errors as $error) {
					echo "<li>" . $error . "</li>";
				}
				echo "</ul>";
			}
    ?>

    <?php if (isset($result)) {?>
    <h2>                 
        Search Results<br/> <br/>
    </h2>   
			<?php
            if (!sqlsrv_has_rows($result)) {
                echo "<blockquote> No Result found! </blockquote><br><br>";
            }
            else {
			?>

            <div class="datagrid">            
        <form method="post" action="edit_patient.php" >
                <table>
        <thead>
			<tr>
                <th>Select</th>
                <th>Name</th>
                <th>ID Number</th>
                <th>Contact</th>
                <th>Gender</th>
                <th>Address</th>
                <th>DOB</th>
                <th>Bloodgroup</th>
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
            $patient_set = $result;
            while ($patient = sqlsrv_fetch_array($patient_set)) {
                $id = $patient["id_number"]; 
                $output = "<tr>";
                 $output .= "<td><input type=\"radio\" name=\"patient_id\" value=" . $id . "></td>";
                $output .= "<td>" . $patient["name"] . "</td>";
                $output .= "<td>" . $patient["id_number"] . "</td>";
                $output .= "<td>" . $patient["contact_number"] . "</td>";
                $output .= "<td>" . $patient["gender"] . "</td>";
                $output .= "<td>" . $patient["address"] . "</td>";
                $output .= "<td>" . date_format($patient['date_of_birth'], 'd-M-Y') . "</td>";
                $output .= "<td>" . $patient["blood_group"] . "</td>";
                $output .= "</tr>";
                echo $output;
            }
        ?>
                        <tr><td></td></tr>
        </tbody>

        </table>
             <input type="hidden" name="from_view" value=TRUE>
        </form>
        </div>
    <br> <br>
     <?php            }}?>
    <h2>                 
        Search Patient<br/> <br/>
    </h2>            
    <form method="post" action="search_patients.php" >
        <table>
            <tr>
                <td>
                    Name:
                </td>
                <td>
                    <input name="search_name" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    ID Number:
                </td>
                <td>
                    <input name="search_id" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Contact:
                </td>
                <td>
                    <input name="search_contact" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Gender:
                </td>
                <td>
                    <input name="search_gender" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Date of birth:
                </td>
                <td>
                    <input name="search_dob" type="text">
                </td>
            </tr>
                        <tr>
                <td>
                    Address:
                </td>
                <td>
                    <input name="search_address" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Bloodgroup:
                </td>
                <td>
                    <input name="search_bg" type="text">
                </td>
            </tr>
        </table>
        <br />
            <div class="button_holder">

                    <input class="button" type="submit" name="search" value="SEARCH"> &nbsp; &nbsp; &nbsp;
                    <input class="button" type="submit" name="back" value="BACK">
            </div>
       
    </form>
    
</div>
