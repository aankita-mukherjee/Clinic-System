<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../Templates/Admin_Template.php"); ?>

<?php
    if (isset($_POST['back'])) {
        redirect_to("view_drugs.php");
    }
    if (isset($_POST['delete'])) {
        $id_data = explode(":", $_POST['drug_id']);

        $query = "DELETE FROM drug WHERE commercial_name = '" . $id_data[0] . "' AND manufacturer = '". $id_data[1] ."';";
				$result = sqlsrv_query($conn, $query);
				if (sqlsrv_rows_affected($result) == 1) {
					// Success
					$message = "Drug {$id_data[0]} was successfully removed from database.";
				} else {
					// Failed
					$message = "The delete failed.";
					$message .= "<br />". sqlsrv_error();
				}
    } elseif (isset($_POST['edit'])) {

			$errors = array();

            $required_fields = array('new_ing', 'new_unit', 'new_price', 'new_usage');
			foreach($required_fields as $fieldname) {
				if (!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) { 
					$errors[] = $fieldname . "is required!"; 
				}
			}
			
			if (empty($errors)) {
				// Perform Update
                $id_data = explode(":", $_POST['drug_id']);
				$name = $id_data[0];
				$man = $id_data[1];
				$ing = $_POST['new_ing'];
				$unit = $_POST['new_unit'];
                $price = $_POST['new_price'];
                $usage = $_POST['new_usage'];
				$query = "UPDATE drug SET  
							active_ingredient ='" . $ing . "', 
							selling_unit ='" . $unit . "' ,
                            selling_unit_price ='" . $price . "' ,
                            usage_unit ='" . $usage . "' 
						WHERE commercial_name = '" . $name . "' AND manufacturer = '". $man ."';";
				$result = sqlsrv_query($conn, $query);
				if (sqlsrv_rows_affected($result) == 1) {
					// Success
					$message = "Drug information was successfully updated.";
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

<?php if (!isset($_POST['delete'])) { 
     $selected_drug = find_selected_drug(); 
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
        Edit Drug: <?php echo $selected_drug["commercial_name"].":".$selected_drug["manufacturer"]?><br/> <br/>
    </h2>            
    <form method="post" action="edit_drug.php" >
        <table>
            <tr>
                <td>
                    Commerical Name:
                </td>
                <td>
                   <?php  echo $selected_drug["commercial_name"]; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Manufacturer:
                </td>
                <td>
                    <?php  echo $selected_drug["manufacturer"]; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Active Ingredient:
                </td>
                <td>
                    <input value="<?php  echo $selected_drug["active_ingredient"]; ?>" name="new_ing" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Selling Unit:
                </td>
                <td>
                    <input value="<?php  echo $selected_drug["selling_unit"]; ?>" name="new_unit" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Selling Unit Price:
                </td>
                <td>
                    <input value="<?php  echo $selected_drug["selling_unit_price"]; ?>" name="new_price" type="text">
                </td>
            </tr>
             <tr>
                <td>
                    Usage Unit:
                </td>
                <td>
                    <input value="<?php  echo $selected_drug["usage_unit"]; ?>" name="new_usage" type="text">
                </td>
            </tr>
        </table>
        <br />
            <div class="button_holder">
                    <input class="button" type="submit" name="edit" value="UPDATE RECORD"> &nbsp; &nbsp; &nbsp;
                    <input class="button" type="submit" name="delete" value="DELETE RECORD"> &nbsp; &nbsp; &nbsp;
                    <input class="button" type="submit" name="back" value="DISCARD CHANGE">
                    <input class="button" type="hidden" name="drug_id" value="<?php  echo $selected_drug["commercial_name"].":".$selected_drug["manufacturer"]; ?>">
            </div>
        
    </form>
    
</div>

<?php include("includes/footer.php"); ?>