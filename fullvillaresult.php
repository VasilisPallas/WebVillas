<?php
session_start();
if (!isset($_GET['villaID'])) {
    header('Location: index.php?msg=Δεν στάλθηκαν οι πληροφορίες της βίλας');
    exit();
}

if (isset($_SESSION['username'])) {
    try {
        require('params.php');
        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject->exec('set names utf8');
        $sql = 'SELECT firstName,surName FROM users WHERE username=:username;';
        $statement = $pdoObject->prepare($sql);
        $statement->execute(array(':username' => $_SESSION['username']));
        while ($record = $statement->fetch()) {
            $userfirstname = $record['firstName'];
            $usersurname = $record['surName'];
        }
    } catch (PDOException $e) {
        header('Location: index.php?msg=Αδύνατη η σύνδεση με τον server');
        exit();
    }
}
?>


<?php
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET)) {

    try {
        require('params.php');
        $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject->exec('set names utf8'); //SQL ερώτημα παραμετροποιημένο σύμφωνα με PDO στη στήλη businesses.categoryID
        $sql = "SELECT * FROM villas  WHERE villas.villaID = :villaID ORDER BY villasName ASC LIMIT 1";

        $statement = $pdoObject->prepare($sql);

        $statement->execute(array(':villaID' => $_GET['villaID']));

        if ($record = $statement->fetch()) {
            $villaname = $record['villasName'];
            $villasdescr = $record['villasDescr'];
            $postalcode = $record['postalCode'];
            $squaremeter = $record['squareMeter'];
            $capacity = $record['capacity'];
            $rating = $record['rating'];
            $telephone = $record['telephone'];
            if ($record['mobilePhone'] != "") {
                $mobilephone = $record['mobilePhone'];
            } else {
                $mobilephone = '-';
            }
            $price = $record['price'];
            $coords = $record['coords'];
            list($Lat, $Long) = explode(',', $coords);
            $newLat = (float) $Lat;
            $newLong = (float) $Long;

            $sql = "SELECT firstName, surName FROM users  WHERE username = :username LIMIT 1";

            $statement = $pdoObject->prepare($sql);

            $statement->execute(array(':username' => $record['users_username']));
            if ($record1 = $statement->fetch()) {
                $firstname = $record1['firstName'];
                $surname = $record1['surName'];

                $area = str_replace(array('Θράκη-', 'Έβρος-', 'Ροδόπη-', 'Μακεδονία-', 'Χαλκιδική-', 'Πέλλα-', 'Ημαθία-', 'Πιερία-', 'Θεσσαλία-', 'Μαγνησία-', 'Ήπειρος-', 'Θεσπρωτία-', 'Στερεά Ελλάδα-', 'Αττική-', 'Βοιωτία-', 'Φθιώτιδα-', 'Φωκίδα-', 'Αιτωλοακαρνανία-', 'Ευρυτανία-', 'Εύβοια-', 'Πελοπόννησος-', 'Αχαΐα-', 'Ηλεία-', 'Αρκαδία-', 'Αργολίδα-', 'Μεσσηνία-', 'Λακωνία-', 'Αιγαίο-', 'Κυκλάδες-', 'Δωδεκάνησα-', 'Ιόνιο-', 'Κρήτη-'), '', $record['area']);


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

                $address = $record['address'] . ' ' . $record['addressNumber'];

                $fullname = $firstname . ' ' . $surname;
            }
        }
    } catch (Exception $ex) {
        header('Location: fullvillaresult.php?msg=Αδύνατη η σύνδεση με τον server');
        exit();
    }
} else {
    header('Location: fullvillaresult.php?msg=Ta dedomena den stalthikan swsta');
    exit();
}
?>


