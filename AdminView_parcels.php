<?php 
include_once "nav.php"; 
require_once 'includes/dbhandler-inc.php';

if(!isset($_SESSION))
{
    header("location: index.php");
}
else
{
    if($_SESSION["adminStatus"] !== 1)
    {
        header("location: index.php");
    }
}
?>

<!-- Admin Update Parcel Form -->
<div class="container">
    <h3>Update parcel info</h3>
    <!-- Input form for creating a parcel, set placeholders for usability, maxlength for consistency and to not exceed the storage in the database -->
        <form action="includes/adminUpdateParcel-inc.php" method="POST">
            <div class="input-group mb-3">
                <input type="text" name="parcel_id" placeholder="Parcel ID"  value="<?php echo $_POST['parcelID']; ?>" minlength="1"> 
                <input type="text" name="tracking_number" placeholder="AB012345678CD" value="<?php echo $_POST['tracking_number']; ?>" minlength="13" maxlength="50"> 
                <input type="date" name="order_date" value="<?php echo $_POST['order_date']; ?>">
                <input type="text" name="parcel_status" placeholder="Status" value="<?php echo $_POST['parcel_stats']; ?>" maxlength="18">
                <input type="dropdown" name="street_address" placeholder="Street address"  value="<?php echo $_POST['street_address']; ?>" maxlength="50">
                <input type="text" name="city" placeholder="City" value="<?php echo $_POST['city']; ?>" maxlength="50">
                <input type="text" name="country" placeholder="Country" value="<?php echo $_POST['country']; ?>" maxlength="50">
                <input type="text" name="postcode" placeholder="Postcode" value="<?php echo $_POST['postcode']; ?>" maxlength="50">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-primary btn-sm" type="submit" name="updateParcel">Update Parcel</button>
                </div>
            </div>
        </form>
    <hr>
</div>

<div class="container">
    <h3>View of all parcels in database</h3>
        <!-- HTML Table to format all the MySQL data -->
        <table class="table-sm table-hover table-responsive">
            <caption>All parcels</caption>
            <tr id="head">
                <th id="parcel_id">Parcel ID</th>
                <th id="tracking_number">Tracking Number</th>
                <th id="order_date">Order date</th>
                <th id="parcel_status">Status</th>
                <th id="delivery_address">Deliver to</th> 
                <th id="city">City</th>
                <th id="country">Country</th>
                <th id="postcode">Postcode</th>
            </tr>
            <?php
                //define total number of results you want per page  
                $results_per_page = 40;  
                // define the query to send to the database
                $query = "SELECT * FROM parcels;"; 
                $result_total = mysqli_query($connection, $query);  
                //find the total number of results stored in the database 
                $number_of_result = mysqli_num_rows($result_total);  
                //determine the total number of pages available  
                $number_of_page = ceil ($number_of_result / $results_per_page);  
                //determine which page number visitor is currently on  
                if (!isset ($_GET['page']) ) {  
                    $page = 1;  
                } else {  
                    $page = $_GET['page'];  
                } 

                //determine the sql LIMIT starting number for the results on the displaying page  
                $page_first_result = ($page - 1) * $results_per_page;  
                //retrieve the selected results from database   
                $get_parcel_data = "SELECT * FROM parcels LIMIT " . $page_first_result . ',' . $results_per_page;

                $result = mysqli_query($connection, $get_parcel_data);  
                
                //display the retrieved result on the webpage  
                // fetch an associative array from the result variable, accessing each element by column name from the database
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
                { 
                echo "<tr>"; 
                echo "<td>" . $row["parcel_id"] . "</td>" .
                "<td>" . $row["tracking_number"] . "</td>" .
                "<td>" . $row["order_date"] . "</td>" . 
                "<td>" . $row["parcel_status"] . "</td>" . 
                "<td>" . $row["street_address"] . "</td>" . 
                "<td>" . $row["city"] . "</td>" .
                "<td>" . $row["country"] . "</td>" . 
                "<td>" . $row["postcode"] . "</td>" . 
                "<td>" . "<form method='POST'><button type='submit' name='selectParcel' class='btn btn-outline-primary btn-sm'>Select</button>
                <input type='hidden' name='parcelID' value='$row[parcel_id]'>" . 
                "<input type='hidden' name='tracking_number' value='$row[tracking_number]'>" . 
                "<input type='hidden' name='order_date' value='$row[order_date]'>" .
                "<input type='hidden' name='parcel_status' value='$row[parcel_status]'>" .
                "<input type='hidden' name='street_address' value='$row[street_address]'>" .
                "<input type='hidden' name='city' value='$row[city]'>" . 
                "<input type='hidden' name='country' value='$row[country]'>" .
                "<input type='hidden' name='postcode' value='$row[postcode]'>" .
                "</form>" . "</td>"; 
                echo "</tr>";
                }
                echo "<nav>"; 
                echo "<ul class='pagination justify-content-center pagination-sm'>";
                //display the link of the pages in URL  
                for($page = 1; $page<= $number_of_page; $page++) {  
                    echo "<li class='page-item'><a class='page-link' href='AdminView_parcels.php?page=" . $page . "'>" . $page . "</a></li>";  
                } 
                echo "</ul>";
                echo "</nav>";
                // get error messages from URL, and use switch to display error messages
                $errorMessage = $_GET["error"];
                switch($errorMessage)
                {
                    case "stmtFailed": 
                        echo "<p>Something went wrong"; 
                        break;
                    case "invalidTrackFormat"; 
                        echo "<p>Please enter a tracking number with a valid format</p>";
                        break;
                }
            ?>
        </table>
</div>
<?php include_once "footer.php" ?>