<?php require_once("Includes/functions.php"); ?>

<?php 
 
 //START SESSION
 session_start(); 

 //CHECK IF USER LOGGED IN
 function logged_in() {
     return isset($_SESSION['user_id']);
 }

 //RESTRICT ACCESS
 function confirm_logged_in()  {
     if(!logged_in()) {
         redirect_to("../index.php");} 
     }
 

 
 ?>