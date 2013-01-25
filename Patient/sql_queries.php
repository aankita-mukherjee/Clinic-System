<?php


function patient_info($patient_id)
{
    global $conn;
    $query = "SELECT * FROM patient WHERE id_number=(?)";
    $params = array($patient_id);
    $query_results = sqlsrv_query($conn, $query, $params);
        if(!$query_results)
			   echo("No results found!");
    // return sqlsrv_fetch_array($query_results);
    return $conn;
}
/*
function patient_lastvisit($patient_id)
{
    global $conn;
    $query = "SELECT d.name FROM visit v, doctor d WHERE v.doctor=d.id_number AND v.patient=(?)";
    $params = array($patient_id);
    $query_results = sqlsrv_query($conn, $query, $params);
        if(!$query_results)
			   die("No results found!");
     return sqlsrv_fetch_array($query_results);
}

function patient_updatedetails($patient_id)
{
    global $conn;
    $query = "UPDATE patient SET address=(?), contact_number=(?), blood_group=(?) WHERE id_Number=(?)";
    $params = array($patient_id);
    $query_results = sqlsrv_query($conn, $query, $params);
        if(!$query_results)
			   die("No results found!");
     return sqlsrv_fetch_array($query_results);
}

function patient_docsseen($patient_id)
{
    global $conn;
    $query = "SELECT d.name, d.contact_number, d.department, COUNT(v.doctor) FROM doctor d, visit v WHERE v.patient=(?) AND v.doctor=d.id_number GROUP BY d.name, d.contact_number, d.department";
    $params = array($patient_id);
    $query_results = sqlsrv_query($conn, $query, $params);
        if(!$query_results)
			   die("No results found!");
     return sqlsrv_fetch_array($query_results);
}

function patient_docsnotseen($patient_id)
{
    global $conn;
    $query = "SELECT d.name, d.contact_number, d.department, d.specialization FROM doctor d, visit v WHERE v.patient=(?) AND d.id_number NOT IN (SELECT doctor FROM visit)";
    $params = array($patient_id);
    r$query_results = sqlsrv_query($conn, $query, $params);
        if(!$query_results)
			   die("No results found!");
     return sqlsrv_fetch_array($query_results);
}

function connectDB($query, $params)
{
     global $conn;
     $query_results = sqlsrv_query($conn, $query, $params);
        if(!$query_results)
			   die("No results found!");
        
     return sqlsrv_fetch_array($query_results);*/
}
?>

