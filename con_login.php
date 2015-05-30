<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {


//Αν ΔΕΝ έχει συνδεθεί ΚΑΙ αν στάλθηκε username και password, τότε αρχικοποιούμε
    if (!isset($_SESSION['username']) && isset($_POST['username'], $_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
    } else {
        header('Location: index.php?msg=Empty Fields');
        exit();
    }
    $results = 0;
    try {
        require('params.php');
        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject->exec('set names utf8');
        $sql = 'SELECT * FROM users WHERE username=:username AND active=1 LIMIT 1;';
        $statement = $pdoObject->prepare($sql);
        $statement->execute(array(':username' => $_POST['username']));
        $results = $statement->rowCount();
        //if γιατί περιμένουμε 1 αποτέλεσμα
        if ($record = $statement->fetch()) {
            $salt = $record['salt'];
            //κρυπτογραφούμε τον κωδικό που έδωσε ο χρήστης
            $encryptedpassword = crypt($_POST['password'], $salt);
        }
        //Αν βρει πάνω από 0 αποτελέσματα (δηλαδή 1) κάνει login, αλλιώς τον βγάζει error
        if ($results > 0) {
            //Αν ο κωδικός που έδωσε ο χρήστης κωδικοποιημένος είναι ίδιος με τον κωδικό της db -->record['password']; <--το αποτέλεσμα
            //από το sql query
            if ($encryptedpassword = $record['password']) {
                session_destroy();
                session_start();
                $_SESSION['username'] = $username;
                header('Location: userpage.php');
                exit();
            } else {
                header('Location: index.php?msg=lathos kwdikos');
                exit();
            }
        } else {
            header('Location: index.php?msg=lathos stoixeia');
            exit();
            $statement->closeCursor();
            $pdoObject = null;
        }
    } catch (PDOException $e) {
        header('Location: index.php?msg=Αδύνατη η σύνδεση με τον server');
        exit();
    }
} else {
    header('Location: index.php?msg=Ta dedomena den stalthikan swsta');
    exit();
}
?>