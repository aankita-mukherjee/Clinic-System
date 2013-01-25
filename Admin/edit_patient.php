<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../Templates/Admin_Template.php"); ?>

<?php
    if (isset($_POST['back'])) {
        redirect_to("view_patients.php");
    }
    if (isset($_POST['delete'])) {
        $query = "DELETE FROM patient WHERE id_number = '" . $_POST['patient_id'] . "';";
				$result = sqlsrv_query($conn, $query);
                //echo $query;
				if (sqlsrv_rows_affected($result) == 1) {
					// Success
					$message = "Patient with ID {$_POST['patient_id']} was successfully removed from database.";
				} else {
					// Failed
					$message = "The delete failed.";
					$message .= "<br />". sqlsrv_error();
				}
    } elseif (isset($_POST['edit'])) {

			$errors = array();

            $required_fields = array('new_name', 'new_contact', 'new_gender', 'new_address', 'new_dob', 'new_blood');
			foreach($required_fields as $fieldname) {
				if (!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) { 
					$errors[] = $fieldname . "is required!"; 
				}
			}
			$fields_with_lengths = array('new_contact' => 8);
			foreach($fields_with_lengths as $fieldname => $length ) {
				if (strlen(trim($_POST[$fieldname])) <> $length) { $errors[] = $fieldname . " length is invalid"; }
			}
			
			if (empty($errors)) {
				// Perform Update
				$id = $_POST['patient_id'];
				$name = $_POST['new_name'];
				$contact = $_POST['new_contact'];
				$gender = $_POST['new_gender'];
                $address = $_POST['new_address'];
                $dob = $_POST['new_dob'];
				$blood = $_POST['new_blood'];
				$query = "UPDATE patient SET 
							name = '" . $name . "', 
							contact_number ='" . $contact . "', 
							gender ='" . $gender . "' ,
                            date_of_birth ='" . $dob . "' ,
                            blood_group ='" . $blood . "' ,
                            address ='" . $address . "' 
						WHERE id_number = '" . $id . "';";
				$result = sqlsrv_query($conn, $query);
				if (sqlsrv_rows_affected($result) == 1) {
					// Success
					$message = "Patients's information was successfully updated.";
				} else {
					// Failed
					$message = "The update failed.";
					$message .= "<br />". sqlsrv_error();
				}
				
			} else {
				// Errors occurred
				$message = "There were " . count($errors) . " errors in the form.";
			}
			
		} // end: if (isset($_POST['submit']))
?>

<?php if (!isset($_POST['delete'])) { $selected_patient = find_selected_patient(); 
 } ?>

<div id="content">
    <div id="para3">
        <?php
        if (!isset($_POST['from_view'])) { 
            if (!empty($message)) {
				echo "<p class=\"info\">" . $message . "</p>";
			} ?>
			<?php
			// output a list of the fields that had errors
			if (!empty($errors)) {
				echo "<p class=\"info\">";
				echo "Please review the following errors:<br />";
				foreach($errors as $error) {
					echo " - " . $error . "<br />";
				}
				echo "</p>";
			}
        }
			?>
    </div> 
    <h2>                 
        Edit Patient: <?php echo $selected_patient["name"]?><br/> <br/>
    </h2>            
    <form method="post" action="edit_patient.php" >
        <table>
            <tr>
                <td>
                    Name:
                </td>
                <td>
                    <input value="<?php  echo $selected_patient["name"]; ?>" name="new_name" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    ID Number:
                </td>
                <td>
                    <?php  echo $selected_patient["id_number"]; echo $_POST['patient_name']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Contact:
                </td>
                <td>
                    <input value="<?php  echo $selected_patient["contact_number"]; ?>" name="new_contact" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Gender:
                </td>
                <td>
                    <input value="<?php  echo $selected_patient["gender"]; ?>" name="new_gender" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Address:
                </td>
                <td>
                    <input value="<?php  echo $selected_patient["address"]; ?>" name="new_address" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    DOB:
                </td>
                <td>
                    
                    
                    <input value="<?php echo date_format($selected_patient["date_of_birth"], 'Y-m-d')?>" name="new_dob" type="date">
                </td>
            </tr>
             <tr>
                <td>
                    Blood Group:
                </td>
                <td>
                    <input value="<?php  echo $selected_patient["blood_group"]; ?>" name="new_blood" type="text">
                </td>
            </tr>
        </table>
        <br />
            <div class="button_holder">
                    <input class="button" type="submit" name="edit" value="UPDATE RECORD"> &nbsp; &nbsp; &nbsp;
                    <input class="button" type="submit" name="delete" value="DELETE RECORD"> &nbsp; &nbsp; &nbsp;
                    <input class="button" type="submit" name="back" value="DISCARD CHANGE">
                    <input class="button" type="hidden" name="patient_id" value="<?php  echo $selected_patient["id_number"]; ?>">
            </div>
        
    </form>
    
</div>

<?php include("includes/footer.php"); ?>