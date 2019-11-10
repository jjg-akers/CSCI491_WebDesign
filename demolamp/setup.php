<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Database Setup</title>
</head>

<body>
    <h3>Setting up...</h3>

<?php
require_once 'functions.php';

createTable('members',
            'user VARCHAR(16),
            pass VARCHAR(16),
            INDEX(user(6))');

createTable('messages',
            'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            auth VARCHAR(16),
            recip VARCHAR(16),
            pm CHAR(1),
            time INT UNSIGNED,
            message VARCHAR(4096),
            bookTitle VARCHAR(80),
            bookAutor VARCHAR(80),
            INDEX(auth(6)),
            INDEX(recip(6))');

createTable('friends',
            'user VARCHAR(16),
            friend VARCHAR(16),
            INDEX(user(6)),
            INDEX(friend(6))');

createTable('profiles',
            'user VARCHAR(16),
            text VARCHAR(4096),
            favBook VARCHAR(80),
            favGenre VARCHAR(80),
            currentBookAuthor VARCHAR(80),
            bookGoal INT,
            bookGoalProgress INT,
            yourStore VARCHAR(80),
            city VARCHAR(80),
            state CHAR(2),
            zipCode CHAR(5),
            INDEX(user(6))');
            
createTable('bookStores',
            'name VARCHAR(80),
            link VARCHAR(80),
            city VARCHAR(80),
            state CHAR(2),
            INDEX(state(2))');
?>

    <p>The database is ready to go.</p>
</body>
</html>
