<?php require_once("Includes/functions.php"); ?>

<?php 
 
 //START SESSION
 //TO BE INCLUDED IN ALL FILES ACCESSED BY PATIENT
 session_start(); 

 //CHECK IF USER LOGGED IN
 function logged_in() {
     return isset($_SESSION['contact_number']);
 }

 //RESTRICT ACCESS
 function confirm_logged_in()  {
     if(!logged_in()) {
         redirect_to("index.php");} 
     }
 

 
 ?>
