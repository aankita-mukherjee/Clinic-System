<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../Templates/Admin_Template.php"); ?>

<?php
    if (isset($_POST['back'])) {
        redirect_to("Welcome.php");
    }
    if (isset($_POST['new_patient'])) {
        redirect_to("add_patient.php");
    }
    if (isset($_POST['add'])) {
			$errors = array();

			if (empty($errors)) {
				// Perform Update
				$patient = $_POST['patient'];
				$doctor = $_POST['doctor'];
                $date = $_POST['date'];

				$query = "INSERT INTO visit(doctor,patient,datetime) VALUES (
                            '". $doctor ."',
							'" . $patient . "', 
							'" . $date . "')";
				$result = sqlsrv_query($conn, $query);
                //echo $query;
				
                if (sqlsrv_rows_affected($result) == 1) {
					// Success
					$message = "New visit was successfully added.";
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
        Add New Visit<br/> <br/>
    </h2>            
    <form method="post" action="add_visit.php" >
        <table>
            <tr>
                <td>
                    Date:
                </td>
                <td>
                    <?php 
                        $date = new DateTime(null, new DateTimeZone('Asia/Singapore'));
                        echo $date->format('Y-M-d H:i:s');
                    ?>

                </td>
            </tr>
            <tr>
                <td>
                    Patient id:
                </td>
                <td>
                    <select name="patient">
                        <?php
                            $all_patients = get_all_patients();
                            while($patient = sqlsrv_fetch_array($all_patients)) {
                                echo "<option value=\"".$patient["id_number"]."\">".$patient["name"]."&nbsp; &nbsp; &nbsp; ".$patient["id_number"]."</option>";
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Doctor id:
                </td>
                <td>
                    <select name="doctor">
                        <?php
                            $all_doctors = get_all_doctors();
                            while($doctor = sqlsrv_fetch_array($all_doctors)) {
                                echo "<option value=\"".$doctor["id_number"]."\">".$doctor["name"]."&nbsp; &nbsp; &nbsp; ".$doctor["id_number"]."</option>";
                            }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
        <br />
            <div class="button_holder">
                    <input class="button" type="submit" name="add" value="ADD VISIT"> &nbsp; &nbsp; &nbsp;
                    <input class="button" type="submit" name="back" value="DISCARD"> &nbsp; &nbsp; &nbsp;
                    <input class="button" type="submit" name="new_patient" value="NEW PATIENT">
            </div>
                            <input type="hidden" name="date" value="<?php echo $date->format('Y-m-d H:i:s');?>">
    </form>
    
</div>

<?php include("includes/footer.php"); ?>