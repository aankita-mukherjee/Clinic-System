<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../Templates/Admin_Template.php"); ?>
<link href="../stylesheets/TableStyles.css" rel="stylesheet" type="text/css" />


<div id="content">
    <h2>                 
        View patients who have seen all doctors<br/> <br/>
    </h2>
        <form action="Welcome.php" method="post">
            <input type="submit" name="back" value="<< BACK">
        </form>
        <div class="datagrid">            
        <table>
        <thead>
			<tr>
                <th>Name</th>
                <th>ID Number</th>
			</tr>
		</thead>        
        <tbody>
        <?php
            $patient_set = get_patients_all_docs();
            while ($patient = sqlsrv_fetch_array($patient_set)) {
                $output = "<tr>";
                $output .= "<td>" . $patient["name"] . "</td>";
                $output .= "<td>" . $patient["id_number"] . "</td>";
                $output .= "</tr>";
                echo $output;
            }
        ?>
              <tr><td></td></tr>
        </tbody>
        </table>
        </div> 
</div>

<?php include("../includes/footer.php"); ?>
