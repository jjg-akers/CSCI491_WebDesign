<?php
 require_once 'header.php';

if (!$loggedin) die("</div></body></html>");

$result = queryMysql("SELECT * FROM profiles WHERE user='$user'");
    //$numberOfResults = $result->num_rows;
    $a = $result->fetch_array(MYSQLI_ASSOC);
    $texta = stripslashes($a['text']);
    $book = $a['currentBookAuthor'];
    $bookG = stripslashes($a['bookGoal']);


    //echo "<div> first result: number - $numberOfResults, text - $texta, book - $book, bookG $bookG </div>";
    
if (isset($_POST['text'])) {
    //echo "<div> in if isset for textfield</div>";
    $text = sanitizeString($_POST['text']);
    $text = preg_replace('/\s\s+/', ' ', $text);
    //echo "<div> text: $text </div>";

    if ($result->num_rows)
        queryMysql("UPDATE profiles SET text='$text' where user='$user'");
        //echo "<div> after query </div>";

    else queryMysql("INSERT INTO profiles (user, text) VALUES('$user', '$text')");
} 
else {
    if ($result->num_rows && texta != "") {
        //$row  = $result->fetch_array(MYSQLI_ASSOC);
        //$text = stripslashes($row['text']);
        $text = $texta;
    }
    else $text = "";
}
$text = stripslashes(preg_replace('/\s\s+/', ' ', $text));
    
// currently reading
if (($_POST['currentBook']) != "") {
    //echo "<div> in if isset </div>";
    $currentBook = sanitizeString($_POST['currentBook']);
    $currentBook = preg_replace('/\s\s+/', ' ', $currentBook);

    if ($result->num_rows)
        //$row = $result->fetch_array(MYSQLI_ASSOC);
        queryMysql("UPDATE profiles SET currentBookAuthor='$currentBook' where user='$user'");
        //echo "<div> after query </div>";

    else queryMysql("INSERT INTO profiles (user, currentBookAuthor) VALUES('$user', '$currentBook')");
}
else {
    if ($result->num_rows && $book != "") {
        //$row  = $result->fetch_array(MYSQLI_ASSOC);
        //$currentBook = stripslashes($row['currentBookAuthor']);
        $currentBook = stripslashes($book);

        //echo "<div> book: $currentBook </div>";
    }
    else $currentBook = "Enter A Book";
}

    //name='bookGoal'
// reading goal
if (($_POST['bookGoal']) != 0) {
    //echo "<div> in if isset bookGoal </div>";
    $bookGoal = sanitizeString($_POST['bookGoal']);
    $bookGoal = preg_replace('/\s\s+/', ' ', $bookGoal);

    if ($result->num_rows)
        //$row = $result->fetch_array(MYSQLI_ASSOC);
        queryMysql("UPDATE profiles SET bookGoal='$bookGoal' where user='$user'");
        //echo "<div> after query </div>";

    else queryMysql("INSERT INTO profiles (user, bookGoal) VALUES('$user', '$bookGoal')");
}
else {
    if ($result->num_rows && $bookG != "") {
        //$row  = $result->fetch_array(MYSQLI_ASSOC);
        //$bookGoal = stripslashes($row['bookGoal']);
        $bookGoal = stripslashes($bookG);

        //echo "<div> bookGoal: $bookGoal </div>";
    }
    else $bookGoal = 0;
}
    
// OLD COLD ********
//    if (isset($_POST['text'])) {
//        echo "<div> in if isset </div>";
//        $text = sanitizeString($_POST['text']);
//        $text = preg_replace('/\s\s+/', ' ', $text);
//        echo "<div> text: $text </div>";
//
//        if ($result->num_rows)
//            queryMysql("UPDATE profiles SET text='$text' where user='$user'");
//            //echo "<div> after query </div>";
//
//        else queryMysql("INSERT INTO profiles (user, text) VALUES('$user', '$text')");
//    }
//    else {
//        if ($result->num_rows) {
//            $row  = $result->fetch_array(MYSQLI_ASSOC);
//            $text = stripslashes($row['text']);
//        }
//        else $text = "";
//    }
//
//$text = stripslashes(preg_replace('/\s\s+/', ' ', $text));
//*******************

if (isset($_FILES['image']['name'])) {
    $saveto = "userpics/$user.jpg";
    move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
    $typeok = TRUE;

    switch($_FILES['image']['type']) {
        case "image/gif":   $src = imagecreatefromgif($saveto); break;
        case "image/jpeg":  // Both regular and progressive jpegs
        case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
        case "image/png":   $src = imagecreatefrompng($saveto); break;
        default:            $typeok = FALSE; break;
    }

    if ($typeok) {
        list($w, $h) = getimagesize($saveto);

        $max = 100;
        $tw  = $w;
        $th  = $h;

        if ($w > $h && $max < $w) {
            $th = $max / $w * $h;
            $tw = $max;
        }
        elseif ($h > $w && $max < $h) {
            $tw = $max / $h * $w;
            $th = $max;
        }
        elseif ($max < $w) {
            $tw = $th = $max;
        }

        $tmp = imagecreatetruecolor($tw, $th);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
        imageconvolution($tmp, array(array(-1, -1, -1), array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
        imagejpeg($tmp, $saveto);
        imagedestroy($tmp);
        imagedestroy($src);
    }
}

echo <<<_END
    <form method='post' action='profile.php' enctype='multipart/form-data'>
        <h3>Enter or edit your bio</h3>
        <textarea name='text'>$text</textarea><br>
        <label for='currentBook'>Currently Reading:</label>
        <input type='text' name='currentBook' placeholder='$currentBook'><br>
        <label for='bookGoal'>My Reading Goal:</label>
        <input type='text' name='bookGoal' placeholder='$bookGoal'> <br>
        <h3>Upload an image</h3>
        Image: <br>
        <input type='file' name='image' size='14'><br><br>
        <input type='submit' value='Save Profile'>
    </form>
_END;

echo "<br><hr>";
echo "<h3>Your Current Profile</h3>";
showProfile($user);

require_once 'footer.php';
?>




