<?php
    include("../Templates/Doctors_Template.php");
    require_once("../includes/connection.php");
    require_once("SQLQueries.php");
    //session_start();
    //$_id = $_SESSION['id_number'];
    //$_name = $_SESSION['name'];
?>

<link href="../stylesheets/TableStyles.css" rel="stylesheet" type="text/css" />
<title>Welcome DR. <?php echo $_name?></title>

<div id="content">
    <h2>Welcome <span style="color:#B29B35;"> DR. <?php echo $_name?></span></h2>
    <blockquote>You can access other useful information from the navigation options on the left.</br </br> Have a good day :)</blockquote>
    <p>Here are the list of patients who you have seen till date. The diagnosis is also included for your reference:</p>

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
                $patients_seen = get_seenPatients_all($_id);
                $alt_count = 0;
                if(sqlsrv_has_rows($patients_seen) == FALSE)
                {
                    echo "Sorry you have not seen any patient up to date.</br>";
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
