<?php require_once("sessionPatient.php"); ?>
<?php require_once("Includes/connection.php"); ?>
<?php require_once("Includes/functions.php"); ?>
<?php 
    //NO NEED TO LOG IN TWICE
    //if(logged_in()){
      //  redirect_to("../Patient/home.php");
    //}
    ?>
<?php require_once("Templates/MainPage_Template.php"); ?>

       <div id="content">

        
            <div id="para3">
            <?php if (!empty($message)) {
				echo "<p class=\"message\">" . $message . "</p>";
			} ?>
			<?php
			// output a list of the fields that had errors
			if (!empty($errors)) {
				echo "<p class=\"errors\">";
				echo "Please review the following fields:<br />";
				foreach($errors as $error) {
					echo " - " . $error . "<br />";
				}
				echo "</p>";
			}
			?>

            <h2>Please log-in with your ID</h2>
            </br>
            </br>
            <FORM name ="input" METHOD="POST" ACTION="<?php echo $_SERVER['PHP_SELF']; ?>" id="theform" >
                <TABLE >
                <TR>
                    <TH>Login Id</TH>
                <TD>
                    <INPUT TYPE="TEXT" NAME="id" id ="id">
                </TD>
                </TR>
                <TR>
                    <TH>Password:</TH>
                    <TD><INPUT TYPE="PASSWORD" NAME="contact" id="contact"></TD>
                </TR>
                </TABLE>
                <P><INPUT TYPE="SUBMIT" VALUE="Submit" NAME="Submit"></P>
            </form>
        </div>

<?php
    
    //START FORM PROCESSING
    //FORM SUBMITTED
    if(isset($_POST['Submit'])) { 

    //    $errors = array();
    //    $required_fields = array('id','nmbr');
    //    foreach($required_fields as $fieldname) {
				//if (!isset($_POST[$fieldname]) || (empty($_POST[$fieldname]) && $_POST[$fieldname] != 0)) { 
				//	$errors[] = $fieldname . "is required!"; }}

    //$check_id = $_POST['id'];
    //$check_nmbr = $_POST['contact'];

    if($_POST['id']==""||$_POST['contact']=="")
    //if(!isset($_POST['contact']))
    {
        echo "One of the required fields is empty. Please review the log in information.";
        exit(0);
    }

    //}// Remove Later

        /*$fields_with_lengths = array('id' => 8, 'nmbr' => 8);
        foreach($fields_with_lengths as $fieldname => $length ) {
				if (strlen(trim($_POST[$fieldname])) <> $length) 
                    { $errors[] = $fieldname . " length is invalid"; }}*/

                //NO ERRORS IN INPUT
                /*if (empty($errors)) {
                    //CHECK IF VALID USER*/
		            /*$query = "SELECT * ";
		            $query .= "FROM doctor ";
		            $query .= "WHERE id_number=?";
                    $query .= "AND contact_number=?";*/
                    //$curr_date = date_format($curr_date, 'm/d/Y');
                    $query = "SELECT *
                              FROM patient
                              WHERE id_number =? AND contact_number =?";
                    //$query .= "LIMIT 1";
                    
                    //echo $_POST['id'] . "</br>". $_POST['contact']. "</br>";
                    
                    $params = array($_POST['id'], $_POST['contact']);
                    $result = sqlsrv_query($conn, $query, $params);
				    
                    //SUCCESSFULLY LOGGED IN
                    if (sqlsrv_has_rows($result) == TRUE) {
					    //Store all info about doctor in session
                        // -> we don't have to run to the database everytime
                        //we want to retrive some info about logged in doc.
                        
                        $found_user = sqlsrv_fetch_array($result);
                        $_SESSION['id_number'] = $found_user['id_number'];
                        $_SESSION['name'] = $found_user['name'];
                        $_SESSION['gender'] = $found_user['gender'];
                        $_SESSION['contact_number'] = $found_user['contact_number'];
                        $_SESSION['address'] = $found_user['address'];
                        $_SESSION['date_of_birth'] = $found_user['date_of_birth'];
                        $_SESSION['blood_group'] = $found_user['blood_group'];
                        echo $_SESSION['name'] . "</br>". $_SESSION['gender']. "</br>";
                        redirect_to("../Patient/home.php");
				    } 
                    //FAILED TO FIND USER
                    else {
					    //$message = "Login failed.";
					    //$message .= "<br />". sqlsrv_error();
                        echo "Invalid username/password";
				    }
                 }
                 //INPUT ERROR
                 //else { 
                 //    $message = "There were " 
                 //    . count($errors) . " errors in the form.";
                 //}

        //}//END isset($_POST['Submit']
    //else  {  
    //    $id="";
    //    $nmbr=""; 
    //} */
?>

 </div>
</body>

<?php
    require_once("Includes/footer.php");
?>