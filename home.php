<?php include_once "nav.php" ?>
<?php require_once 'includes/dbhandler-inc.php'?>

<h1>Dashboard</h1>

<p>Tracking Number*</p>

<form action="TrackerView.php" method="POST">
    <input type="text" id="tracking_number_input" placeholder="e.g. AA123456789UK">
    <button id="search_button">Track Parcel</button>
</form>

<?php include_once "footer.php" ?>

