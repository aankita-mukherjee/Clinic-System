<?php
    header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found', true, 404);
    require_once("../sessionAdmin.php"); 
    confirm_logged_in();
?>

<link href="../stylesheets/MainStyle.css" rel="stylesheet" type="text/css" />
<body>
<div id="container">
    <div id="banner">
   
  </div>
  <div id="navcontainer">
    <ul id="navlist">
      <li id="active"><a id="current" href="../Admin/Welcome.php">My Details</a></li>
      <li><a href="../logout.php">Log out</a></li>
    </ul>
  </div>
  <div id="sidebar">
    <h2>Basic tasks</h2>
    <div class="navlist">
      <ul>
        <li><a href="add_patient.php">Add Patient</a></li>
        <li><a href="search_patients.php">Search Patients</a></li>
        <li><a href="view_patients.php">View all Patients</a></li> 
        <li><a href="add_visit.php">Add Visit</a></li>
        <li><a href="search_visits.php">Search Visit</a></li>
        <li><a href="add_drug.php">Add Drug</a></li>
        <li><a href="search_drugs.php">Search Drug</a></li>
        <li><a href="view_drugs.php">View all Drugs</a></li> 
        <li><a href="add_doctor.php">Add Doctor</a></li>
        <li><a href="search_doctors.php">Search Doctors</a></li>
        <li><a href="view_doctors.php">View all Doctors</a></li>
      </ul>
    </div>
    <h2>Other functions</h2>
    <div class="navlist">
      <ul>
        <li><a href="patient_all_docs.php">Patients who have seen all doctors</a></li>
          <li><a href="today_stats.php">Some stats</a></li>
      </ul>
    </div>



  </div>
  <div id="container-foot">
    <div id="footer">
      <p><a href="http://www.free-css.com/">homepage</a> | <a href="mailto:denise@mitchinson.net">contact</a> | &copy; 2007 Anyone | Design by <a href="http://www.mitchinson.net"> www.mitchinson.net</a> | Licensed under a <a rel="license" href="http://creativecommons.org/licenses/by/3.0/">Creative Commons Attribution 3.0 License</a></p>
    </div>
  </div>