<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <?php require('style1.php'); ?>
        <link href="css/lightbox.css" rel="stylesheet" />
        <script src="javascript/lightbox.min.js"></script>

        <title><?php echo $record['villasName'] ?></title>

        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBzsksClNr1SdvprMZYGY29cPnTv0QodR0"></script>	
        <script type="text/javascript">
            var map;
            //var Lat= new Number();
            //Lat = '<? echo $newLat;?>';
            //var Long = new Number();
            //Long='<? echo $newLong;?>';
            var Lat = '<?php echo $newLat ?>';
            var Long = '<?php echo $newLong ?>';
            var myCenter = new google.maps.LatLng(Lat, Long);
            var marker;

            function initialize() {
                var mapProp = {
                    center: myCenter,
                    zoom: 16,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };

                var map = new google.maps.Map(document.getElementById("map-canvas"), mapProp);

                marker = new google.maps.Marker({
                    position: myCenter,
                    draggable: false,
                    icon: 'images/pin.png'
                });

                marker.setMap(map);

                google.maps.event.addListener(marker, "drag", function() {
                    document.getElementById("grid").value = marker.position.toUrlValue();
                });
            }

            google.maps.event.addDomListener(window, 'load', initialize);
        </script>

    </head>
    <body>
        <div id="header">
            <!-- Αν έχει συνδεθεί εμφανίζει δεξιά κουμπί για να πηγαίνει στην userpage και κουμπί για αποσύνδεση -->
            <?php if (isset($_SESSION['username'])) { ?>
                <div class="userbutton" style="margin: 15px 50px 0 0;">
                    <a href="con_logout.php" style=" color: white;">Αποσύνδεση</a>
                </div>
                <div style="float: right; margin: 4px 5px 0 0;">
                    <p style=" color: white; cursor: default;">|</a>
                </div>
                <div class="userbutton" style="margin: 15px 5px 0 0;">
                    <a href="userpage.php" style=" color: white;"><?php echo "$userfirstname " . "$usersurname" ?></a>
                </div>
            <?php } ?>


            <div class="hypericon" onclick="menuhide()">
                <a href="index.php"><img src="images/logoimage.png" title="WebVillas" alt="WebVillas"/></a>
                <a href="#"  alt="style 1" title="style 1"><img id="style1" src="images/style1.png"/></a>
                <a href="#"  alt="style 2" title="style 2"><img id="style2" src="images/style2.png"/></a>
            </div>

        </div>

        <div id="fullresult">

            <?php
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                try {
                    require('params.php');
                    $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
                    $pdoObject->exec('set names utf8'); //SQL ερώτημα παραμετροποιημένο σύμφωνα με PDO στη στήλη businesses.categoryID
                    $sql = "SELECT * FROM photos  WHERE villas_villaID = :villaID";

                    $statement = $pdoObject->prepare($sql);

                    $statement->execute(array(':villaID' => $_GET['villaID']));
                    $results = $statement->rowCount();
                    while ($record = $statement->fetch()) {
                        echo '<a alt="' . $record['photoDescr'] . '" title="' . $record['photoDescr'] . '" href="villasimages/' . $record['photoName'] . '" data-lightbox="images"><img alt="' . $record['photoDescr'] . '" title="' . $record['photoDescr'] . '" src="villasimages/' . $record['photoName'] . '" style="width:100px; height:70px; margin: 20px 0 0 20px;"/></a>';
                    }
                    if ($results > 0) {
                        echo'<hr/>';
                    }
                } catch (Exception $ex) {
                    header('Location: fullvillaresult.php?msg=Αδύνατη η σύνδεση με τον server');
                    exit();
                }
            } else {
                header('Location: fullvillaresult.php?msg=Ta dedomena den stalthikan swsta');
                exit();
            }
            ?>

            <?php if ($villasdescr != "") { ?>
                <div style="margin: 20px 0 20px 20px;">
                    <p>Περιγραφή</p>
                    <?php echo $villasdescr ?>
                </div>
                <hr/>
            <?php } ?>

            <a href="villas_xml.php?area=<?php echo $area ?>" class="" style="float:right; margin:0 260px 0 0;">Xml Μορφή</a>


            <div id="map-canvas" style="margin:40px 0 0 30px; width: 400px; height: 400px; float: left; background-color: black;"></div>

            <table style=" width:30%; background-color: orange; margin: 40px auto; border-radius: 5px; ">
                <tr>
                    <td colspan="2" style="width: 100px; padding: 0 100px 0 100px; font-size: 1.5em;"><?php echo $villaname ?></td>
                </tr>
                <tr>
                    <td >Περιοχή</td>
                    <td><?php echo $area ?></td>
                </tr>
                <tr>
                    <td >Διεύθυνση</td>
                    <td><?php echo $address ?></td>
                </tr>

                <tr>
                    <td>Τ.Κ</td>
                    <td><?php echo $postalcode ?></td>
                </tr>

                <tr>
                    <td style="width:140px;">Τετραγωνικά μέτρα</td>
                    <td><?php echo $squaremeter ?> τ.μ</td>
                </tr>  

                <tr>
                    <td>Χωρητικότητα</td>
                    <td><?php echo $capacity ?> άτομα</td>
                </tr>

                <tr>
                    <td>Γκαράζ</td>
                    <td><?php echo $garage ?></td>
                </tr>

                <tr>
                    <td>Wi-fi</td>
                    <td><?php echo $wifi ?></td>
                </tr>

                <tr>
                    <td>Πισίνα</td>
                    <td><?php echo $pool ?></td>
                </tr>

                <tr>
                    <td>Τζακούζι</td>
                    <td><?php echo $jacuzzi ?></td>
                </tr>

                <tr>
                    <td>Σπα</td>
                    <td><?php echo $spa ?></td>
                </tr>


                <tr>
                    <td>Γυμναστήριο</td>
                    <td><?php echo $gym ?></td>
                </tr>

                <tr>
                    <td>Αξιολόγιση</td>
                    <td><?php echo $rating ?> αστέρια</td>
                </tr>

                <tr>
                    <td>Τηλέφωνο</td>
                    <td><?php echo $telephone ?></td>
                </tr>

                <tr>
                    <td>Κινητό</td>
                    <td><?php echo $mobilephone ?></td>
                </tr>

                <tr>
                    <td>Τιμή</td>
                    <td><?php echo $price ?> &euro;</td>
                </tr>

                <tr>
                    <td style=" padding-bottom: 10px;">Όνομα ιδιοκτήτη</td>
                    <td><?php echo $fullname ?></td>
                </tr>

            </table>

        </div>

    </body>
</html>