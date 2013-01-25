<?php require_once("../includes/functions.php"); ?>

<?php 
 
 //START SESSION
 session_start(); 

 //CHECK IF USER LOGGED IN
 function logged_in() {
     return isset($_SESSION['id_number']);
 }

 //RESTRICT ACCESS
 function confirm_logged_in()  {
     if(!logged_in()) {
         redirect_to("index.php");} 
     }
 

 
 ?>