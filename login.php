<?php include_once 'nav.php' ?>
<div class="container">
    <h2>Log In</h2>
    <form action="includes/login-inc.php" method="POST"> <!-- POST method so that data is not seen inside URL --> 
        <div class="input-group mb-3">
            <input type="text" name="email" placeholder="Username/Email" maxlength="50">
            <input type="password" name="password" placeholder="Password" maxlength="50">
            <div class="input-group-prepend">
                <button class="btn btn-outline-primary btn-sm" type="submit" name="submit">Log In</button>
            </div>
        </div>
    </form>
</div>

<?php 
    $errorMessage = $_GET["error"]; // get the error message 
    // output further details depending on the error message 
    switch($errorMessage)
    {
        case "emptyInput":
            echo "<p> style='color: red'Please fill in all fields</p>";
            break; 
        case "wrongPassword":
            echo "<p style='color: red;'>Password incorrect</p>"; 
            break;
        case "invalidEmail":
            echo "<p style='color: red'>Email incorrect</p>"; 
            break;
    }
?>
<?php include_once 'footer.php' ?>