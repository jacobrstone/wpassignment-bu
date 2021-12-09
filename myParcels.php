<?php 
include_once 'nav.php';
require_once 'includes/dbhandler-inc.php'; 
require_once 'includes/register-login-functions-inc.php'; 
session_start(); 

echo "<table>";  
echo "<tr id='tableHead'>";
echo "<th id='tracking_number'>Tracking Number</th>"; 
echo "<th id='parcel_id'>Parcel ID</th>";
echo "<th id='order_date'>Shipped</th>"; 
echo "<th id='parcel_status'>Status</th>";
echo "</tr>";

$parcels = myParcels($connection, $_SESSION['userid']); 

while($row = mysqli_fetch_assoc($parcels)) 
        {   // fetch an associative array from the result variable, accessing each element by column name from the database
            echo "<tr>"; 
            echo "<td>" . $row["tracking_number"] . "</td>" .
            "<td>" . $row["parcel_id"] . "</td>" . 
            "<td>" . $row["order_date"] . "</td>" .
            "<td>" . $row["parcel_status"] . "</td>";
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