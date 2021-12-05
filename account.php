<?php require_once 'includes/dbhandler-inc.php';
include_once "nav.php";
session_start();
echo "<h1>" . $_SESSION["fullname"] . "</h1>";
echo "<h3>" . $_SESSION["userid"] . "</h3>";
?>

<h2>My info</h2>

<h3>Delete my account</h3>
<section class="delete-account">
    <form action="includes/deleteUser-inc.php" method="POST">
        <input type="text" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">    
        <button type="submit" name="confirmDelete">Delete</button>
    </form>
</section>

<?php 

    $errorMessage = $_GET["error"]; 

    switch($errorMessage)
    {
        case "emptyInput": 
            echo "<p>Please fill in all fields</p>";
            break;
        case "wrongPassword": 
            echo "<p>Password incorrect</p>"; 
            break;
        case "wrongEmail":
            echo "<p>Email incorrect</p>"; 
            break;
    }
?> 

<?php include_once "footer.php" ?>