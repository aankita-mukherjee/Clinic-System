<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../Templates/Admin_Template.php"); ?>
<link href="../stylesheets/TableStyles.css" rel="stylesheet" type="text/css" />


<div id="content">
    <h2>                 
        Number of visits today<br/> <br/>
    </h2>
        <div class="datagrid">            
        <table>
        <thead>
			<tr>
                <th>Today</th>
                <th>Total visit</th>
			</tr>
		</thead>        
        <tbody>
            <tr>
                <td><?php echo date('d-M-Y'); ?></td>
                <td><?php $today_visit = get_visit_today(); echo $today_visit; ?></td>
            </tr>
        </tbody>
        </table>
        </div> 
    <br><br>
    <h2>                 
        Number of doctors seen today<br/> <br/>
    </h2>
        <div class="datagrid">            
        <table>
        <thead>
			<tr>
                <th>Today</th>
                <th>Number of doctors</th>
			</tr>
		</thead>        
        <tbody>
            <tr>
                <td><?php echo date('d-M-Y'); ?></td>
                <td><?php $today_visit = get_doctor_today(); echo $today_visit; ?></td>
            </tr>
        </tbody>
        </table>
        </div>
         <br><br>
    <h2>                 
        Number of different drugs prescribed today<br/> <br/>
    </h2>
        <div class="datagrid">            
        <table>
        <thead>
			<tr>
                <th>Today</th>
                <th>Number of drugs</th>
			</tr>
		</thead>        
        <tbody>
            <tr>
                <td><?php echo date('d-M-Y'); ?></td>
                <td><?php $today_visit = get_drug_today(); echo $today_visit; ?></td>
            </tr>
        </tbody>
        </table>
        </div> 
             <br><br>
    <h2>                 
        Number of patients each doctor seen today<br/> <br/>
    </h2>
        <div class="datagrid">            
        <table>
        <thead>
			<tr>
                <th>Doctor</th>
                <th>Number of patients</th>
			</tr>
		</thead>        
        <tbody>
            <?php
            $patient_set = get_patients_today();
            while ($patient = sqlsrv_fetch_array($patient_set)) {
                $output = "<tr>";
                $output .= "<td>" . get_doc_name($patient["doctor_name"]) . "</td>";
                $output .= "<td>" . $patient["count"] . "</td>";
                $output .= "</tr>";
                echo $output;
            }
            ?>
        </tbody>
        </table>
        </div> 
</div>

<?php include("../includes/footer.php"); ?>
