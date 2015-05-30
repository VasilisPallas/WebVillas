<?php

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET)) {
//μόλις στείλουμε στον χρήστη τον κωδικό ελέγχουμε εαν ο χρήστης ΔΕΝ
// είναι συνδεμένος ΚΑΙ αν έχει σταλεί το email του με GET για να παρουμε
//  το username του και τον password του για να τον συνδέσουμε
    if (!isset($_SESSION['username']) && isset($_GET['email'])) {
        $email = $_GET['email'];
    } else {
        header('Location: index.php?msg=Error');
        exit();
    }
    $results = 0;
    try {
        require('params.php');
        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject->exec('set names utf8');
        $sql = 'SELECT * FROM users WHERE email=:email AND active=1 LIMIT 1;';
        $statement = $pdoObject->prepare($sql);
        $statement->execute(array(':email' => $_GET['email']));
        $results = $statement->rowCount();
        while ($record = $statement->fetch()) {
            $username = $record['username'];
            $password = $record['password'];
        }
        //Αν βρει αποτέλεσμα τον κάνει login

        if ($results > 0) {
            session_destroy();
            session_start();
            $_SESSION['username'] = $username;
            header('Location: index.php');
            exit();
        } else {
            header('Location: index.php?msg=ERROR');
            exit();
            $statement->closeCursor();
            $pdoObject = null;
        }
    } catch (PDOException $e) {
        header('Location: index.php?msg=Αδύνατη η σύνδεση με τον server');
        exit();
    }
} else {
    header('Location: index.php?msg=Ta dedomena den einai swsta');
    exit();
}
?>