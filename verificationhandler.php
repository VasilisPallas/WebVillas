<?php

session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST)) {
    try {
        require('params.php');
        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject->exec('set names utf8');

        $sql = 'SELECT verificationCode,active FROM users WHERE email=:email';
        $statement = $pdoObject->prepare($sql);
        $myResult = $statement->execute(array(':email' => $_POST['email']));
        if ($record = $statement->fetch()) {
            $verificationcode = $record['verificationCode'];
            $active = $record['active'];
        }
        $statement->closeCursor();
        $pdoObject = null;
    } catch (PDOException $e) {
        header('Location: index.php?msg=Αδύνατη η σύνδεση με τον server');
        exit();
    }

    if (($_SESSION['security_code'] == $_POST['security_code']) && (!empty($_SESSION['security_code']))) {


        if ($_POST['verificationcode'] != "") {

//Αν ο κωδικός επικύρωσης της db είναι ίδιος με τον κωδικό που έγραψε ο χρήστης
            if ($_POST['verificationcode'] === $verificationcode) {

                $active = 1;
                try {
                    require('params.php');
                    $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
                    $pdoObject->exec('set names utf8');

                    $sql = "UPDATE users SET active=:active;";
                    $statement = $pdoObject->prepare($sql);
                    $myResult = $statement->execute(array(':active' => $active));
                    $statement->closeCursor();
                    $pdoObject = null;
                } catch (PDOException $e) {
                    header('Location: index.php?msg=Αδύνατη η σύνδεση με τον server');
                    exit();
                }

                if ($myResult) {
                    session_start();
                    //Αν έβαλε σωστό κωδικό επικύρωσης στέλνουμε το email του στην loginverification για να συνδέεται
                    try {
                        require('params.php');
                        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
                        $pdoObject->exec('set names utf8');

                        $sql = 'SELECT username,password FROM users WHERE email=:email LIMIT 1';
                        $statement = $pdoObject->prepare($sql);
                        $myResult = $statement->execute(array(':email' => $_POST['email']));
                        $results = $statement->rowCount();
                        if ($record = $statement->fetch()) {
                            $username = $record['username'];
                            $password = $record['password'];
                        }
                        $email = $_POST['email'];
                        if ($results > 0) {
                            header('Location: loginverification.php?email=' . $_POST['email']);
                            exit();
                        }

                        $statement->closeCursor();
                        $pdoObject = null;
                    } catch (PDOException $e) {
                        header('Location: index.php?msg=Αδύνατη η σύνδεση με τον server');
                        exit();
                    }

                    header('Location: index.php?');
                    exit();
                }
            } else {
                header('Location: index.php?msg=λαθος κωδικος επικυρωσης');
                exit();
            }
        } else {
            header('Location: verification.php?email=' . $_POST['email']);
            exit();
        }
    } else {
        header('Location: verification.php?email=' . $_POST['email']);
        exit();
    }
} else {
    header('Location: verification.php?email=Ta dedomena einai lathos');
    exit();
}
?>