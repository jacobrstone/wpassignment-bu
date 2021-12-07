<?php 
    require_once 'includes/dbhandler-inc.php';
    include_once 'nav.php';
?> 

<?php 
    $trackingNumber = $_POST["tracking_number_input"];
    $query = "SELECT * FROM parcels WHERE tracking_number = '$trackingNumber'"; 
    $resultData = mysqli_query($connection, $query); 
    mysqli_close($connection); 
?>

<table> <!-- HTML Table to format all the MySQL data -->
<caption>Parcels</caption>
<tr id="head">
    <th id="tracking_number">Tracking Number</th>
    <th id="order_date">Shipped</th>
    <th id="parcel_status">Status</th> 
</tr>
<?php 
    if(isset($_POST['submit']))
    {  
        while($row = mysqli_fetch_array($resultData, MYSQLI_ASSOC)) 
        { // fetch an associative array from the result variable, accessing each element by column name from the database
            echo "<tr>"; 
            echo "<td>" . $row["tracking_number"] . "</td>" .
            "<td>" . $row["order_date"] . "</td>" . 
            "<td>" . $row["parcel_status"] . "</td>";
            echo "<td>" . "<button>Add Parcel</button>" . "</td>";
            echo "</tr>";
        }
    }
    else 
    {
        header("location: /index.php");
        exit();
    }
?>
</table>    

<?php include 'footer.php' ?> 