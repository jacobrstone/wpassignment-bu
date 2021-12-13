<?php 
    include_once "nav.php"; // adding the navigation script in every file
    require_once 'includes/dbhandler-inc.php'; // adding the database handler 
    require_once 'includes/all-functions-inc.php'; 
?>
<!-- text-center -->
<div class="container text-center"> 
    <?php
        if(isset($_SESSION["userid"])) // welcome message for user, if they are logged in
        {
            echo "<h1>" . $_SESSION["fullname"] . "'s " .  "Dashboard</h1>";
        } 
    ?>
    <p>Tracking Number*</p>
    <!-- Submission form to search for a parcel from the home page -->
    <form action="includes/searchParcel-inc.php" method="GET"> 
        <div class="input-group mb-3 justify-content-center">
            <input type="text" name="tracking_number_input" placeholder="e.g. AA123456789UK" minlength="13" maxlength="50">
            <div class="input-group-prepend">
                <button class="btn btn-outline-primary btn-sm" type="submit" name="trackParcel">Track Parcel</button>
            </div>
        </div>
    </form>
    <?php 
        if(isset($_GET['tracking']))
        {
            echo "<table id='indexTable' class='table table-hover table-responsive'>";  
            echo "<tr id='tableHead'>";
            echo "<th id='tracking_number'>Tracking Number</th>"; 
            echo "<th id='parcel_id'>Parcel ID</th>";
            echo "<th id='order_date'>Shipped</th>"; 
            echo "<th id='parcel_status'>Status</th>";
            echo "</tr>"; 
            $parcel = trackingExists($connection, $_GET['tracking']); 
            while($row = mysqli_fetch_assoc($parcel)) 
            {   // fetch an associative array from the result variable, accessing each element by column name from the database
                echo "<tr>"; 
                echo "<td>" . $row["tracking_number"] . "</td>" .
                "<td>" . $row["parcel_id"] . "</td>" . 
                "<td>" . $row["order_date"] . "</td>" .
                "<td>" . $row["parcel_status"] . "</td>";
                echo "</tr>";
                echo "</table>"; 
                $parcel_ID = $row['parcel_id'];
            }
            if(session_status() === PHP_SESSION_ACTIVE)
            {
                echo "<form action='includes/addParcel-inc.php' method='POST'>";
                echo "<input type='hidden' name='userid' value=". $_SESSION['userid'] . ">"; 
                echo "<input type='hidden' name='parcelid' value=". $parcel_ID . ">";
                echo "<button class='btn btn-outline-primary btn-sm' type='submit' name='submit'>Add parcel</button>";
                echo "</form>";
            }

        }

        $error = $_GET["error"]; 

        switch($error)
        {
            case "stmtFailed": 
                echo "<p style='color: red;'>Something went wrong</p>"; 
                break; 
            case "noNumber": 
                echo "<p style='color: red;'>Tracking number does not exist</p>"; 
                break; 
        }

        if(isset($_GET["message"]))
        {
            $message = $_GET["message"];
            if($message == "successfulLogin")
            {
                echo "<p style='color: green;'>Successfully Logged In</p>";
            }
        }

    ?>
</div>
    <form action="includes/addParcel-inc.php">
        <input type="hidden" name="userid" value="$_SESSION['userid']">
        <input type="hidden" name="parcelid" value="row['parcel_id']">
    </form> 

<?php include_once "footer.php" ?>