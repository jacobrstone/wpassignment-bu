<?php include_once 'nav.php' ?>
<div class="container">
    <h2>Sign Up</h2>
        <form action="includes/signup-inc.php" method="POST"> <!-- POST method so that data is not seen inside URL --> 
            <div class="input-group mb-3 text-center">
                <input type="text" name="first-name" placeholder="First name" maxlength="50">
                <input type="text" name="second-name" placeholder="Second name" maxlength="50">
                <input type="text" name="email" placeholder="Email" maxlength="50">
                <input type="password" name="password" placeholder="Password" maxlength="50">
                <input type="password" name="verify-password" placeholder="Confirm Password" maxlength="50">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-primary btn-sm" type="submit" name="submit">Sign Up</button>
                </div>
            </div>
        </form>
</div>

<?php 

    $errorMessage = $_GET["error"];

    switch($errorMessage)
    {
        case "emptyInput":
            echo "<p style='color: red'>Please fill in all fields</p>";
            break; 
        case "invalidName":
            echo "<p style='color: red'>Please enter an appropriate name</p>"; 
            break;
        case "invalidEmail":
            echo "<p style='color: red'>Please enter a valid email</p>";
            break;
        case "passwordMismatch": 
            echo "<p style='color: red'>Please make sure both passwords are matching</p>";
            break; 
        case "usernameTaken": 
            echo "<p style='color: red'>That email is already in use</p>"; 
            break;
        case "statementFailed":
            echo "<p style='color: red'>Something went wrong</p>"; 
            break;
        case "none": 
            echo "<p style='color: green'>Congrats, you've signed up!</p>";
            break;
    }
?>


<?php include_once 'footer.php' ?>