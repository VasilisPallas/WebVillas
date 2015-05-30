<?php

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_GET['id'],$_GET['photoid'])) {
    try {
        require('params.php');
        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject->exec('set names utf8');
        $sql = 'select * from photos where villas_villaID=:id and photoID=:photoID LIMIT 1;';
        $statement = $pdoObject->prepare($sql);
        $statement->execute(array(':id' => $_GET['id'], ':photoID' => $_GET['photoid']));
        //$results = $statement->rowCount();
        if ($record = $statement->fetch()) {
            $id = $record['photoID'];
            foreach ($_POST[$id] as $f) {
                $d = $f;
                try {
                    require('params.php');
                    $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
                    $pdoObject->exec('set names utf8');
                    $sql = "UPDATE photos SET photoDescr=:descr where photoID=:id";
                    $statement = $pdoObject->prepare($sql);   //
                    $myResult = $statement->execute(array(':descr' => $d, ':id' => $id));
                    $statement->closeCursor();
                    $pdoObject = null;
                } catch (PDOException $e) {
                    header('Location: index.php?msg=Αδύνατη η σύνδεση με τον server');
                    exit();
                }
            }
        }
        //  }
        if ($myResult) {
            header('Location: editphotosgallery.php?id=' . $_GET['id']);
            exit();
        }
    } catch (Exception $ex) {
        header('Location: editphotosgallery.php?msg=Αδύνατη η σύνδεση με τον server');
        exit();
    }
} else {
    header('Location: editphotosgallery.php?msg=Ta dedomena den einai swsta');
    exit();
}
?>
