<?php
// Redirect the browser to the homepage file located deeper in the project structure
header("Location: ../../private/Views/homepage.php");

// After sending the redirect, we call exit() to stop the script right here.
// It prevents any other code from accidentally running or outputting weird stuff after the redirect
exit();
