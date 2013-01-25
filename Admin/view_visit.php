<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../Templates/Admin_Template.php"); ?>
<link href="../stylesheets/TableStyles.css" rel="stylesheet" type="text/css" />

<?php
    $visit = get_visit($_POST['datetime']);
    $prescription_set = get_prescription($visit);
?>

<div id="content">
    <h2>                 
        View visit<br/> <br/>
    </h2>
       
        <div class="datagrid">            
        <table>
            <tr>
                <th>Doctor</th>
                <td><?php echo get_doc_name($visit['doctor']); ?></td>
            </tr>
            <tr>
                <th>Patient</th>
                <td><?php echo get_patient_name($visit['patient']); ?></td>
            </tr>
            <tr>
                <th>Visit Time</th>
                <td><?php echo date_format($visit['datetime'], 'd-M-Y  H:i'); ?></td>
            </tr>
            <tr>
                <th>Diagnosis</th>
                <td><?php echo date_format($visit['datetime'], 'd-M-Y  H:i'); ?></td>
            </tr>
        </table>

        <h3>Drugs prescribed</h3>
        <table>
        <thead>
		<tr>
                <th>Drug</th>
                <th>Days</th>
                <th>Times/day</th>
                <th>Amount/time</th>
            <th>Instructions</th>
                <th>Unit price</th>
                <th>Total</th>
            
		</tr>
		</thead>
        <?php
            $total = 0;
            while ($prescription = sqlsrv_fetch_array($prescription_set)) {
                $price = get_price($prescription["drug"], $prescription["manufacturer"]);
                $sum = $price * $prescription["period"] *  $prescription["frequency"] * $prescription["dosage"];
                $output = "<tr>";
                $output .= "<td>" . $prescription["drug"] . "</td>";
                $output .= "<td>" . $prescription["period"] . "</td>";
                $output .= "<td>" . $prescription["frequency"] . "</td>";
                $output .= "<td>" . $prescription["dosage"] . "</td>";
                $output .= "<td>" . $prescription["usage_method"] . ", " . $prescription["other_instruction"] . "</td>";
                $output .= "<td>" . $price . "</td>";
                $output .= "<td>" . $sum . "</td>";
                $output .= "</tr>";
                $total += $sum;
                echo $output;
                            }
        ?>
        </table>
        </div>
        <h3>Amount payable</h3>
        <?php
            echo "SGD " . $total;
        ?>
</div>

<?php include("../includes/footer.php"); ?>