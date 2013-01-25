<?php require_once("includes/functions.php") ?>

<?php
    
    //CONNECT THIS FILE TO LOG OUT BUTTON FOR DIFFERENT USERS
    //CLOSING SESSION 
    //1.FIND SESSION
    session_start();

    //2.UNSET ALL SESSION VARIABLES
    $_SESSION = array();
     
    //3.DESTROY SESSION COOKIE
    if(isset($_COOKIE[session_name()]))  {
        setcookie(session_name(),'', time()-4200, '/' );
    }

    //4.DESTROY SESSION
    session_destroy();

    //5.REDIRECT TO HOMEPAGE
    redirect_to("index.php");

   

?>