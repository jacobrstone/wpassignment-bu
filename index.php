<?php 
    include_once "nav.php";
    require_once 'includes/dbhandler-inc.php';
    session_start();
?>

<h1>Dashboard</h1>

<?php
    if(isset($_SESSION["userid"])) // welcome message for user, if they are logged in
    {
        echo "<p>Hello " . $_SESSION["fullname"] . "</p>";  
    } 
?>


<p>Tracking Number*</p>

<form action="searchParcel.php" method="POST">
    <input type="text" name="tracking_number_input" placeholder="e.g. AA123456789UK">
    <button type="submit" name="submit">Track Parcel</button>
</form>

<?php include_once "footer.php" ?>