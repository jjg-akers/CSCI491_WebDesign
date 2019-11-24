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
    
    <div id='bookStoreSearch'>
    

            <label for="currentStore" class='secretForm'>Select Bookstore: </label>
            <select id='currentStore' class='secretForm' name='currentStore'>
            </select>
            <button id='selection' class='secretForm'>Set</button>

    
        <div id='store'>
            <label for="site-search">Search For A Bookstore: </label>
            <input type="search" id="citySearch" name="citySearch" placeholder='Bozeman'
            aria-label="Search through site content">
            <select id='stateSearch' class=' name='stateSearch'>
            <option value="AL">Alabama</option>
            <option value="AK">Alaska</option>
            <option value="AZ">Arizona</option>
            <option value="AR">Arkansas</option>
            <option value="CA">California</option>
            <option value="CO">Colorado</option>
            <option value="CT">Connecticut</option>
            <option value="DE">Delaware</option>
            <option value="DC">District Of Columbia</option>
            <option value="FL">Florida</option>
            <option value="GA">Georgia</option>
            <option value="HI">Hawaii</option>
            <option value="ID">Idaho</option>
            <option value="IL">Illinois</option>
            <option value="IN">Indiana</option>
            <option value="IA">Iowa</option>
            <option value="KS">Kansas</option>
            <option value="KY">Kentucky</option>
            <option value="LA">Louisiana</option>
            <option value="ME">Maine</option>
            <option value="MD">Maryland</option>
            <option value="MA">Massachusetts</option>
            <option value="MI">Michigan</option>
            <option value="MN">Minnesota</option>
            <option value="MS">Mississippi</option>
            <option value="MO">Missouri</option>
            <option value="MT">Montana</option>
            <option value="NE">Nebraska</option>
            <option value="NV">Nevada</option>
            <option value="NH">New Hampshire</option>
            <option value="NJ">New Jersey</option>
            <option value="NM">New Mexico</option>
            <option value="NY">New York</option>
            <option value="NC">North Carolina</option>
            <option value="ND">North Dakota</option>
            <option value="OH">Ohio</option>
            <option value="OK">Oklahoma</option>
            <option value="OR">Oregon</option>
            <option value="PA">Pennsylvania</option>
            <option value="RI">Rhode Island</option>
            <option value="SC">South Carolina</option>
            <option value="SD">South Dakota</option>
            <option value="TN">Tennessee</option>
            <option value="TX">Texas</option>
            <option value="UT">Utah</option>
            <option value="VT">Vermont</option>
            <option value="VA">Virginia</option>
            <option value="WA">Washington</option>
            <option value="WV">West Virginia</option>
            <option value="WI">Wisconsin</option>
            <option value="WY">Wyoming</option>
            </select>
        </div>
        <button id='storeSearch'>Search</button>
        <div id='storeSet'>
        </div>
    </div>
    

    <br>
    
_END;

echo "<br><hr>";
echo "<h3>Your Current Profile</h3>";
showProfile($user);

require_once 'footer.php';
?>




