<?php 

// Empty field check
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

// Invalid username check
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

function invalidEmail($email) 
{
    $result=false;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) // if the username violates the regular expression (has values that it should not) then throw error.
    {
        $result = true;
    } 
    else  // else if email is valid, return false and continue to next error handler
    {
        $result = false;
    }
    return $result;
}

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

function usernameExists($connection, $email) // this can function as both our signup and our login function 
{
    $query = "SELECT * FROM Users WHERE email = ?;"; 
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
    mysqli_stmt_close($statement);
}

function createUser($connection, $firstName, $secondName, $email, $password) // this can function as both our signup and our login function 
{
    $query = "INSERT INTO Users(first_name, last_name, email, password) VALUES(?, ?, ?, ?);"; 
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
    mysqli_stmt_bind_param($statement, "ssss", $firstName, $secondName, $email, $hashedPassword);
    mysqli_stmt_execute($statement); // now run the statement 
    mysqli_stmt_close($statement); // close the prepared statement 
    header("location: ../signup.php?error=none"); // send the user back to the signup page 
    exit();
}