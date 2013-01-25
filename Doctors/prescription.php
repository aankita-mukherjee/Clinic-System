<?php
    include("../Templates/Doctors_Template.php");
    require_once("../includes/connection.php");
    require_once("SQLQueries.php");

    $patient = isPatientIdCorrect($_POST['visit_id'], $_id);
    //$patient_info = sqlsrv_fetch_array($patient);

    //if(!isset($_POST['visit_id'])) //|| !sqlsrv_has_rows($patient))
    //{
    //    $location ="welcome.php";
    //    header("Location: {$location}");
    //}

    if(!isset($_SESSION['patient_info']) || isset($_POST['visit_id'])) 
    {
        $patient_info = sqlsrv_fetch_array($patient);
        $_SESSION['patient_info'] = $patient_info;
    }
    else
    {
        $patient_info = $_SESSION['patient_info'];
    }
?>

<?php
    //Commit the information to the precribe table if clicked on Submit. Check if all values have been entered.
    if(isset($_POST['submit']))
    {
        //echo "in Submit";
        // Required field names
        $required = array('period', 'dosage', 'frequency', 'usage_method', 'diagnosis');

        // Loop over field names, make sure each one exists and is not empty
        $error = false;
        foreach($required as $field) {
            if (empty($_POST[$field])) {
                $error = true;
            }
        }

        if ($error) {
            echo "<font color=\"red\">One of the required fields is empty</font> </br>";
        }
        else 
        {
            global $conn;
            //Update visit table with the diagnosis
            $query = "UPDATE visit
				      SET diagnosis=?
                      WHERE diagnosis IS NULL AND doctor=? AND patient=?";

            //$params= array($_POST['diagnosis'], $_id, $_POST['visit_id']);
            $params= array($_POST['diagnosis'], $_id, $patient_info[4]);

		    $insert_visit = sqlsrv_query($conn, $query, $params);
            
            if(sqlsrv_rows_affected($insert_visit) == FALSE)
            {
                //echo "Error in updating visit table with the diagnosis.";
            }

            //Insert drug information into the Prescribe table.
            $query = "INSERT INTO prescribe
				      VALUES(?,?,?,?,?,?,?,?,?,?)";

            //$params= array($_id, $_POST['visit_id'], $patient_info[3], $_POST['drug'],$_POST['manu'],$_POST['period'],$_POST['frequency'],$_POST['dosage'],$_POST['usage_method'],$_POST['other_instruction']);
            $params= array($_id, $patient_info[4], $patient_info[3], $_POST['drug'],$_POST['manu'],$_POST['period'],$_POST['frequency'],$_POST['dosage'],$_POST['usage_method'],$_POST['other_instruction']);
		    $insert_pres = sqlsrv_query($conn, $query, $params);
            
            if(sqlsrv_rows_affected($insert_pres) == FALSE)
            {
                echo "<font color=\"red\">Error in updating prescription table with the drug.</font>";
            }
            else
            {
                echo "<font color=\"green\">Prescription has been added! You can add another precription for this visit if required.</font> </br>";
                $_POST['drug']=NULL;
            }
        }
    }

    //If it is "Add another drug", then commint the previous info and let the page load to allow adding another drug.
?>

<link href="../stylesheets/TableStyles.css" rel="stylesheet" type="text/css" />
<title>Welcome DR. <?php echo $_name?></title>

<div id="content">
    <h2>Welcome <span style="color:#B29B35;"> DR. <?php echo $_name?></span></h2>
    <blockquote>You can access other useful information from the navigation options on the left.</br </br> Have a good day :)</blockquote>

    <?php
        if(!sqlsrv_has_rows($patient) && !isset($_SESSION['patient_info'])) // Drug part to make sure that the doctor is maybe accessing the page to add another drug to the visit.
        {
            echo "<font color=\"red\">Sorry, you have either entered a wrong Patient Id or this patient is not registered for a visit with you.</font>";
            exit(); //Terminate this page over here.
        }

