<?php 
session_start(); 
// All functions below here are for REGSITERING a new user 
// Empty Input on Sign Up Function
/**
 * Checks if the user input fields are null or not
 * @param string $firstName - first name input box on the sign up page
 * @param string $secondName - second name input box on the sign up page 
 * @param string $email - user's email input box on the sign up page 
 * @param string $password - user's password input box on the sign up page 
 * @param string $passwordVerified - the repeat password input box on the sign up page
 * @return boolean returns either true or false after checking all the inputs for nullness
 */
function emptyInputSignUp($firstName, $secondName, $email, $password, $passwordVerified) 
{
    $result=false; // set result to false by default
    if(empty($firstName) || empty($secondName) || empty($email) || empty($password) || empty($passwordVerified)) // check all parameters (input fields) for empty
    {
        $result = true; // if this is true, we set result to true, which will throw an error
    } 
    else 
    {
        $result = false; // if there are no mistakes, we return false, and continue on.
    }
    return $result;
}
// Invalid Name Function
/**
 * Checks if the user has input an invalid first or second name
 * @param string $firstName - the value of the user's first name from the input form 
 * @param string $secondName - the value of the user's surname from the input form 
 * @return boolean returns either true or false after checking the user inputs
 *  */
function invalidFullname($firstName, $secondName)
{
    $result=false;
    if(!preg_match("/^[a-zA-Z]*$/", $firstName, $secondName)) // if the username violates the regular expression (has values that it should not) then throw error.
    {
        $result = true;
    }
    else 
    {
        $result = false;
    }
    return $result;
}
// Invalid Email Function
/**
 * Checks if the user has submitted an email that is not in the correct format, or using a domain that does not exist
 * @param string $email - the value of the user's email from the email input text box 
 * @return boolean returns a boolean of either true or false after checking the user input against a filter 
 */
function invalidEmail($email) 
{
    $result=false;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) // if the email does not match the filter, throw an error
    {
        $result = true;
    } 
    else  // else if email is valid, return false and continue to next error handler
    {
        $result = false;
    }
    return $result;
}

/** 
 * Checks that the passwords the user has submitted are the same
 * @param string $password - the value of the password taken from the input password box 
 * @param string $passwordVerified - the value of the password taken from the input confirmed password box 
 * @return boolean return true or false after checking the user inputs match 
 */
function matchPassword($password, $passwordVerified) 
{
    if($password !== $passwordVerified) // if the passwords do not match
    {
        $result = true;
    } 
    else // else if they do match, return false and continue to next error handler
    {
        $result = false;
    }
    return $result;
}
// Get User Function
/**
 * This is used to get any record from the users table in the database
 * @param mysqli $connection - this is the connection variable, it initialises connection to the MySQL database in order to start transactions 
 * @param string $email - this is the users email passed into the function 
 * @return array/boolean returns either an associative array containing 1 row of user data or a boolean false stating the fetch query failed 
 */
