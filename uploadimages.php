<?php
session_start();
// Loop $_FILES to exeicute all files
foreach ($_FILES['files']['name'] as $f => $name) {
    $ext = strtolower(substr($name, -3));
    $new_filename = uniqid("villasgalleryimage-", true) . '.' . $ext;
    if ($ext == "jpg") {
        move_uploaded_file($_FILES["files"]["tmp_name"][$f], 'villasimages/' . $new_filename);

        ///////////////////////////////////////////////////////////////////////////////////////////////

        try {

           // $user = 'vasipall';

            require('params.php');
            $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
            $pdoObject->exec('set names utf8');
            $sql = 'INSERT INTO photos (photoName,villas_villaID,villas_users_username)
                    VALUES (:photoname,:villaID,:user)';
            $statement = $pdoObject->prepare($sql);
            $myResult = $statement->execute(array(':photoname' => $new_filename,
                ':villaID' => $_GET['id'],
                ':user' => $_SESSION['username']));
            $statement->closeCursor();
            $pdoObject = null;
        } catch (PDOException $e) {
            header('Location: index.php?msg=Αδύνατη η σύνδεση με τον server');
            exit();
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////
    }
}
if ($myResult) {
    header('Location: editphotosgallery.php?id=' . $_GET['id']);
    exit();
} else {
    header('Location: editphotosgallery.php?ERROR');
    exit();
}
?>