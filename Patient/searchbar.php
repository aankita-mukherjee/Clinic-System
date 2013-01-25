<?php
    require_once("../Templates/Patients_Template.php");
?>

<div id="content">
    <?php
        $drugname = $_POST['txtsearch'];
        if($drugname==NULL) 
            die("Please enter the full or partial name of a drug!");
        else 
            $drugname = "%" . $drugname . "%";
        $query = "SELECT datetime, drug, manufacturer, period, frequency, dosage, usage_method, other_instruction FROM prescribe WHERE patient=(?) AND drug LIKE ?";
        $params = array($patient_id, $drugname);
        $query_results = sqlsrv_query($conn, $query, $params);
        if(!sqlsrv_has_rows($query_results))
            echo("Sorry, this drug wasn't prescribed to you!!");        
    ?>
    <div class="datagrid">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Drug</th>
                    <th>Manufacturer</th>
                    <th>Period</th>
                    <th>Freq.</th>
                    <th>Dosage</th>
                    <th>Usage</th>
                    <th>Instructions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($row = sqlsrv_fetch_array($query_results))
                    //Do something about this datetime
                    echo "<tr><td>".date_format($row['datetime'], 'dS M, Y')."</td><td>".$row['drug']."</td><td>".$row['manufacturer']."</td><td>".$row['period']."</td><td>".$row['frequency']."</td><td>".$row['dosage']."</td><td>".$row['usage_method']."</td><td>".$row['other_instruction']."</td></tr>";               

                ?>
            </tbody>
        </table>
    </div>

</div>
</div>
</body>