function getUser($connection, $email) // this can function as both our signup and our login function 
{
    $query = "SELECT * FROM Users WHERE email = ?"; 
    
    // using a prepared statement, so that users cannot enter code into the textfields and break website, stopping injection and enhancing security.
    $statement = mysqli_stmt_init($connection);
    if(!mysqli_stmt_prepare($statement, $query)) // checking if the prepared statement fails, before checking for success (for security purposes) 
    {
        header("location: ../signup.php?error=statementFailed");
        exit();
    }
    // pass in the statement to execute, and the data types of the other parameters (N '<symbol> for n parameters') 1 's' for 1 parameter ($email)
    mysqli_stmt_bind_param($statement, "s", $email);
    mysqli_stmt_execute($statement); // now run the statement  

    $resultData = mysqli_stmt_get_result($statement); // get the data from the just executed SQL statement

    // this if will complete two functions. 
    // If it returns true, then login as normal, as the username matches what we have in our database
    // if false, set result to false and return it, which throws the exception in our signup-inc.php script
    if($row = mysqli_fetch_assoc($resultData)) // create variable row as we fetch resultData as an associative array and check if its true
    {
        return $row; 
    } 
    else 
    {
        $result = false; 
        return $result; 
    }
    // mysqli_close(the sql statement + connection); 
    mysqli_stmt_close($statement);
}
// Create User Function
/**
 * Creates a new user in the Users table, inserting their data into the database
 * @param mysqli $connection - initialises a mysqli connection to the database, in order to start queries/transaction
 * @param string $firstname - the user's first name, to be inserted into the relevant column in the Users table 
 * @param string $secondName - the user's surname, to be inserted into the relevant column in the Users table 
 * @param string $email - the user's email, to be inserted into the relevant column in the Users table 
 * @param string $password - the user's password, to be inserted into the relevant column in the Users table 
 * @param int $adminStatus - the user's administrator privilege, set to 0 by default, to be inserted into the relevant column in the Users table 
 * @return null this function does not return any data 
 */
function createUser($connection, $firstName, $secondName, $email, $password, $adminStatus) // this can function as both our signup and our login function 
{
    $query = "INSERT INTO Users(first_name, last_name, email, password, adminStatus) VALUES(?, ?, ?, ?, ?);"; 
    // using a prepared statement, so that users cannot enter code into the textfields and break website, stopping injection and enhancing security.
    $statement = mysqli_stmt_init($connection);
    if(!mysqli_stmt_prepare($statement, $query)) // checking if the prepared statement fails, before checking for success (for security purposes) 
    {
        header("location: ../signup.php?error=statementFailed");
        exit();
    }

    // hasing the password - so that anyone who somehow gains access to the DB / data breach occures, they cannot see the raw password data 
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
    // pass in the statement to execute, and the data types of the other parameters (each 's' is datatype of parameter) 4 's' for $username, and $email
    mysqli_stmt_bind_param($statement, "ssssi", $firstName, $secondName, $email, $hashedPassword, $adminStatus);
    mysqli_stmt_execute($statement); // now run the statement 
    mysqli_stmt_close($statement); // close the prepared statement 
    header("location: ../signup.php?error=none"); // send the user back to the signup page 
    exit();
}
// All functions below here are for LOGGING IN an already registered user 
/**
 * Checks the login page for empty inputs 
 * @param $username - this is the username that the user logs in with, this is always just the user's email
 * @param $user_password - the password they enter into the input box 
 * @return boolean returns true or false after checking the inputs for null
 */
// Checking that the user isn't trying to log in with blank credentials 
function emptyInputLogin($username, $user_password) 
{
    $result = false;
    if(empty($username) || empty($user_password)) // check that neither username or password fields are not empty
    {
        $result = true;
    }
    else 
    {
        $result = false;
    }
    return $result; // return a boolean 
}
// Login User Function
/**
 * Connects to the database, verifies the credentials and then logs the user into the web app
 * @param mysqli $connection - initialises the connection to the database to allow querying to take place
 * @param string $email - the user's email passed in as a string 
 * @param string $password- the user's password passed in as a string
 * @return null this function does not return data
 */
function loginUser($connection, $email, $password)
{
    $getUser = getUser($connection, $email);  

    if($getUser === false)
    {
        header("location: ../login.php?error=invalidLogin"); 
        exit();
    }

    $passwordHashed = $getUser["password"]; // grabbing the hashed password from the database
    $checkPassword = password_verify($password, $passwordHashed); // if this returns true, we know they match

    if($checkPassword === false) // if checkPassword is false, send the user back to the session and exit the script
    {
        header("location: ../login.php?error=wrongPassword");
        exit();
    }
    else if($checkPassword === true) // if true 
    {
        // create a new session upon successful login - (done on line 1 of script)
        // create session super globals that access the getUser associative array to obtain DB columns 
        $_SESSION["email"] = $getUser["email"]; 
        $_SESSION["userid"] = $getUser["user_id"];
        $_SESSION["password"] = $getUser["password"];
        $_SESSION["adminStatus"] = $getUser["adminStatus"]; 
        $_SESSION["fullname"] = $getUser["first_name"] . " " . $getUser["last_name"];
        header("location: ../index.php?message=successfulLogin"); 
        exit();
    }
}
// Delete User Function 
/**
 * Connects to the database, verifies credentials and then removes that user from the Users table
 * @param mysqli $connection - initialises the database connection to allow querying to take place 
 * @param string $email - the user's email passed through as a string 
 * @param string $password - the user's password passed through as a string 
 * @param string $passwordVerified - the user's password again, to confirm identity and increase security
 * @return null this function does not return any data 
 */
