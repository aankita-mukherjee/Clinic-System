<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../Templates/Admin_Template.php"); ?>

<?php
    if (isset($_POST['back'])) {
        redirect_to("Welcome.php");
    }
    if (isset($_POST['add'])) {
			$errors = array();

			$required_fields = array('new_name', 'new_man', 'new_ing', 'new_unit', 'new_price', 'new_usage');
			foreach($required_fields as $fieldname) {
				if (!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) { 
					$errors[] = $fieldname . " is required!"; 
				}
			}

            $drugExists = check_if_drug_exists($_POST['new_name'], $_POST['new_man']);
            if ($drugExists) { $errors[] = "That drug is already in the database, are you high?!";}
			
			if (empty($errors)) {
				// Perform Update
				$name = $_POST['new_name'];
				$man = $_POST['new_man'];
				$ing = $_POST['new_ing'];
				$unit = $_POST['new_unit'];
                $price = $_POST['new_price'];
                $usage = $_POST['new_usage'];
				
				$query = "INSERT INTO drug VALUES (
                            '". $name ."',
							'" . $man . "',
                            '" . $ing . "', 
							'" . $unit . "', 
							'" . $price . "' ,
                            '" . $usage . "')";
				$result = sqlsrv_query($conn, $query);
                
				if (sqlsrv_rows_affected($result) == 1) {
					// Success
                    $drug_display = $name." ".$man;
					$message = "Drug {$drug_display} information was successfully added.";
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
        Add New Drug<br/> <br/>
    </h2>            
    <form method="post" action="add_drug.php" >
        <table>
            <tr>
                <td>
                    Commercial Name:
                </td>
                <td>
                    <input name="new_name" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Manufacturer:
                </td>
                <td>
                    <input name="new_man" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Active Ingredient:
                </td>
                <td>
                    <input name="new_ing" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Selling Unit:
                </td>
                <td>
                    <input name="new_unit" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Selling Unit Price:
                </td>
                <td>
                    <input name="new_price" type="text">
                </td>
            </tr>
             <tr>
                <td>
                    Usage Unit:
                </td>
                <td>
                    <input name="new_usage" type="text">
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