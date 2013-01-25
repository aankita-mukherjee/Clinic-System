<?php include("../Templates/Patients_Template.php"); ?>

<body>
    <div id="content">
	<?php
        $query = "UPDATE patient SET address=(?), contact_number=(?), blood_group=(?) WHERE id_Number=(?)";
        $params = array($_POST['address'], $_POST['contact'], $_POST['bloodgrp'], $patient_id);
        $query_results = sqlsrv_query($conn, $query, $params);
        
        $results = sqlsrv_rows_affected($query_results);

        if($results === FALSE)
            echo "Couldn't save! :(";
        else
            echo "<meta http-equiv=\"REFRESH\" content=\"0;url=home.php\"></HEAD>";
        
 	?>
    </div>
</div>
</body>