function deleteUser($connection, $email, $password, $passwordVerified)
{
    $getUser = getUser($connection, $email); 
    if($getUser === false)
    {
        header("location: ../account.php?error=noUser"); 
        exit();
    }

    if($email !== $_SESSION["email"])
    {
        header("location: ../account.php?error=invalidEmail"); 
        exit();
    }
    // use session variable instead of passing the user id so that a user can only delete their own account 
    // check that inputted password is correct 
    $passwordHashed = $getUser["password"]; // grabbing the hashed password from the database
    $checkPassword = password_verify($password, $passwordHashed); // if this returns true, we know they match
    $user_id = $_SESSION["userid"];
    if($checkPassword === false) // if checkPassword is false, send the user back to the session and exit the script
    {
        header("location: ../account.php?error=wrongPassword");
        exit();
    }

    else if($checkPassword === true) // if true 
    {
        if(matchPassword($password, $passwordVerified) !== false)
        {
            header("location: ../account.php?error=passwordMismatch"); 
            exit();
        }
        else
        {
            $query = "DELETE FROM Users WHERE user_id = ?"; 
            $statement = mysqli_stmt_init($connection); // use prepared statement 
            if(!mysqli_stmt_prepare($statement, $query))
            {
                header("location: ../account.php?error=statementFailed"); 
                exit(); 
            }
    
            mysqli_stmt_bind_param($statement, "i", $user_id); 
            mysqli_stmt_execute($statement); 
            mysqli_stmt_close($statement);
            include_once 'logout-inc.php';
        }  
    }
}
// Tracking Exists Function
/**
 * Checks that the parcel tracking number exists in the database
 * @param mysqli $connection - initialises the database connection to allow queries to run
 * @param string $trackingNumber - the tracking number submitted by user input
 * @return mysqli_result returns a mysqli_result object if the data exists 
 */
function trackingExists($connection, $trackingNumber)
{ 
    $query = "SELECT * FROM parcels WHERE tracking_number = ?"; // MySQL query to find the parcel with the corresponding tracking number 
    $statement = mysqli_stmt_init($connection); 
    if(!mysqli_stmt_prepare($statement, $query))
    {
        header("location: index.php?error=stmtFailed");
        exit(); 
    }

    mysqli_stmt_bind_param($statement, "s", $trackingNumber); 
    mysqli_stmt_execute($statement);
    if($data = mysqli_stmt_get_result($statement))
    {
        return $data;
    } 
    mysqli_stmt_close($statement);
}
// Add Parcel Function
/**
 * Allows any user to add a parcel to their account to view on the My Parcels page
 * @param mysqli $connection - initialises the database connection to allow queries to run
 * @param int $parcelID - integer ID that uniquely identifies a parcel in the database
 * @param int $userID - integer ID that uniquely identifies a user in the database
 * @return null this function does not return any data
 */
