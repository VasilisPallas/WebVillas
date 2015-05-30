<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $area = $_POST['area'];
    $i = 0;
    try {


        require('params.php');

        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject->exec('set names utf8');
        $sql = "Select * from villas where area like '%$area%'";
        $statement = $pdoObject->query($sql);
        while ($record = $statement->fetch()) {
            $i++;
        }
    } catch (PDOException $e) {
        header('Location: index.php?msg = Αδύνατη η σύνδεση με τον server');
        exit();
    }
} else {
    header('Location: index.php?msg = Ta dedomena den einai swsta');
    exit();
}
?>