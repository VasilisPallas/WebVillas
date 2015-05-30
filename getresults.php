<?php session_start(); ?>

<!-- Αν έχει κάνει login ο χρήστης, αποθηκεύουμε το Ονοματεπώνυμο του -->
<?php
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

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <?php include('style1.php') ?>
    </head>
    <body>

        <a name="top"></a>
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

        <div class="results">

            <?php
            if ($_SERVER['REQUEST_METHOD'] == "GET") {

                try {
                    $area = $_GET['area'];
                    require('params.php');
                    $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
                    $pdoObject->exec('set names utf8');
                    $sql = "Select * from villas where area like '%$area%';";
                    $statement = $pdoObject->query($sql);
                    $results = $statement->rowCount();
                    ?>
                    <div style="width: 100%; height: 20px;">
                        <?php if ($results == 1) { ?>
                            <p class="noofresults"><?php echo $results ?> Αποτέλεσμα</p>
                            <a href="villas_xml.php?area=<?php echo $area ?>" class="noofresults" style="margin-top:10px;" >Xml Αποτελέσματα</a>

                        <?php } else { ?>
                            <p class="noofresults"><?php echo $results ?> Αποτελέσματα</p>
                            <a href="villas_xml.php?area=<?php echo $area ?>" class="noofresults" style="margin-top:10px;">Xml Αποτελέσματα</a>
                        <?php } ?>
                    </div>
                    <?php
                    if ($results < 1) {
                        echo '<h2>No results found!</h2>';
                    } else {


                        try {
                            if (!isset($_GET['p'])) {
                                $p = 1;
                            } else {
                                $p = $_GET['p'];
                            }

                            $page = ($p - 1) * 4;
                            require('params.php');

                            $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
                            $pdoObject->exec('set names utf8');
                            $sql = "Select * from villas where area like '%$area%' limit $page,4;";
                            $statement = $pdoObject->query($sql);

                            while ($record = $statement->fetch()) {
                                $area = str_replace(array('Θράκη-', 'Έβρος-', 'Ροδόπη-', 'Μακεδονία-', 'Χαλκιδική-', 'Πέλλα-', 'Ημαθία-', 'Πιερία-', 'Θεσσαλία-', 'Μαγνησία-', 'Ήπειρος-', 'Θεσπρωτία-', 'Στερεά Ελλάδα-', 'Αττική-', 'Βοιωτία-', 'Φθιώτιδα-', 'Φωκίδα-', 'Αιτωλοακαρνανία-', 'Ευρυτανία-', 'Εύβοια-', 'Πελοπόννησος-', 'Αχαΐα-', 'Ηλεία-', 'Αρκαδία-', 'Αργολίδα-', 'Μεσσηνία-', 'Λακωνία-', 'Αιγαίο-', 'Κυκλάδες-', 'Δωδεκάνησα-', 'Ιόνιο-', 'Κρήτη-'), '', $record['area']);

                                echo '<div class="Villasresult" style="border:1px solid black; border-radius: 6px; background-color: wheat; width: 520px;height:180px; margin: 100px auto 0 auto;">
                <a href="fullvillaresult.php?villaID=' . $record['villaID'] . '" style="color: black; text-decoration: none;">
                    <img src="villasprofileimages/' . $record['mainImageName'] . '" style="margin: 15px 0 0 20px; float:left; width: 230px; height: 150px;"/>
                    <div class="villainfo" style=" float:left; margin:0 0 0 0; width: 265px; height: 150px;">
                        <p style="font-size: 1.4em; width: 270px; text-align: center;">' . $record['villasName'] . '</p>
                        <p style="font-size: 1.2em; margin: 15px 20px 0 20px;">Περιοχή: ' . $area . '</p>
                        <p style="font-size: 1.2em; margin: 15px 20px 0 20px;">Τιμή: ' . $record['price'] . '&euro;</p>
                        <p style="font-size: 1.2em; margin: 15px 20px 0 20px;">Χωρητικότητα: ' . $record['capacity'] . ' άτομα</p>
                    </div>
                </a>
            </div>';
                            }
                            if ($results > 5) {
                                $apot = $results / 4;
                                $x = ceil($apot);
                                echo '<ul style="margin:10px auto 0 auto; width:70px; height:30px;">';
                                for ($i = 1; $i <= $x; $i++) {
                                    echo ' <li style="display: inline;"><a href="getresults.php?area=' . $_GET['area'] . '&p=' . $i . '">' . $i . '</a></li>';
                                }
                                echo '</ul>';
                            }
                        } catch (PDOException $e) {
                            header('Location: index.php?msg = Αδύνατη η σύνδεση με τον server');
                            exit();
                        }
                    }
                } catch (PDOException $e) {
                    header('Location: index.php?msg = Αδύνατη η σύνδεση με τον server');
                    exit();
                }
            } else {
                header('Location: index.php?msg = ta dedomena den einai swsta');
                exit();
            }
            ?>

        </div>
    </body>
</html>