function addParcel($connection, $parcelID, $userID)
{
    // query to run on the SQL server
    $query = "INSERT INTO user_parcel_link(user_id, parcel_id) VALUES(?, ?);"; 
    $statement = mysqli_stmt_init($connection); // initialise prepared statement 
    if(!mysqli_stmt_prepare($statement, $query)) // if preparing the statement fails (if the query given has invalid syntax)
    {
        header("location: ../index.php?error=stmtFailed"); // throw error, statementFailed, send the user to the home page 
        exit(); // exit the script 
    }

    mysqli_stmt_bind_param($statement, "ii", $userID, $parcelID); // bind the parameters to the statement, declaring their data types 
    mysqli_stmt_execute($statement); // execute the prepared statement 
    mysqli_stmt_close($statement); // close the statement (and the connection)
    header("location: ../index.php"); // return back to the index page 
    exit(); // exit the script 
}
// My Parcels Function 
/**
 * Display all the tracked parcels for the currently logged in user 
 * @param mysqli $connection - initialises the database connection to allow queries to run
 * @param int $userID - integer ID that uniquely identifies a user in the database
 * @return mysqli_result,false returns either the result from the query, or a boolean, false if the data does not exist
 */
function myParcels($connection, $userID)
{
    // query to be run on the SQL server
    $query = "SELECT * FROM parcels WHERE parcel_id IN (SELECT parcel_id FROM user_parcel_link WHERE user_id = ?)";
    $statement = mysqli_stmt_init($connection); // initialise prepared statement 
    if(!mysqli_stmt_prepare($statement, $query)) // if preparing the statement fails (if the query given has invalid syntax)
    {
        header("location: ../myParcels.php?error=stmtFailed"); // throw error, statementFailed, send the user to the home page 
        exit(); // exit the script 
    }

    mysqli_stmt_bind_param($statement, "i", $userID); // bind the parameters to the statement, declaring their data types 
    mysqli_stmt_execute($statement); // execute the prepared statement 

    if($data = mysqli_stmt_get_result($statement)) // get the results of the prepared statement, save them to the $data variable and return them
    {
        return $data;
    }
    else // if that fails, return false 
    {
        return false; 
    }
    mysqli_stmt_close($statement); // close the statement (and the connection)
    header("location: ../myParcels.php"); // send the user to the My Parcels page after executing this function
    exit(); // exit the script 
}
// Update Password Function 
/**
 * Allows the user to change their old password to a new password
 * @param mysqli $connection - initialises the database connection to allow queries to run
 * @param string $old_password - the user's old password, submitted via POST method 
 * @param string $new_password - the user's new password, submitted via POST method 
 * @return null this function does not return any data
 */
function updatePassword($connection, $old_password, $new_password)
{
    // get the user's account details using a session variable that stores their email 
    $user = getUser($connection, $_SESSION['email']); 
    if($user === false) // check that the user exists 
    {
        header("location: ../account.php?error=noUser"); // if it doesn't send them to the account page, with error code "noUser"
        exit();
    }
    $user_id = $user['user_id']; // assign the user ID from the associative array created by the getUser function
    $passwordHashed = $user["password"]; // get the user's hashed password 
    $checkPassword = password_verify($old_password, $passwordHashed); // verify their input password matches the password in the database
    if($checkPassword === false) // if the check is false 
    {
        header("location: ../account.php?error=wrongPassword"); // show error code wrongPassword, and exit script 
        exit(); 
    } 
    else // if all checks pass, complete the change password request 
    {
        // query to be run on the SQL server 
        $query = "UPDATE Users SET password = ? WHERE user_id = ?"; 
        $statement = mysqli_stmt_init($connection); // initialise prepared statement 
        if(!mysqli_stmt_prepare($statement, $query)) // check the syntax 
        {
            header("location: ../account.php?error=statementFailed"); // if it fails, show statementFailed error 
            exit(); // exit the script 
        }
        $new_passwordHashed = password_hash($new_password, PASSWORD_DEFAULT); // hash the new password 
        mysqli_stmt_bind_param($statement, "ss", $new_passwordHashed, $user_id); // bind the parameters, using the new password in place of their old 
        mysqli_stmt_execute($statement); // execute the statement 
        mysqli_stmt_close($statement); // close the statement 
        header("location: ../account.php"); // direct them back to the My Account page 
        exit(); // exit the script 
    }
}
// Create Parcel Function
/**
 * Allows an authenticated user (admin) to create a new parcel and insert it into the database
 * @param mysqli $connection - initialises the database connection to allow queries to run
 * @param string $trackingNumber - the tracking number of an entry in the database 
 * @param date $orderDate - the date the parcel was order was placed 
 * @param string $parcelStatus - the current status of the parcel 
 * @param string $streetAddress - the address the parcel needs to be delivered to
 * @param string $city - the city the parcel needs to be delivered to 
 * @param string $country - the country the parcel needs to be delivered to 
 * @param string $postcode - the postcode the parcel needs to be delivered to
 * @return null this function does not return any data  
 */
