<?php
session_start();
session_unset();      // Clear all session variables
session_destroy();    // Destroy session
header("Location: about.php"); // Redirect to public landing page
exit();
