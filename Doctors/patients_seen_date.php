<?php
    include("../Templates/Doctors_Template.php");
    require_once("../includes/connection.php");
    require_once("SQLQueries.php");
    //session_start();
    //$_id = $_SESSION['doctor_id'];
    //$_name = $_SESSION['doctor_name'];
?>

<link href="../stylesheets/TableStyles.css" rel="stylesheet" type="text/css" />
<title>Welcome DR. <?php echo $_name?></title>

<div id="content">
    <h2>Welcome <span style="color:#B29B35;"> DR. <?php echo $_name?></span></h2>
    <blockquote>You can access other useful information from the navigation options on the left.</br </br> Have a good day :)</blockquote>
    <p>Here you can view the patients who visited you on a particular date. The diagnosis will also be included for your reference:</p>

    <FORM name ="input" METHOD="POST" ACTION="<?php echo $_SERVER['PHP_SELF']; ?>" id="date_form" >
                <TABLE >
                <TR>
                    <TH>Visit date</TH>
                <TD>
                    <INPUT TYPE="Date" NAME="visit_date" id="visit_date">
                </TD>
                </TR>
                </TABLE>
                <P><INPUT TYPE="submit" VALUE="Submit" NAME="submit"></P>
            </form>
     
    <div class="datagrid">
	<table>
		<thead>
			<tr>
				<th>Patient Name</th>
				<th>Gender</th>
				<th>Visit Time</th>
				<th>Diagnosis</th>
			</tr>
		</thead>
		<!--<tfoot>
			<tr>
				<td colspan="4">
					<div id="paging">
						<ul><li><a href="#"><span>Previous</span></a></li><li><a href="#" class="active"><span>1</span></a></li><li><a href="#"><span>2</span></a></li><li><a href="#"><span>3</span></a></li><li><a href="#"><span>4</span></a></li><li><a href="#"><span>5</span></a></li><li><a href="#"><span>Next</span></a></li></ul>
					</div>
				</td>
			</tr>
		</tfoot>-->
		<tbody>
            <?php
                if(isset($_POST['submit']))
                {
                    $date = $_POST['visit_date'];
                    $date = date_create_from_format('Y-m-d', $date);
                    echo "List of patients you saw on " . date_format($date, 'dS M, Y');

                $patients_seen = get_seenPatients_date($_id,$date);
                $alt_count = 0;
                if(sqlsrv_has_rows($patients_seen) == FALSE)
                {
                    echo "</br>Sorry you did not see any patient on this date.</br>";
                }
                else
                {
                    while( $row = sqlsrv_fetch_array( $patients_seen) )
                    {
                        //echo date_format($row['visit'], 'd-m-y');
                        if($alt_count%2==0)
                        {
                            echo "<tr> <td>". $row['name']."</td> <td>".$row['gender']."</td> <td>". date_format($row['datetime'], 'dS M, Y')."</td> <td>". $row['diagnosis']."</td> </tr>";
                        }
                        else
                        {
                            echo "<tr class=\"alt\"> <td>". $row['name']."</td> <td>".$row['gender']."</td> <td>". date_format($row['datetime'], 'dS M, Y')."</td> <td>". $row['diagnosis']."</td> </tr>";
                        }
                        $alt_count++;
                    }
                }
                }
                else
                {
                    echo "Please enter a date";
                }
                //sqlsrv_free_stmt($row);
            ?>
		</tbody>
	</table>
</div>

    <!--<p>You can click on the patient name to view more details about him.</p>    required?-->
  </div>
</div>
</body>


<?php
    require_once("../includes/footer.php");
?>
