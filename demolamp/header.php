<?php
session_start();
    
// initialize a SESSION varaible to track the date/time of messages
$_SESSION["messageDate"] = NULL;

$clubstr = 'Indie Reads';
$userstr = 'Welcome Guest';
$logo = '';

echo <<<_INIT
<!DOCTYPE html> 
<html>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'> 
        <script src='javascript.js?v1'></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
       <link href="https://fonts.googleapis.com/css?family=Poppins|Roboto&display=swap" rel="stylesheet">
        <link rel='stylesheet' href='css/styles.css?v25'>
        <title>$clubstr: $userstr</title>
        </head>
_INIT;

require_once 'functions.php';

if (isset($_SESSION['user'])) {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr  = "Logged in as: $user";
}
else $loggedin = FALSE;

echo <<<_HEADER_OPEN
    
    <body>
        <div id="wrapper">
        <header>
            <div id='logodiv'>
<img border="0" alt="Indie Reads Logo" src="images/indiereads_logo.png">
            </div>
_HEADER_OPEN;

if ($loggedin) {
echo <<<_LOGGEDIN

            <nav><ul>
                <li><a href='members.php?view=$user'>Home</a></li>
                <li><a href='messages.php'>Messages</a></li>
                <li><a href='members.php'>Members</a></li>
            
                <li id="right-side"><a href='logout.php'>Log out</a></li>
                <li id="right-side"><a href='profile.php'>Profile</a></li>          <li id="right-side"><a href='mystorewebsite.com'>Browse</a></li>
                

            </ul></nav>
_LOGGEDIN;
} else {
echo <<<_GUEST

            <nav><ul>
                <li><a href='index.php'>Home</a></li>
                <li><a href='signup.php'>Sign Up</a></li>
                <li><a href='login.php'>Log In</a></li>
            </ul></nav> 
_GUEST;
 }

echo <<<_HEADER_CLOSE

        </header>
        <div id="content">
_HEADER_CLOSE;

?>
