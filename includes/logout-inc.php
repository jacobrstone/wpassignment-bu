<?php 
// Log Out Function 
function logout()
{
    session_start(); // start the session 
    session_unset(); // unset the session 
    session_destroy(); // then destroy it 

    header("location: ../index.php"); // return to the home page 
    exit(); // exit the script 
}

logout(); // call the function 