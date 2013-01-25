<?php
    
    /*function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed: " . sqlsrv_errors());
		}
	}*/

    function get_doctorInfo($id) {
		global $conn;
		$query = "SELECT * 
				FROM doctor 
				WHERE id_number = ?";
        $params = array($id);
        //echo $id;
		$doctor_info = sqlsrv_query($conn, $query, $params);
		//confirm_query($doctor_info);
		return sqlsrv_fetch_array($doctor_info);
	}

    function get_seenPatients_all($doctor_id) {
		global $conn;
		$query = "SELECT p.name as name, p.gender as gender, v.datetime as visit, v.diagnosis as diagnosis
				FROM visit v, patient p
				WHERE v.doctor = ? AND p.id_number = v.patient";
        $params = array($doctor_id);
		$patient_seen = sqlsrv_query($conn, $query, $params);
		//confirm_query($patient_seen);
		return $patient_seen;
	}

    function get_seenPatients_today($doctor_id) {
		global $conn;
		$query = "SELECT p.name as name, p.gender as gender, v.datetime as visit, v.diagnosis as diagnosis
				FROM visit v, patient p
				WHERE v.doctor = ? AND p.id_number = v.patient AND v.datetime >=CONVERT (date, GETDATE())"; //No need to check less than tomorrow's date coz record for tomrrow will not be there anyway.
        $params = array($doctor_id);
		$patient_seen = sqlsrv_query($conn, $query, $params);
		//confirm_query($patient_seen);
		return $patient_seen;
	}

    function get_seenPatients_date($doctor_id, $curr_date) {
		global $conn;
		$query = "SELECT p.name as name, p.gender as gender, v.datetime as visit, v.diagnosis as diagnosis
				FROM visit v, patient p
				WHERE v.doctor = ? AND p.id_number = v.patient AND v.datetime >=CONVERT (date, ?) AND v.dateTime < CONVERT (date, ?)";      
        
        $curr_date = date_format($curr_date, 'm/d/Y');

        $newDate = new DateTime($curr_date);
        $newDate->add(new DateInterval('P1D')); // P1D means a period of 1 day
        $next_date = $newDate->format('m/d/Y');
        
        //echo "</br>" . $curr_date."</br>".$next_date;
        
        $params = array($doctor_id, $curr_date, $next_date);
		$patient_seen = sqlsrv_query($conn, $query, $params);
		//confirm_query($patient_seen);
		return $patient_seen;
	}

    function get_drugsPrecsibed($doctor_id) {
		global $conn;
		$query = "SELECT DISTINCT d.commercial_name as name, d.manufacturer as manu, d.active_ingredient as ingredient
				FROM drug d, prescribe p
				WHERE p.doctor = ?";
        $params = array($doctor_id);
		$drugs_precribed = sqlsrv_query($conn, $query, $params);
		//confirm_query($drugs_precribed);
		return $drugs_precribed;
	}

    function get_allDrugs() {
		global $conn;
		$query = "SELECT d.commercial_name as name, d.manufacturer as manu, d.active_ingredient as ingredient
				FROM drug d";
		$drugs = sqlsrv_query($conn, $query);
		//confirm_query($drugs);
		return $drugs;
	}

    function get_DisDrugs() {
		global $conn;
		$query = "SELECT DISTINCT d.commercial_name as name, d.active_ingredient as ingredient
				FROM drug d";
		$dis_drugs = sqlsrv_query($conn, $query);
		//confirm_query($dis_drugs);
		return $dis_drugs;
	}

    function isPatientIdCorrect($patient_id) {
		global $conn;
		$query = "SELECT name, date_of_birth, blood_group
                  FROM patient
                  WHERE id_number=?";
        $params= array($patient_id);
		$exists = sqlsrv_query($conn, $query, $params);
		//return sqlsrv_has_rows($exists);
        return ($exists);		
	}

    function get_DrugsbyManu() {
		global $conn;
		$query = "SELECT COUNT(d.commercial_name), d.manufacturer
				FROM drug d
                GROUP BY d.manufacturer";
		$drugs = sqlsrv_query($conn, $query);
		//confirm_query($drugs);
		return $drugs;
	}

    function search_visit($doctor, $patient, $date_from, $date_to) {
        global $conn;
        $and_needed = FALSE;

        $query = "SELECT * FROM visit WHERE ";
                
                if (!empty($doctor)) {$query .= "doctor LIKE '%" . $doctor . "%' "; $and_needed = TRUE; }
                if (!empty($patient)) {
                    if ($and_needed)  $query .= " AND ";
                    $query .= "patient LIKE '%" . $patient . "%'"; 
                    $and_needed = TRUE;
                }
                if (!empty($date_from)) {
                    $date = date_create_from_format('d/m/Y', $date_from);
                    $date_from = $date->format('Y-m-d');
                    if ($and_needed)  $query .= " AND ";
                    $query .= " CONVERT(VARCHAR(25), datetime, 126) >= '" . $date_from . "' ";
                    $and_needed = TRUE; 
                }
                if (!empty($date_to)) {
                    $date = date_create_from_format('d/m/Y', $date_to);
                    $date_to = $date->format('Y-m-d');
                    if ($and_needed)  $query .= " AND ";
                    $query .= " CONVERT(VARCHAR(25), datetime, 126) <= '" . $date_to . "' ";
                }
                
				$result_set = sqlsrv_query($conn, $query);
                confirm_query($result_set);
                echo $query;
            return $result_set;
    }
?>