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
                "<td>" . $row["postcode"] . "</td>";
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