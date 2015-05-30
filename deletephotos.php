<?php

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['photoname'],$_GET['id'])) {
    $filePath = 'villasimages/';
    $fileDelResult = unlink($filePath . $_GET['photoname']);

    try {
        require('params.php');
        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject->exec('set names utf8');
        $sql = 'delete from photos where photoName=:photoname;';
        $statement = $pdoObject->prepare($sql);
        $statement->execute(array(':photoname' => $_GET['photoname']));
        header('Location: editphotosgallery.php?id=' . $_GET['id']);
        exit();
    } catch (Exception $ex) {
        header('Location: editphotosgallery.php?msg = Αδύνατη η σύνδεση με τον server');
        exit();
    }
} else {
    header('Location: editphotosgallery.php?msg = ta dedomena den stalthikan swsta');
    exit();
}
?>

