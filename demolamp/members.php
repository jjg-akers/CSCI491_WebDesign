<?php
require_once 'header.php';

if (!$loggedin) {
    echo "<h3>Log in to view members</h3>";
    die(require 'footer.php');
}

if (isset($_GET['view'])) {
    
    $view = sanitizeString($_GET['view']);
    $profileQuery = queryMysql("SELECT currentBookAuthor, bookGoal FROM profiles WHERE user = '$view'");
    $profileQuery = $profileQuery->fetch_array(MYSQLI_ASSOC);
    $book = $profileQuery['currentBookAuthor'];
    $goal = $profileQuery['bookGoal'];
    
    //$row = $result->fetch_array(MYSQLI_ASSOC);

    if ($view == $user)
        $name = "Your";
    else
        $name = "$view's";
    echo"<div id='homeprofile'>";
    echo "<h3>$name Profile</h3>
    <h4>Currently Reading: $book</h4>";
    showProfile($view);
    echo "<h4>Reading Goal: $goal</h4><br>";
    //echo "<a href='messages.php?view=$view'>View $name Reviews</a></div>";
    echo "</div>";
    
    
    // **** Move messages here
    echo "<div id='messagesOuter'>";
    if ($view != $user){
        echo "<h3 id='reviewTitle'>Reviews By " . $view . "</h3>";
    }

    echo "<div id='messagesContainer'>";
        echo "<h3 id='messagesTitle'>$name1</h3>";
        date_default_timezone_set('UTC');
    
        //  select * FROM messages INNER JOIN friends
        //  ON messages.auth = friends.user
        //  WHERE friend = me
        
        

    
        //  WHERE friends.friend = me
    // check who's page is being viewed. if user is viewing their home page, load their friends revies.
    // Else, if user if looking at someone else's profile, load the other person's posts
    if ($view == $user) {
        $query = "SELECT * FROM messages INNER JOIN friends ON messages.auth = friends.user WHERE friend = '$view' ORDER BY time DESC LIMIT 5";
    } else {
        $query  = "SELECT * FROM messages WHERE recip='$view' ORDER BY time DESC LIMIT 5";
    }
        
        $result = queryMysql($query);
        $num    = $result->num_rows;
    
        for ($j = 0 ; $j < $num ; ++$j)
        {
          $row = $result->fetch_array(MYSQLI_ASSOC);
            
            // save the time
            //if ($messageDate != NULL){
            $_SESSION["messageDate"] = $row['time'];
            //echo $_SESSION['messageDate'];
            

          if ($row['pm'] == 0 || $row['auth'] == $user || $row['recip'] == $user) {
              echo "<div class=messageContent>";
              echo date('M jS \'y g:ia', $row['time']);
              echo "<br>";
              //echo " <a href='messages.php?view=" . $row['auth'] . "'>" . $row['auth']. "</a> ";
              if ($view == $user){

                  echo " <a href='members.php?view=" . $row['auth'] . "'>" . $row['auth']. "</a> Reviewed:<br>";
              }

              echo "<div class='bookInfo'><span id='bookTitle'>" . $row['bookTitle'] .  " </span> " . " <span> by " . $row['bookAutor'] . "</span></div><div>&quot;" . $row['message'] . "&quot; ";
              
//              if ($row['pm'] == 0)
//                  echo "wrote a <em>Reviewed</em>:<div>&quot;" . $row['message'] . "&quot; ";
//              else
//                  echo "wrote a <em>private note</em>:<br><div>&quot;" . $row['message']. "&quot; ";

              if ($row['recip'] == $user)
                  echo "[<a href='messages.php?view=$view" . "&erase=" . $row['id'] . "'>Delete</a>]";
              echo "</div>";
              echo "</div>";
          }
        }
    echo "<div id='hidden'>$view</div>";
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
    
    //if i follow someone, user will get set to the person i am following,
    //  and i will get set to friend
    
    // so i want to pull alll user's where i am listed as friend.
    
    // pull all users where i am listed as friend, join that table
    //  on the user with messages table 'auth',
    // sort the results by date
    //  print results
    
    // SELECT * From messages JOIN friends 'user' = messages 'auth
    
    // SELECT user FROM friends WHERE friend = me
    //SELECT * FROM messages WHERE auth = the list above
    
    //  select * FROM messages INNER JOIN friends
    //  ON messages.auth = friends.user
    //  WHERE friend = me
    
    
    
    //  WHERE friends.friend = me

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
