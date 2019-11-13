<?php
require_once 'header.php';

if (!$loggedin) {
    echo "<h3>Log in to view members</h3>";
    die(require 'footer.php');
}

if (isset($_GET['view'])) {

    $view = sanitizeString($_GET['view']);

    if ($view == $user)
        $name = "Your";
    else
        $name = "$view's";
    echo"<div id='homeprofile'>";
    echo "<h3>$name Profile</h3>";
    showProfile($view);
    echo "<a href='messages.php?view=$view'>View $name messages</a></div>";
    
    echo "<div id='hidden'></div>";
    // **** Move messages here
    echo "<div id='messagesOuter'>";

    echo "<div id='messagesContainer'>";
        echo "<h3 id='messagesTitle'>$name1 Messages</h3>";
        date_default_timezone_set('UTC');
        
        $query  = "SELECT * FROM messages WHERE recip='$view' ORDER BY time DESC LIMIT 5";
        $result = queryMysql($query);
        $num    = $result->num_rows;
    
        for ($j = 0 ; $j < $num ; ++$j)
        {
          $row = $result->fetch_array(MYSQLI_ASSOC);
            
            // save the time
            //if ($messageDate != NULL){
            $_SESSION["messageDate"] = $row['time'];
            echo $_SESSION['messageDate'];
            

          if ($row['pm'] == 0 || $row['auth'] == $user || $row['recip'] == $user) {
              echo "<div class=messageContent>";
              echo date('M jS \'y g:ia:', $row['time']);
              echo " <a href='messages.php?view=" . $row['auth'] . "'>" . $row['auth']. "</a> ";

              if ($row['pm'] == 0)
                  echo "wrote a <em>public post</em>:<div>&quot;" . $row['message'] . "&quot; ";
              else
                  echo "wrote a <em>private note</em>:<br><div>&quot;" . $row['message']. "&quot; ";

              if ($row['recip'] == $user)
                  echo "[<a href='messages.php?view=$view" . "&erase=" . $row['id'] . "'>Delete</a>]";
              echo "</div>";
              echo "</div>";
          }
        }
    echo "</div>";
        
        
        
    //    mysql> SELECT * FROM (
    //    ->     SELECT * FROM Last10RecordsDemo ORDER BY id DESC LIMIT 10
    //    -> )Var1
    //    ->
    //    -> ORDER BY id ASC;

        
        // -----------

    
    
    
    
    
    
    
    
    
    
    
    die(require 'footer.php');
}

if (isset($_GET['add'])) {
    $add = sanitizeString($_GET['add']);

    $result = queryMysql("SELECT * FROM friends WHERE user='$add' AND friend='$user'");
    if (!$result->num_rows)
    queryMysql("INSERT INTO friends VALUES ('$add', '$user')");
} 
elseif (isset($_GET['remove'])) {
    $remove = sanitizeString($_GET['remove']);
    queryMysql("DELETE FROM friends WHERE user='$remove' AND friend='$user'");
}

$result = queryMysql("SELECT user FROM members ORDER BY user");
$num    = $result->num_rows;

echo "<h3>Members: $clubstr</h3><ul>";

for ($j = 0 ; $j < $num ; ++$j) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if ($row['user'] == $user)
        continue;

    echo "<li><a data-transition='slide' href='members.php?view=" .
    $row['user'] . "'>" . $row['user'] . "</a>";
    $follow = "follow";

    $result1 = queryMysql("SELECT * FROM friends WHERE user='" . $row['user'] . "' AND friend='$user'");
    $t1      = $result1->num_rows;
    $result1 = queryMysql("SELECT * FROM friends WHERE user='$user' AND friend='" . $row['user'] . "'");
    $t2      = $result1->num_rows;

    if (($t1 + $t2) > 1) 
        echo " &harr; is a mutual friend";
    elseif ($t1) 
        echo " &larr; you are following";
    elseif ($t2) { 
        echo " &rarr; is following you";
        $follow = "recip"; 
    }

    if (!$t1) 
        echo " [<a href='members.php?add=" . $row['user'] . "'>$follow</a>]";
    else
        echo " [<a href='members.php?remove=" . $row['user'] . "'>drop</a>]";
}
echo "</ul>";

require_once 'footer.php';
?>
