<?php
     require_once("../includes/connection.php");
     include("../sessionPatient.php");
     include("../includes/functions.php");
     if(!isset($_SESSION['id_number']))
        redirect_to("../index.php");
    else
         $patient_id = $_SESSION['id_number'];

    /* $location = "../Visitor_login.php";
     if(isset($patient_id === FALSE)
     { 
         header("Location: " $location);
         exit();
     }*/
     //require_once("../Patient/sql_queries.php");
?>

<link href="../stylesheets/MainStyle.css" rel="stylesheet" type="text/css" />
<link href="../stylesheets/TableStyles.css" rel="stylesheet" type="text/css" />
<body>
<div id="container">
  <div id="banner">
    <h1>Company Name</h1>
  </div>
  <div id="navcontainer">
    <ul id="navlist">
      <li id="active"><a id="current" href="home.php">Home</a></li>
      <li><a href="edit_details.php">Edit Details</a></li>
      <li><a href="../logout.php">Logout</a></li>
    </ul>
  </div>
  <div id="sidebar">
    <h2>Functions</h2>
    <div class="navlist">
      <ul>
        <li><a href="visit_list.php">View Visits</a></li>
        <li><a href="docs_seen.php">All Doctors Seen</a></li>
        <li><a href="docs_notseen.php">All Doctors Not Seen</a></li>
        <li><a href="view_manufacturers.php">View Manufacturers of Drugs</a></li>
      </ul>
    </div>
    <form action="searchbar.php" method="post">
      <fieldset>
      <legend>Search</legend>
      <div> <span>
        <label for="txtsearch"> Search Medicine <img src="../img/search.gif" alt="search" /></label>
        </span> <span>
        <input type="text" value="" name="txtsearch" title="Text input: search" id="txtsearch" size="20" />
        </span> </div>
      </fieldset>
    </form>
  </div>
  <div id="container-foot">
    <div id="footer">
      <p><a href="http://www.free-css.com/">homepage</a> | <a href="mailto:denise@mitchinson.net">contact</a> | &copy; 2007 Anyone | Design by <a href="http://www.mitchinson.net"> www.mitchinson.net</a> | Licensed under a <a rel="license" href="http://creativecommons.org/licenses/by/3.0/">Creative Commons Attribution 3.0 License</a></p>
    </div>
  </div>