function createParcel($connection, $trackingNumber, $orderDate, $parcelStatus, $streetAddress, $city, $country, $postcode)
{
    // list of available statuses the user can input
    $statusList = array("Delivered", "Held at PO", "Dispatched", "Out for delivery", "Lost in transit", "Returned to sender", "Parcel diverted", "Payment received"); 
    // regular expression for the tracking number format 
    $pattern = "/^[a-zA-Z]+[\d]{9}[a-zA-Z]+$/i";
    // run the regular expression checker method on the pattern and the trackingNumber, to verify that it's appropriate
    if(!preg_match($pattern, $trackingNumber)) // checking if they DO NOT match, and then sending an error in the URL if they don't
    {
        header("location: ../AdminView.php?error=invalidTrackFormat");
        exit();
    }
    if(!in_array($parcelStatus, $statusList)) // checking if the status given IS NOT listed in the available status list 
    {
        header("location: ../AdminView.php?error=invalidStatus"); // send an error message if the status does not exist 
        exit(); 
    } 
    // else, run the query as normal
    $query = "INSERT INTO parcels(tracking_number, parcel_status, order_date, city, street_address, postcode, country) VALUES(?,?,?,?,?,?,?);"; 
    $statement = mysqli_stmt_init($connection);  // initialise prepared statement 
    if(!mysqli_stmt_prepare($statement, $query)) // validate the syntax of the prepared statement 
    {
        header("location: ../index.php?error=stmtFailed"); // throw an error if it is invalid 
        exit(); 
    }
    // bind all the parameters, and their given datatypes 
    mysqli_stmt_bind_param($statement, "sssssss", $trackingNumber, $parcelStatus, $orderDate, $city, $streetAddress, $postcode, $country);
    mysqli_stmt_execute($statement); // execute the statement 
    mysqli_stmt_close($statement); // close the statement 
    header("location: ../AdminView.php"); // return to the admin page 
    exit(); // exit the script 
}
// Delete Parcel From Database Function 
/**
 * Allows an authenticated user (admin) to create a new parcel and insert it into the database
 * @param mysqli $connection - initialises the database connection to allow queries to run
 * @param string $trackingNumber - the tracking number of an entry in the database 
 * @return null this function does not return any data  
 */
function deleteParcel($connection, $trackingNumber)
{
    // check that a parcel exists 
    $parcel = trackingExists($connection, $trackingNumber);
    if(mysqli_num_rows($parcel) === 0) // if there are no rows returned in the $parcel variable, then it does not exist
    {
        header("location: ../AdminView.php?error=noParcel"); // send them a noParcel error 
        exit(); // exit script 
    } 
    else // if it does have rows (data) 
    {
        $query = "DELETE FROM parcels WHERE tracking_number = ?"; // run the delete query 
        $statement = mysqli_stmt_init($connection);  // initialise prepared statement 
        if(!mysqli_stmt_prepare($statement, $query)) // check for invalid syntax 
        {
            header("location: ../index.php?error=stmtFailed"); // catch the error if there is any 
            exit(); // exit script 
        }
        // bind the parameters 
        mysqli_stmt_bind_param($statement, "s", $trackingNumber); 
        mysqli_stmt_execute($statement); // execute the statement 
        mysqli_stmt_close($statement); // close it 
        header("location: ../AdminView.php"); // send them back to the Admin page 
        exit(); // exit the script 
    }
}
// Set/Create New Admin Function
/**
 * Allows an authenticated user (admin) to create a new parcel and insert it into the database
 * @param mysqli $connection - initialises the database connection to allow queries to run
 * @param string $email - the email of the user passed into the submission form, through the URL via POST method 
 * @return null this function does not return any data 
 */
