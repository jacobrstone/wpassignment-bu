<?php include_once "nav.php"; 
if(!isset($_SESSION["userid"]))
{
    header("location: index.php");
}
?>
<div class="container text-center">
    <h1>My info</h1>
    <?php
    // using session variables to display/personalise the user's account page 
    echo "<h2>" . $_SESSION["fullname"] . "</h2>";
    echo "<h3>" . $_SESSION["email"] . "</h3>";
    ?>
    <h3>Delete my account</h3>
    <!-- A user input form to obtain the password and email from the user, to verify it's them deleting their account -->
    <section class="delete-account">
        <form action="includes/deleteUser-inc.php" method="POST"> <!-- send the data to the deleteUser-inc.php file within the includes folder --> 
            <div class="input-group mb-3 justify-content-center">
                <input type="text" name="email" placeholder="Email" maxlength="50">
                <input type="password" name="password" placeholder="Password" maxlength="50">   
                <input type="password" name="verify-password" placeholder="Confirm Password" maxlength="50"> 
                <div class="input-group-prepend">
                    <button class="btn btn-outline-primary btn-sm" type="submit" name="confirmDelete">Delete</button>
                </div>
            </div>
        </form>
    </section>
    <h3>Update my password</h3>
    <section>
        <form action="includes/updatePassword-inc.php" method="POST">
            <div class="input-group mb-3 justify-content-center">
                <input type="password" name="oldPassword" placeholder="Old Password">
                <input type="password" name="newPassword" placeholder="New Password">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-primary btn-sm" type="submit" name="updatePassword">Update Password</button>
                </div>
            </div>
        </form>
    </section>

    <?php 

        $errorMessage = $_GET["error"]; // this gets are error messages and stores them in a varaible
        // we can then use a switch statement, to run through all the possible values of that error, and display a new message accordingly
        switch($errorMessage)
        {
            case "emptyInput": // when the user input is empty, display this message 
                echo "<p <style='color: green;'>Please fill in all fields</p>";
                break;
            case "wrongPassword": // when the user uses the wrong password, display this message 
                echo "<p>Password incorrect</p>"; 
                break;
            case "wrongEmail": // when the user uses the wrong email, display this message 
                echo "<p>Email incorrect</p>"; 
                break;
            case "passwordMismatch": // when the passwords typed do not match eachother, display this message 
                echo "<p>Please make sure both passwords are matching</p>";
                break; 
            case "noUser": // when the account does not exist, display this message 
                echo "<p>There is no account with those credentials</p>"; 
                break;
            case "invalidEmail": // when the email given is not in the correct format, display this message 
                echo "<p>You must use your own email</p>"; 
                break;
            case "passwordSame": 
                echo "<p>Use a different password to your old password to change it"; 
                break; 
        }
    ?>
</div>
<?php include_once "footer.php" ?>