<?php

session_start();
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    require('params.php');

    if (!isset($_GET['area']))
        die('ERROR: Please provide a area.');
    else
        $area = $_GET['area'];


//database tasks       
    try {
//σύνδεση σε database μέσω PDO library 
        $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject->exec('set names utf8');
//SQL ερώτημα παραμετροποιημένο σύμφωνα με PDO στη στήλη businesses.categoryID
        $sql = "SELECT *
           FROM villas INNER JOIN users ON villas.users_username = users.username
           WHERE villas.area like '%$area%' 
           ORDER BY villasName ASC";

        $statement = $pdoObject->query($sql);


        header("Content-Type: text/xml; charset=UTF-8");


        echo '<?xml version="1.0" encoding="UTF-8"?' . '>' . "\r\n";
        echo '<villas>';   //το root στοιχείο του XML
//εδώ αρχίζει το loop κατανάλωσης των αποτελεσμάτων του SQL query
        while ($record = $statement->fetch()) {

            if ($record['garage'] == 1) {
                $garage = 'Ναι';
            } else {
                $garage = 'Όχι';
            }

            if ($record['wifi'] == 1) {
                $wifi = 'Ναι';
            } else {
                $wifi = 'Όχι';
            }

            if ($record['pool'] == 1) {
                $pool = 'Ναι';
            } else {
                $pool = 'Όχι';
            }

            if ($record['jacuzzi'] == 1) {
                $jacuzzi = 'Ναι';
            } else {
                $jacuzzi = 'Όχι';
            }

            if ($record['spa'] == 1) {
                $spa = 'Ναι';
            } else {
                $spa = 'Όχι';
            }

            if ($record['gym'] == 1) {
                $gym = 'Ναι';
            } else {
                $gym = 'Όχι';
            }

            echo "\r\n" . '<villa id="' . $record['villaID'] . '" username="' . $record['users_username'] . '">';
            echo "\r\n" . '<villasName>' . $record['villasName'] . '</villasName>';
            echo "\r\n" . '<area>' . $record['area'] . '</area>';
            echo "\r\n" . '<address>' . $record['address'] . '</address>';
            echo "\r\n" . '<addressNumber>' . $record['addressNumber'] . '</addressNumber>';
            echo "\r\n" . '<postalCode>' . $record['postalCode'] . '</postalCode>';
            echo "\r\n" . '<telephone>' . $record['telephone'] . '</telephone>';
            echo "\r\n" . '<mobilePhone>' . $record['mobilePhone'] . '</mobilePhone>';
            echo "\r\n" . '<squareMeter>' . $record['squareMeter'] . '</squareMeter>';
            echo "\r\n" . '<price>' . $record['price'] . '</price>';
            echo "\r\n" . '<capacity>' . $record['capacity'] . '</capacity>';
            echo "\r\n" . '<garage>' . $garage . '</garage>';
            echo "\r\n" . '<wifi>' . $wifi . '</wifi>';
            echo "\r\n" . '<pool>' . $pool . '</pool>';
            echo "\r\n" . '<jacuzzi>' . $jacuzzi . '</jacuzzi>';
            echo "\r\n" . '<spa>' . $spa . '</spa>';
            echo "\r\n" . '<gym>' . $gym . '</gym>';
            echo "\r\n" . '<rating>' . $record['rating'] . '</rating>';
            echo "\r\n" . '<coords>' . $record['coords'] . '</coords>';
            echo "\r\n" . '<villasDescr>' . $record['villasDescr'] . '</villasDescr>';
            echo "\r\n" . '</villa>';
        }
//κλείνουμε και το root element
        echo '</villas>';
//απόσύνδεση από database    
        $statement->closeCursor();
        $pdoObject = null;
    } catch (PDOException $e) {
        die("PDOException: " . $e->getMessage());
    }
} else {
    header('Location: verification.php?msg=ta dedomena den einai swsta');
    exit();
}
?>
