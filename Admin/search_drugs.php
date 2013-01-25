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

        if (empty($errors)) {
			// Perform Update	
			search_drug();	
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
        <form method="post" action="edit_drug.php" >
                <table>
        <thead>
			<tr>
                <th>Select</th>
                <th>Commercial Name</th>
                <th>Manufacturer</th>
                <th>Active Ingredients</th>
                <th>Selling Unit</th>
                <th>Selling Unit Price</th>
                <th>Usage Unit</th>
			</tr>
		</thead>
        <tfoot>

			<tr>
                <td colspan="2"></td>
                <td colspan="2">
                    <input type="submit" name="edit" value="EDIT SELECTED DRUG">
                </td>
			</tr>
		</tfoot>
        <tbody>
        <?php
            $drug_set = $result;
            while ($doctor = sqlsrv_fetch_array($drug_set)) {
                $id_name = $doctor["commercial_name"];
                $id_man = $doctor["manufacturer"];
                $output = "<tr>";
                $output .= "<td><input type=\"radio\" name=\"drug_id\" value=\"" . $id_name.":".$id_man . "\"></td>";
                $output .= "<td><input type=\"hidden\" name=\"cname\" value=\"" . $id_name . "\">" . $doctor["commercial_name"] . "</td>";
                $output .= "<td><input type=\"hidden\" name=\"man\" value=\"" . $id_man . "\">" . $doctor["manufacturer"] . "</td>";
                $output .= "<td>" . $doctor["active_ingredient"] . "</td>";
                $output .= "<td>" . $doctor["selling_unit"] . "</td>";
                $output .= "<td>" . $doctor["selling_unit_price"] . "</td>";
                $output .= "<td>" . $doctor["usage_unit"] . "</td>";

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
        Search Doctor<br/> <br/>
    </h2>            
    <form method="post" action="search_drugs.php" >
        <table>
            <tr>
                <td>
                    Commercial Name:
                </td>
                <td>
                    <input name="search_name" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Manufacturer:
                </td>
                <td>
                    <input name="search_man" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Active Ingredient:
                </td>
                <td>
                    <input name="search_ingre" type="text">
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
