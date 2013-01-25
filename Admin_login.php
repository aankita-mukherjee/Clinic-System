<?php require_once("sessionAdmin.php"); ?>
<?php 
    //NO NEED TO LOG IN TWICE
    if(logged_in()){
        redirect_to("../Admin/Welcome.php");
    }
    ?>
<?php require_once("Includes/connection.php"); ?>
<?php require_once("Includes/functions.php"); ?>

<?php include("Templates/MainPage_Template.php"); ?>

        <div id="content">
            <h2>Please log-in with your ID</h2>
            </br>
            </br>
            <FORM name ="input" METHOD="POST" ACTION="<?php echo $_SERVER['PHP_SELF']; ?>" id="theform" >
                <TABLE >
                <TR>
                    <TH>Login Id</TH>
                <TD>
                    <INPUT TYPE="TEXT" NAME="id" id="id">
                </TD>
                </TR>
                <TR>
                    <TH>Password</TH>
                    <TD><INPUT TYPE="PASSWORD" NAME="contact" id="contact">
                </TR>
                </TABLE>
                <P><INPUT TYPE="SUBMIT" VALUE="Submit" NAME="Submit"></P>
            </form>
        </div>
    </div>
</body>


<?php  if(isset($_POST['Submit'])) { 


        if($_POST['id']==""||$_POST['contact']=="")
        {
            echo "One of the required fields is empty. Please review the log in information.";
            exit(0);
        }

        if($_POST['id']=="admin"||$_POST['contact']=="admin")
        {
            $_SESSION['user_id'] = $_POST['id'];
            redirect_to("../Admin/Welcome.php");
        }
        else
        {
            echo "Invalid username/password";
        }
    }

 ?>

<?php
    require_once("Includes/footer.php");
?>

