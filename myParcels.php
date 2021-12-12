<?php 
include_once 'nav.php';
require_once 'includes/dbhandler-inc.php'; 
require_once 'includes/all-functions-inc.php'; 
echo "<div class='container'>";
    echo "<h3>View more infomation about your parcels</h3>";
    echo "<hr>";
    echo "<table class='table-sm table-hover table-responsive'>";  
        echo "<caption>My Parcels</caption>";
            echo "<tr id='tableHead'>";
            echo "<th id='tracking_number'>Tracking Number</th>"; 
            echo "<th id='parcel_id'>Parcel ID</th>";
            echo "<th id='order_date'>Shipped</th>"; 
            echo "<th id='parcel_status'>Status</th>";
            echo "<th id='street_address'>Address</th>";
            echo "<th id='city'>City</th>";
            echo "<th id='country'>Country</th>";
            echo "<th id='postcode'>Postcode</th>";
            echo "</tr>";
echo "</div>";

$parcels = myParcels($connection, $_SESSION['userid']); 

while($row = mysqli_fetch_assoc($parcels)) 
    {   // fetch an associative array from the result variable, accessing each element by column name from the database
        echo "<tr>"; 
        echo "<td>" . $row["tracking_number"] . "</td>" .
        "<td>" . $row["parcel_id"] . "</td>" . 
        "<td>" . $row["order_date"] . "</td>" .
        "<td>" . $row["parcel_status"] . "</td>" . 
        "<td>" . $row["street_address"] . "</td>" .
        "<td>" . $row["city"] . "</td>" .
        "<td>" . $row["country"] . "</td>" . 
        "<td>" . $row["postcode"] . "</td>";
        echo "</tr>"; 
    }
echo "</table>";

$error = $_GET["error"]; 

switch($error)
{
    case "stmtFailed": 
        echo "<p>Something went wrong</p>"; 
        break;
}
?>
<?php include_once 'footer.php'; ?>