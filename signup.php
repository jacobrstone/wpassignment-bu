<?php include_once 'nav.php' ?>

<section class="signup-form">
    <h2>Sign Up</h2>
    <form action="includes/signup-inc.php" method="POST"> <!-- POST method so that data is not seen inside URL --> 
        <input type="text" name="first-name" placeholder="First name">
        <input type="text" name="second-name" placeholder="Second name">
        <input type="text" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="verify-password" placeholder="Confirm Password">
        <button type="submit" name="submit">Sign Up</button>
    </form>
</section>

<?php 

    $errorMessage = $_GET["error"];

    switch($errorMessage)
    {
        case "emptyInput":
            echo "<p>Please fill in all fields</p>";
            break; 
        case "invalidName":
            echo "<p>Please enter an appropriate name</p>"; 
            break;
        case "invalidEmail":
            echo "<p>Please enter a valid email</p>";
            break;
        case "passwordMismatch": 
            echo "<p>Please make sure both passwords are matching</p>";
            break; 
        case "usernameTaken": 
            echo "<p>That email is already in use</p>"; 
            break;
        case "statementFailed":
            echo "<p>Oh, it seems something went wrong - Try again!</p>"; 
            break;
        case "none": 
            echo "<p>Congrats, you've signed up!</p>";
            break;
    }
?>


<?php include_once 'footer.php' ?>