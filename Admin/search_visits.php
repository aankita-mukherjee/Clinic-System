<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../Templates/Admin_Template.php"); ?>
<link href="../stylesheets/TableStyles.css" rel="stylesheet" type="text/css" />

<?php
    if (isset($_POST['back'])) {
        redirect_to("Welcome.php");
    }
    if (isset($_POST['search'])) {
		$visit_set = search_visit($_POST['search_doctor'], $_POST['search_patient'], $_POST['search_date_from'], $_POST['search_date_to']);	
    }
?>

<div id="content">
    <?php if (isset($visit_set)) {?>
    <h2>                 
        Search Results<br/> <br/>
    </h2>   
			<?php
            if (!sqlsrv_has_rows($visit_set)) {
                echo "<blockquote> No Result found! </blockquote><br><br>";
            }
            else {
			?>

            <div class="datagrid">            
        <form method="post" action="view_visit.php" >
                <table>
        <thead>
			<tr>
                <th>Select</th>
                <th>Doctor</th>
                <th>Patient</th>
                <th>Date</th>
			</tr>
		</thead>
        <tfoot>

			<tr>
                <td colspan="2"></td>
                <td colspan="2">
                    <input type="submit" name="edit" value="VIEW SELECTED VISIT">
                </td>
			</tr>
		</tfoot>
        <tbody>
        <?php
            while ($visit = sqlsrv_fetch_array($visit_set)) {
                $output = "<tr>";
                $output .= "<td><input type=\"radio\" name=\"datetime\" value=\"" . date_format($visit["datetime"], 'Y-m-d\TH:i:s') . "\"></td>";
                $output .= "<td>" . $visit["doctor"] . "</td>";
                $output .= "<td>" . $visit["patient"] . "</td>";
                $output .= "<td>" . date_format($visit["datetime"], 'd-m-Y H:i') . "</td>";
                $output .= "</tr>";
                echo $output;
            }
        ?>
        <tr><td></td></tr>
        </tbody>
        </table>
        </form>
        </div>
    <br> <br>
     <?php            }}?>
    <h2>                 
        Search Visit<br/> <br/>
    </h2>            
    <form method="post" action="search_visits.php" >
        <table>
            <tr>
                <td>
                    From:
                </td>
                <td>
                    <input name="search_date_from" type="datetime">
                </td>
            </tr>
            <tr>
                <td>
                    To:
                </td>
                <td>
                    <input name="search_date_to" type="datetime">
                </td>
            </tr>
            <tr>
                <td>
                    Patient:
                </td>
                <td>
                    <input name="search_patient" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    Doctor:
                </td>
                <td>
                    <input name="search_doctor" type="text">
                </td>
            </tr>
        </table>
        <br />
            <div class="button_holder">
                    <input class="button" type="submit" name="search" value="SEARCH"> &nbsp; &nbsp; &nbsp;
                    <input class="button" type="submit" name="back" value="BACK">
            </div>
        
    </form>
    
</div>
