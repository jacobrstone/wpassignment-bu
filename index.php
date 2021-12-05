<?php 
    include_once "nav.php";
    require_once 'includes/dbhandler-inc.php';
?>

<h1>Dashboard</h1>

<p>Tracking Number*</p>

<form action="searchParcel.php" method="POST">
    <input type="text" name="tracking_number_input" placeholder="e.g. AA123456789UK">
    <button type="submit" name="submit">Track Parcel</button>
</form>

<?php include_once "footer.php" ?>