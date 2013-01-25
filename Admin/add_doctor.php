<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../Templates/Admin_Template.php"); ?>

<?php
    if (isset($_POST['back'])) {
        redirect_to("Welcome.php");
    }
    if (isset($_POST['add'])) {
			$errors = array();

			$required_fields = array('new_name', 'new_id', 'new_contact', 'new_spec', 'new_dep');
			foreach($required_fields as $fieldname) {
				if (!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) { 
					$errors[] = $fieldname . " is required!"; 
				}
			}
			$fields_with_lengths = array('new_contact' => 8, 'new_id' => 9);
			foreach($fields_with_lengths as $fieldname => $length ) {
				if (strlen(trim($_POST[$fieldname])) <> $length) { $errors[] = $fieldname . " length is invalid"; }
			}

            $_POST['doctor_id'] = $_POST['new_id'];
            find_selected_doc();
            if (isset($selected_doc)) { $errors[] = "A doctor with the specified ID is already in the database!";}
			
			if (empty($errors)) {
				// Perform Update
				$id = $_POST['new_id'];
				$name = $_POST['new_name'];
				$contact = $_POST['new_contact'];
				$specialization = $_POST['new_spec'];
                $department = $_POST['new_dep'];
				
				$query = "INSERT INTO doctor VALUES (
                            '". $id ."',
							'" . $name . "', 
							'" . $contact . "', 
							'" . $specialization . "' ,
                            '" . $department . "')";
				$result = sqlsrv_query($conn, $query);
                
				if (sqlsrv_rows_affected($result) == 1) {
					// Success
					$message = "Doctor {$name}'s information was successfully added.";
				} else {
					// Failed
					$message = "The add failed.";
					$message .= "<br />". sqlsrv_errors();
				}
				
			} else {
				// Errors occurred
				$message = "There were " . count($errors) . " errors in the form.";
			}
			
		} // end: if (isset($_POST['submit']))
?>


<div id="content"> 
        <?php if (!empty($message)) {
				echo "<p class=\"info\">" . $message . "</p>";
			} ?>
			<?php
			// output a list of the fields that had errors
			if (!empty($errors)) {
				echo "<p class=\"blockquote\">";
				echo "Please review the following errors:<br />";
				foreach($errors as $error) {
					echo " - " . $error . "<br />";
				}
				echo "</p>";
			}
			?>
    <h2>                 
        Add New Doctor<br/> <br/>
    </h2>            
    <form method="post" action="add_doctor.php" >
        <table>
            <tr>
                <td>
                    Name:
                </td>
                <td>
                    <input name="new_name" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    ID Number:
                </td>
                <td>
                    <input name="new_id" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Contact:
                </td>
                <td>
                    <input name="new_contact" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Specialization:
                </td>
                <td>
                    <input name="new_spec" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Department:
                </td>
                <td>
                    <input name="new_dep" type="text">
                </td>
            </tr>
        </table>
        <br />
            <div class="button_holder">
                    <input class="button" type="submit" name="add" value="ADD RECORD"> &nbsp; &nbsp; &nbsp;
                    <input class="button" type="submit" name="back" value="DISCARD">
            </div>
        
    </form>
    
</div>

<?php include("includes/footer.php"); ?>