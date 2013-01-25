<?php
    //require_once("../sessionDoc.php"); 
    //confirm_logged_in();
    include("../Templates/Doctors_Template.php");
    //echo $_id;
    require_once("../Includes/connection.php");
    //echo $_id;
    require_once("SQLQueries.php");
    //echo $_id;
    $doctor_info = get_doctorInfo($_id);
?>

<link href="../stylesheets/TableStyles.css" rel="stylesheet" type="text/css" />
<title>Welcome DR. <?php echo $doctor_info["name"]?></title>
<div id="content">
    <h2>Welcome <span style="color:#B29B35;"> DR. <?php echo $doctor_info["name"]?></span></h2>
    <blockquote>You can begin your work by using the navigation options on the left.</br </br> Have a good day :)</blockquote>
    <p>Here are your details as stored in the hospital system:</p>
    <table cellpadding="3" cellspacing="3" width="100%">
	<tr>
		<th>ID</th>
		<td><?php echo $doctor_info["id_number"]?></td>
	</tr>
	<tr>
		<th>Name</th>
		<td><?php echo $doctor_info["name"]?></td>
	</tr>
	<tr>
		<th>Contact Number</th>
		<td><?php echo $doctor_info["contact_number"]?></td>
	</tr>
	<tr>
		<th>Specialization</th>
		<td><?php echo $doctor_info["specialization"]?></td>
	</tr>
	<tr>
		<th>Department</th>
		<td><?php echo $doctor_info["department"]?></td>
	</tr>
</table>

    <p>You can ask the administrator to change your details if you find any discrepancies.</p>
  </div>
</div>
</body>

<?php
    require_once("../includes/footer.php");
?>