<?php
require_once 'header.php';

if (!$loggedin)
    die("Please log in to view your bookstore.</div><footer></footer></body></html>");

if ($loggedin) {
    echo "I hear you like books.";
}

require_once 'footer.php';
?>