?>
    <p>The patient <?php echo $patient_info['name']?> has an appointment with you.</br>The details of the patient are as follows:</p>

    <table cellpadding="3" cellspacing="3" width="100%">
	<tr>
		<th>Name</th>
		<td><?php echo $patient_info['name']?></td>
	</tr>
	<tr>
		<th>D.O.B</th>
		<td><?php echo date_format($patient_info['date_of_birth'], 'd/M/Y')?></td>
	</tr>
	<tr>
		<th>Blood Group</th>
		<td><?php echo $patient_info['blood_group']?></td>
	</tr>
    <tr>
	    <th>Visit Registration Time</th>
		<td><?php echo date_format($patient_info[3], 'dS M h:i A')?></td>
	</tr>
</table>
    <p>Please add your diagnosis and prescription information.</p>

    <FORM name ="pres_form" METHOD="POST" ACTION="<?php echo $_SERVER['PHP_SELF']; ?>" id="pres_form" >
        <table>
            <tr>
                <td>
                    Patient Id:
                </td>
                <td>
                    <!--<input type="text" name="visit_id" value="<?php echo $_POST['visit_id'];?>" readonly="readonly" id="visit_id">-->
                    <input type="text" name="" value="<?php echo $patient_info[4];?>" readonly="readonly" id="">
                </td>
            </tr>
            <tr>
                <td>
                    Diagnosis:
                </td>
                <td>
                    <textarea class="FormElement" name="diagnosis" id="diagnosis" style="width: fill-available; height: auto;"><?php echo $_POST['diagnosis'];?></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    Drug name:
                </td>
                <td>
                    <select name="drug" id="drug" onchange="document.pres_form.submit();">
                        <?php
                            $all_drugs = get_DisDrugs();
                            while($drug = sqlsrv_fetch_array($all_drugs)) {
                                echo "<option value=\"".$drug[0]."\">".$drug[0]."</option>";
                            }
                            if(!isset($_POST['drug']))
                            {
                                exit(); //Only show till here intially. After the drug is selected, refresh to show the manufacturer list and other info.
                            }
                        ?>
                        <option selected= "selected"><?php echo $_POST['drug'] ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Manufacturer:
                </td>
                <td>
                    <select name="manu" id="manu">
                        <?php
                            $all_manu = get_DrugsManu($_POST['drug']);
                            while($manu = sqlsrv_fetch_array($all_manu)) {
                               echo "<option value=\"".$manu[0]."\">".$manu[0]."</option>";
                            }
                        ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td>
                    No of days to take medicine:
                </td>
                <td>
                    <input type="number" name="period" id="period">
                </td>
            </tr>

            <tr>
                <td>
                    No of pills/time (dosage):
                </td>
                <td>
                    <input type="number" name="dosage" id="dosage">
                </td>
            </tr>

            <tr>
                <td>
                    Times/Day (frequency):
                </td>
                <td>
                    <input type="number" name="frequency" id="frequency">
                </td>
            </tr>

            <tr>
                <td>
                    Intake Method (swallow/dissolve/inject/etc.):
                </td>
                <td>
                    <input type="text" name="usage_method" id="usage_method">
                </td>
            </tr>

            <tr>
                <td>
                    Other instructions:
                </td>
                <td>
                    <textarea class="FormElement" name="other_instruction" id="other_instruction" style="width: fill-available; height: fill-available;"></textarea>
                </td>
            </tr>
        </table>
        <br />
            <div class="button_holder">
                    <!--<input class="button" type="submit" name="add" value="ADD Another Drug"> &nbsp; &nbsp; &nbsp;-->
                    <input class="button" type="submit" name="submit" value="Submit"> &nbsp; &nbsp; &nbsp;
            </div>
    </form>

</div>
</body>


<?php
    require_once("../includes/footer.php");
?>
