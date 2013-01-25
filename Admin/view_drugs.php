<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../Templates/Admin_Template.php"); ?>
<link href="../stylesheets/TableStyles.css" rel="stylesheet" type="text/css" />


<div id="content">
    <h2>                 
        View all drugs <br/> <br/>
    </h2>
        <form action="Welcome.php" method="post">
            <input type="submit" name="back" value="<< BACK">
        </form>
        <form action="edit_drug.php" method="post">
        <div class="datagrid">            
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
            $drug_set = get_all_drugs();
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
        </div>
        <input type="hidden" name="from_view" value=TRUE>
        </form>    
</div>

<?php include("../includes/footer.php"); ?>