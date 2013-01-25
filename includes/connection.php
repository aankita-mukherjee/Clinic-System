<?php
//<require_once("includes/constants.php");
   $serverName = "tcp:i58l2xtq7j.database.windows.net,1433";
   $userName = 'group16@i58l2xtq7j';
   $userPassword = 'cs2102DB';
   $dbName = "clinicSystem";

   $connectionInfo = array("Database"=>$dbName, "UID"=>$userName, "PWD"=>$userPassword, "MultipleActiveResultSets"=>true);
   //$connectionInfo = array("Database"=>$DB_NAME, "UID"=>$DB_USER, "PWD"=>$DB_PASS, "MultipleActiveResultSets"=>true);

   sqlsrv_configure('WarningsReturnAsErrors', 0);
   $conn = sqlsrv_connect( $serverName, $connectionInfo);
   if($conn === false)
   {
     FatalError("Failed to connect...");
   }

   //phpinfo();

?>

