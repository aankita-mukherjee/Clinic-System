<?php
    header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found', true, 404);
    require_once("../sessionDoc.php"); 
    confirm_logged_in();
    $_id = $_SESSION['id_number'];
    $_name = $_SESSION['name'];
?>

<link href="../stylesheets/MainStyle.css" rel="stylesheet" type="text/css" />
<body>
<div id="container">
    <div id="banner">
   
  </div>
  <div id="navcontainer">
    <ul id="navlist">
      <li id="active"><a id="current" href="Welcome.php">My Details</a></li>
      <li><a href="../logout.php">Log out</a></li>
    </ul>
  </div>
  <div id="sidebar">
    <h2>Functions</h2>
    <div class="navlist">
      <ul>
        <li><a href="patients_seen.php">All Patients seen</a></li>
        <li><a href="patients_seen_today.php">Patients seen today</a></li>
        <li><a href="patients_seen_date.php">Patients seen on particular date</a></li>
        <li><a href="drugs_prescribed.php">Drugs I have prescribed</a></li>
        <li><a href="allDrugs.php">List of All Drugs</a></li> <!--To make sure doctor know the drugs which are in the clinic-->
        <li><a href="distinct_drugName.php">Different Name of Drugs</a></li>
        <li><a href="drugs_byManu.php">Drugs Per Manufacturer</a></li>  <!--Doctor can see and recommend some new one to the admin-->
        <li><a href="drugs_maxPres.php">Drugs with Max. Precriptions</a></li> <!--Most common drug-->
        <li><a href="patient_maxVisit.php">Patient with Max. Visits</a></li> <!--Most frequent visitor-->
        <li><a href="patient_sort.php">Patients Sorting</a></li> <!--Provide options to sorts patients by number of drugs and by number of visits-->
      </ul>
    </div>
    <form action="../Doctors/prescription.php" method="post">
      <fieldset>
      <legend>Add Prescription</legend>
      <div> <span>
        <label for="visit_id"> Patient Id: <img src="../img/search.gif" alt="search" /></label>
        </span> <span>
        <input type="text" value="Registration Id" name="visit_id" title="Text input: search" id="visit_id" size="20" />
        </span> </div>
      </fieldset>
    </form>

      <form action="../Doctors/viewPrescription.php" method="post">
      <fieldset>
      <legend>Search Prescription</legend>
      <div> <span>
        <label for="visit_id"> Patient Id: <img src="../img/search.gif" alt="search" /></label>
        </span> <span>
        <input type="text" value="Registration Id" name="visit_id" title="Text input: search" id="visit_id" size="20" />
        </span> </div>
      </fieldset>
    </form>

      <!--<form action="patient_info.php" method="post">
      <fieldset>
      <legend>Search Patient</legend>
      <div> <span>
        <label for="patient_id"> Patient Id: <img src="../img/search.gif" alt="search" /></label>
        </span> <span>
        <input type="text" value="Registration Id" name="patient_id" title="Text input: search" id="patient_id" size="20" />
        </span> </div>
      </fieldset>
    </form>-->
  </div>
  <div id="container-foot">
    <div id="footer">
      <p><a href="http://www.free-css.com/">homepage</a> | <a href="mailto:denise@mitchinson.net">contact</a> | &copy; 2007 Anyone | Design by <a href="http://www.mitchinson.net"> www.mitchinson.net</a> | Licensed under a <a rel="license" href="http://creativecommons.org/licenses/by/3.0/">Creative Commons Attribution 3.0 License</a></p>
    </div>
  </div>