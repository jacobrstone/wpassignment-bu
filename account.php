<?php
include_once "nav.php"; 
session_start(); // start a session, allowing session variables to be used
// using session variables to display/personalise the user's account page 
echo "<h1>" . $_SESSION["fullname"] . "</h1>";
echo "<h3>" . $_SESSION["email"] . "</h3>";
?>

<h2>My info</h2>

<h3>Delete my account</h3>
<!-- A user input form to obtain the password and email from the user, to verify it's them deleting their account -->
<section class="delete-account">
    <form action="includes/deleteUser-inc.php" method="POST"> <!-- send the data to the deleteUser-inc.php file within the includes folder --> 
        <input type="text" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">   
        <input type="password" name="verify-password" placeholder="Confirm Password"> 
        <button type="submit" name="confirmDelete">Delete</button>
    </form>
</section>

<?php 

    $errorMessage = $_GET["error"]; // this gets are error messages and stores them in a varaible
    // we can then use a switch statement, to run through all the possible values of that error, and display a new message accordingly
    switch($errorMessage)
    {
        case "emptyInput": // when the user input is empty, display this message 
            echo "<p>Please fill in all fields</p>";
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

    }
?> 

<?php include_once "footer.php" ?>