function setAdmin($connection, $email)
{
    $user = getUser($connection, $email);
    $user_id = $user["user_id"];
    $query = "UPDATE Users SET adminStatus = 1 WHERE user_id = ?"; 
    $statement = mysqli_stmt_init($connection); 
    if(!mysqli_stmt_prepare($statement, $query))
    {
        header("location: ../AdminView.php?error=statementFailed"); 
        exit(); 
    }
    mysqli_stmt_bind_param($statement, "s", $user_id);
    mysqli_stmt_execute($statement); 
    mysqli_stmt_close($statement);
    header("location: ../AdminView.php?error=adminSet"); 
    exit();
}
// Update Parcel Information Function 
/**
 * Allows an authenticated user (admin) to create a new parcel and insert it into the database
 * @param mysqli $connection - initialises the database connection to allow queries to run
 * @param string $trackingNumber - the tracking number of an entry in the database 
 * @param date $orderDate - the date the parcel was order was placed 
 * @param string $parcelStatus - the current status of the parcel 
 * @param string $streetAddress - the address the parcel needs to be delivered to
 * @param string $city - the city the parcel needs to be delivered to 
 * @param string $country - the country the parcel needs to be delivered to 
 * @param string $postcode - the postcode the parcel needs to be delivered to
 * @return null this function does not return any data  
 */
function updateParcel($connection, $parcelID, $trackingNumber, $orderDate, $parcelStatus, $streetAddress, $city, $country, $postcode)
{
    // list of valid parcel statuses 
    $statusList = array("Delivered", "Held at PO", "Dispatched", "Out for delivery", "Lost in transit", "Returned to sender", "Parcel diverted", "Payment received"); 
    // check a parcel exists 
    $parcel = trackingExists($connection, $trackingNumber); 
    if(mysqli_num_rows($parcel) === 0) // if num_rows = 0, then the parcel doesn't exist in the database 
    {
        header("location: ../AdminView_parcels.php?error=noParcel"); // throw noParcel error message 
        exit(); // exit the script 
    }
    if(!in_array($parcelStatus, $statusList)) // check the status given is valid  
    {
        header("location: ../AdminView_parcels.php?error=invalidStatus"); // if it's not valid, throw invalidStatus error message 
        exit(); // exit the script 
    } 
    // query to send to the database 
    $query = "UPDATE parcels SET tracking_number = ?, order_date = ?, parcel_status = ?, street_address = ?, city = ?, country = ?, postcode = ? WHERE parcel_id = ?";
    $statement = mysqli_stmt_init($connection);  // initialise the prepared statement 
    if(!mysqli_stmt_prepare($statement, $query)) // check for invalid syntax 
    {
        header("location: ../index.php?error=stmtFailed"); // catch the error, send them to the home page and display stmtFailed error message 
        exit(); // exit the script 
    }
    // bind the parameters to the statement 
    mysqli_stmt_bind_param($statement, "sssssssi", $trackingNumber, $orderDate, $parcelStatus, $streetAddress, $city, $country, $postcode, $parcelID);
    mysqli_stmt_execute($statement); // execute the statement 
    mysqli_stmt_close($statement); // close the statement 
    header("location: ../AdminView_parcels.php?error=parcelUpdate"); // send back to the AdminView_parcels page, and a message saying parcel info updated 
    exit(); // exit the script 
}