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
			search_doctor();	
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
        <form method="post" action="edit_doctor.php" >
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
            $doctor_set = $result;
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
        </form>
        </div>
    <br> <br>
     <?php            }}?>
    <h2>                 
        Search Doctor<br/> <br/>
    </h2>            
    <form method="post" action="search_doctors.php" >
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
                    Specialization:
                </td>
                <td>
                    <input name="search_spec" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Department:
                </td>
                <td>
                    <input name="search_dep" type="text">
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
