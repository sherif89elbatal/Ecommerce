<?php

    session_start(); // Start The Session
    
    session_unset(); // unset The Data
    
    session_destroy(); // Destroy the session
    
    header('Location: index.php'); // Redirect to home page
    
    exit();