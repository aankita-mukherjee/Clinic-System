<?php
    
 //   function confirm_query($result_set) {
	//	if (!$result_set) {
	//		die("Database query failed: " . sqlsrv_errors());
	//	}
	//}

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
		$query = "SELECT *
				  FROM vw_Doctor_Patient
				  WHERE doctor = ?";

        $params = array($doctor_id);
		$patient_seen = sqlsrv_query($conn, $query, $params);
		//confirm_query($patient_seen);
        if($patient_seen==FALSE)
        {
            echo "Some error in procedure";
        }
		return $patient_seen;
	}

    function get_seenPatients_today($doctor_id) {
		global $conn;      		
        $query = "EXEC Patients_Seen @doctor_id =?";
        $params = array($doctor_id);
        $patient_seen = sqlsrv_query($conn, $query, $params);
		//confirm_query($patient_seen);
		return $patient_seen;
	}

    function get_seenPatients_date($doctor_id, $curr_date) {
		global $conn;
        
        $query = "EXEC Patients_Seen @doctor_id =?, @StartDate=?";
        $curr_date = date_format($curr_date, 'm/d/Y');
        $params = array($doctor_id, $curr_date);
		$patient_seen = sqlsrv_query($conn, $query, $params);
		//confirm_query($patient_seen);
		return $patient_seen;
	}

    function get_drugsPrecsibed($doctor_id) {
		global $conn;

        //Distict coz a doctor might have precribed a drug more than once. So we do not want to display that.
		$query = "SELECT DISTINCT drug, manufacturer, active_ingredient
				  FROM vw_Doctor_Drug
				  WHERE doctor = ?";
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

    function isPatientIdCorrect($patient_id, $doctor_id) {
		global $conn;
		$query = "SELECT p.name, p.date_of_birth, p.blood_group, v.datetime, p.id_number
                  FROM patient p, visit v
                  WHERE p.id_number=? AND v.patient = p.id_number AND v.doctor=? AND v.diagnosis iS NULL AND v.datetime >=CONVERT (date, GETDATE())";
        $params= array($patient_id, $doctor_id);
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

    function patient_maxVisits($doctor_id) {
		global $conn;

        // So many group by's coz we want to shown multiple information and when we use group by SELECT clasue can only have group by attributes.
        $query = "SELECT patient, name, gender, COUNT(*)
                  FROM vw_Doctor_Patient
                  WHERE doctor =?
                  GROUP BY patient, name, gender
                  HAVING COUNT(*) >= ALL(
                                         SELECT COUNT(*)
                                         FROM vw_Doctor_Patient v2
                                         WHERE v2.doctor = ?
                                         GROUP BY patient)";
        $params= array($doctor_id, $doctor_id);
		$maxPatient = sqlsrv_query($conn, $query, $params);
		//confirm_query($drugs);
		return $maxPatient;
	}

    //Returns the manufacture's of the given drugs
    function get_DrugsManu($drug_name) {
		global $conn;
		$query = "SELECT d.manufacturer
				FROM drug d
                WHERE d.commercial_name =?";
        $params= array($drug_name);
		$drugs = sqlsrv_query($conn, $query, $params);
		//confirm_query($drugs);
		return $drugs;
	}

    function drugs_maxPrescribed($doctor_id) {
		global $conn;
		$query = "SELECT drug, manufacturer, active_ingredient, COUNT(*)
				  FROM vw_Doctor_Drug
                  WHERE doctor = ?
                  GROUP BY drug, manufacturer, active_ingredient
                  HAVING COUNT(*) >= ALL(
                                        SELECT COUNT(*)
                                        FROM vw_Doctor_Drug
                                        WHERE doctor = ?
                                        GROUP BY drug)"; // So many group by's coz we want to shown multiple information and when we use group by SELECT clasue can only have group by attributes.
        $params= array($doctor_id, $doctor_id);
		$drugMax = sqlsrv_query($conn, $query, $params);
		//confirm_query($drugs);
		return $drugMax;
    }

    function patient_sortVisits($doctor_id) {
		global $conn;
		$query = "SELECT patient, name, gender, COUNT(*)
                  FROM vw_Doctor_Patient
                  WHERE doctor =?
                  GROUP BY patient, name, gender
                  ORDER BY Count(*) DESC";
        $params = array($doctor_id);
		$patient_seen = sqlsrv_query($conn, $query, $params);
		//confirm_query($patient_seen);
		return $patient_seen;
        }