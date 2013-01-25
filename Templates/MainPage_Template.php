<?php
    
?>
<title>Welcome to the Clinic System</title>
<link href="../stylesheets/MainStyle.css" rel="stylesheet" type="text/css" />
<link href="../stylesheets/TableStyles.css" rel="stylesheet" type="text/css" />
<body>
<div id="container">
  <div id="banner">
   
  </div>
  <div id="navcontainer">
    <ul id="navlist">
      <li id="active"><a id="current" href="../index.php">Home</a></li>
      <li><a href="../about.php">About</a></li>
      <li><a href="../contact.php">Contact</a></li>
    </ul>
  </div>
  <div id="sidebar">
    <h2>Log in by user</h2>
    <div class="navlist">
      <ul>
        <li><a href="Doctor_login.php">Doctor log-in</a></li>
        <li><a href="Visitor_login.php">Visitor log-in</a></li>
        <li><a href="Admin_login.php">Admin log-in</a></li>
      </ul>
    </div>
    <form action="search_doctors.php" method="post">
      <fieldset>
      <legend>Search</legend>
      <div> <span>
        <label for="txtsearch"> Find Doctor Info: <img src="../img/search.gif" alt="search" /></label>
        </span> <span>
        <input type="text" value="Doctor Name" name="txtsearch" title="Text input: search" id="txtsearch" size="20" />
        </span> </div>
      </fieldset>
    </form>
  </div>
  <div id="container-foot">
    <div id="footer">
      <p><a href="http://www.free-css.com/">homepage</a> | <a href="mailto:denise@mitchinson.net">contact</a> | &copy; 2007 Anyone | Design by <a href="http://www.mitchinson.net"> www.mitchinson.net</a> | Licensed under a <a rel="license" href="http://creativecommons.org/licenses/by/3.0/">Creative Commons Attribution 3.0 License</a></p>
    </div>
  </div>