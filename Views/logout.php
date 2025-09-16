<?php
session_start(); //  Start the session
session_destroy();  //  logs the user out
header("Location: login.php"); // Redirect the user back to the login page
exit();
