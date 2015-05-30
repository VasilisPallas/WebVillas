<?php

require('con_is_logged_in.php'); 
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_GET['id'],$_POST)) {
    if ($_FILES['mainphoto']['name'] != "") {
        try {
            require('params.php');
            $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
            $pdoObject->exec('set names utf8');
            $sql = 'SELECT mainImageName FROM villas WHERE villaID=:villaid LIMIT 1;';
            $statement = $pdoObject->prepare($sql);
            $statement->execute(array(':villaid' => $_GET['id']));
            if ($record = $statement->fetch()) {
                $filePath = 'villasprofileimages/';
                $fileDelResult = unlink($filePath . $record[0]);
            }
        } catch (PDOException $e) {
            header('Location: index.php?msg=Αδύνατη η σύνδεση με τον server');
            exit();
        }
        /////////////////////////////////////////////////////////////////////////////////////////////
        $filename = $_FILES['mainphoto']['name'];
        $ext = strtolower(substr($filename, -3));
        $new_filename = uniqid("villasprifileimage-", true) . '.' . $ext;
        $copied = copy($_FILES['mainphoto']['tmp_name'], 'villasprofileimages/' . $new_filename);
    } else {
        try {
            require('params.php');
            $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
            $pdoObject->exec('set names utf8');
            $sql = 'SELECT mainImageName FROM villas WHERE villaID=:villaid LIMIT 1;';
            $statement = $pdoObject->prepare($sql);
            $statement->execute(array(':villaid' => $_GET['id']));
            if ($record = $statement->fetch()) {
                $new_filename = $record[0];
            }
        } catch (PDOException $e) {
            header('Location: index.php?msg=Αδύνατη η σύνδεση με τον server');
            exit();
        }
    }


    if (isset($_POST['garage'])) {
        $garage = 1;
    } else
        $garage = 0;


    if (isset($_POST['wifi'])) {
        $wifi = 1;
    } else
        $wifi = 0;



    if (isset($_POST['pool'])) {
        $pool = 1;
    } else
        $pool = 0;


    if (isset($_POST['jacuzzi'])) {
        $jacuzzi = 1;
    } else
        $jacuzzi = 0;

    if (isset($_POST['spa'])) {
        $spa = 1;
    } else
        $spa = 0;

    if (isset($_POST['gym'])) {
        $gym = 1;
    } else
        $gym = 0;

    if (isset($_POST['comments'])) {
        $comments = $_POST['comments'];
    } else
        $comments = '';

    try {
        require('params.php');
        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject->exec('set names utf8');

        $sql = "UPDATE villas SET villasName=:villasname,coords=:coords,area=:area,address=:address,addressNumber=:addressno,postalCode=:postalcode,telephone=:telephone,mobilePhone=:mobilephone,squareMeter=:squaremeter,price=:price,capacity=:capacity,garage=:garage,wifi=:wifi,pool=:pool,jacuzzi=:jacuzzi,spa=:spa,gym=:gym,rating=:rating,villasDescr=:comments,mainImageName=:imagename WHERE users_username=:username AND villaID=:villaid ;";
        $statement = $pdoObject->prepare($sql);
        $myResult = $statement->execute(array(':villasname' => $_POST['villaname'],
            ':area' => $_POST['area'],
            ':address' => $_POST['address'],
            ':addressno' => $_POST['addressno'],
            ':postalcode' => $_POST['postalcode'],
            ':telephone' => $_POST['telephone'],
            ':mobilephone' => $_POST['mobilephone'],
            ':squaremeter' => $_POST['squaremeter'],
            ':price' => $_POST['price'],
            ':capacity' => $_POST['capacity'],
            ':garage' => $garage,
            ':wifi' => $wifi,
            ':pool' => $pool,
            ':jacuzzi' => $jacuzzi,
            ':coords' => $_POST['coords'],
            ':spa' => $spa,
            ':gym' => $gym,
            ':rating' => $_POST['rating'],
            ':comments' => $comments,
            ':imagename' => $new_filename,
            ':username' => $_SESSION['username'],
            'villaid' => $_GET['id']));
        $statement->closeCursor();
        $pdoObject = null;
        header('Location: userpage.php');
        exit();
    } catch (PDOException $e) {
        header('Location: index.php?msg=Αδύνατη η σύνδεση με τον server');
        exit();
    }
} else {
    header('Location: index.php?msg=Ta dedomena den einai swsta');
    exit();
}
?>

