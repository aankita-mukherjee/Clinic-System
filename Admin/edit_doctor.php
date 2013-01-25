<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../Templates/Admin_Template.php"); ?>

<?php
    if (isset($_POST['back'])) {
        redirect_to("view_doctors.php");
    }
    if (isset($_POST['delete'])) {
        $query = "DELETE FROM doctor WHERE id_number = '" . $_POST['doctor_id'] . "';";
				$result = sqlsrv_query($conn, $query);
				if (sqlsrv_rows_affected($result) == 1) {
					// Success
					$message = "Doctor with ID {$_POST['doctor_id']} was successfully removed from database.";
				} else {
					// Failed
					$message = "The delete failed.";
					$message .= "<br />". sqlsrv_error();
				}
    } elseif (isset($_POST['edit'])) {

			$errors = array();

			$required_fields = array('new_name', 'new_contact', 'new_spec', 'new_dep');
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
				$id = $_POST['doctor_id'];
				$name = $_POST['new_name'];
				$contact = $_POST['new_contact'];
				$specialization = $_POST['new_spec'];
                $department = $_POST['new_dep'];
				
				$query = "UPDATE doctor SET 
							name = '" . $name . "', 
							contact_number ='" . $contact . "', 
							specialization ='" . $specialization . "' ,
                            department ='" . $department . "' 
						WHERE id_number = '" . $id . "';";
				$result = sqlsrv_query($conn, $query);
				if (sqlsrv_rows_affected($result) == 1) {
					// Success
					$message = "Doctor's information was successfully updated.";
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

<?php if (!isset($_POST['delete'])) { find_selected_doc(); } ?>

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
        Edit Doctor: <?php echo $selected_doc["name"]?><br/> <br/>
    </h2>            
    <form method="post" action="edit_doctor.php" >
        <table>
            <tr>
                <td>
                    Name:
                </td>
                <td>
                    <input value="<?php  echo $selected_doc["name"]; ?>" name="new_name" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    ID Number:
                </td>
                <td>
                    <?php  echo $selected_doc["id_number"]; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Contact:
                </td>
                <td>
                    <input value="<?php  echo $selected_doc["contact_number"]; ?>" name="new_contact" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Specialization:
                </td>
                <td>
                    <input value="<?php  echo $selected_doc["specialization"]; ?>" name="new_spec" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Department:
                </td>
                <td>
                    <input value="<?php  echo $selected_doc["department"]; ?>" name="new_dep" type="text">
                </td>
            </tr>
        </table>
        <br />
            <div class="button_holder">
                    <input class="button" type="submit" name="edit" value="UPDATE RECORD"> &nbsp; &nbsp; &nbsp;
                    <input class="button" type="submit" name="delete" value="DELETE RECORD"> &nbsp; &nbsp; &nbsp;
                    <input class="button" type="submit" name="back" value="DISCARD CHANGE">
                    <input class="button" type="hidden" name="doctor_id" value="<?php  echo $selected_doc["id_number"]; ?>">
            </div>
        
    </form>
    
</div>

<?php include("includes/footer.php"); ?>