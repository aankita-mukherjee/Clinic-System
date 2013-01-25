<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../Templates/Admin_Template.php"); ?>

<?php
    if (isset($_POST['back'])) {
        redirect_to("Welcome.php");
    }
    if (isset($_POST['add'])) {
			$errors = array();

			$required_fields = array('new_name', 'new_id', 'new_contact', 'new_gender', 'new_address', 'new_dob', 'new_blood');
			foreach($required_fields as $fieldname) {
				if (!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) { 
					$errors[] = $fieldname . " is required!"; 
				}
			}
			$fields_with_lengths = array('new_contact' => 8, 'new_id' => 9);
			foreach($fields_with_lengths as $fieldname => $length ) {
				if (strlen(trim($_POST[$fieldname])) <> $length) { $errors[] = $fieldname . " length is invalid"; }
			}

            $patientExists = check_if_patient_exists($_POST['new_id']);
            if ($patientExists) { $errors[] = "A patient with the specified ID is already in the database!";}
			
			if (empty($errors)) {
				// Perform Update
				$id = $_POST['new_id'];
				$name = $_POST['new_name'];
				$contact = $_POST['new_contact'];
				$gender = $_POST['new_gender'];
                $address = $_POST['new_address'];
                $blood = $_POST['new_blood'];
                $date = $_POST['new_dob'];
                $stamp = strtotime($date);
                $date = date('Y-m-d H:i:s', $stamp);
              
				$query = "INSERT INTO patient VALUES (
                            '". $id ."',
							'" . $name . "',
                            '" . $gender . "', 
							'" . $contact . "', 
							'" . $address . "' ,
                            '" . $date . "' ,
                            '" . $blood . "')";
				$result = sqlsrv_query($conn, $query);
                //echo $query;
                
				if (sqlsrv_rows_affected($result) == 1) {
					// Success
					$message = "Patient {$name}'s information was successfully added.";
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
        Add New Patient<br/> <br/>
    </h2>            
    <form method="post" action="add_patient.php" >
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
                    Gender:
                </td>
                <td>
                    <input name="new_gender" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Address:
                </td>
                <td>
                    <input name="new_address" type="text">
                </td>
            </tr>
             <tr>
                <td>
                    DOB:
                </td>
                <td>
                    <input name="new_dob" type="datetime">
                </td>
            </tr>
                         <tr>
                <td>
                    Blood Group:
                </td>
                <td>
                    <input name="new_blood" type="text">
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