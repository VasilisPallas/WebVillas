<!-- Έλεγχος άμα είναι συνδεμένος -->
<?php require('con_is_logged_in.php'); ?>

<!-- Αν είναι συνδεμένος αποθηκεύουμε το Ονοματεπώνυμο του -->
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
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="author" content="Vasilis Pallas, Maria Konovesi">
        <?php require('style1.php'); ?>
        <title><?php echo "$userfirstname " . "$usersurname" ?></title>
    </head>
    <body>
        <div id="header" style="position: fixed; top:0; left: 0; width: 100%;">
            <!-- Αν είναι συνδεμένος εμφανίζει το κουμπί για username και το κουμπί αποσύνδεσης -->
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



        <div class="uploadvilla">

            <?php
            //Αν είναι συνδεμένος
            if (isset($_SESSION['username'])) {
                try {
                    require('params.php');
                    $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
                    $pdoObject->exec('set names utf8');
                    $sql = 'SELECT * FROM villas INNER JOIN users ON users.username = villas.users_username where users_username=:user;';
                    $statement = $pdoObject->prepare($sql);
                    $statement->execute(array(':user' => $_SESSION['username']));
                    //Αν έχει βίλα την εμφανίζει
                    if ($record = $statement->fetch()) {
                        $area = str_replace(array('Θράκη-', 'Έβρος-', 'Ροδόπη-', 'Μακεδονία-', 'Χαλκιδική-', 'Πέλλα-', 'Ημαθία-', 'Πιερία-', 'Θεσσαλία-', 'Μαγνησία-', 'Ήπειρος-', 'Θεσπρωτία-', 'Στερεά Ελλάδα-', 'Αττική-', 'Βοιωτία-', 'Φθιώτιδα-', 'Φωκίδα-', 'Αιτωλοακαρνανία-', 'Ευρυτανία-', 'Εύβοια-', 'Πελοπόννησος-', 'Αχαΐα-', 'Ηλεία-', 'Αρκαδία-', 'Αργολίδα-', 'Μεσσηνία-', 'Λακωνία-', 'Αιγαίο-', 'Κυκλάδες-', 'Δωδεκάνησα-', 'Ιόνιο-', 'Κρήτη-'), '', $record['area']);
                        echo '<div class="Villasresult" style="border:1px solid black; border-radius: 6px; background-color: wheat; width: 520px;height:180px; margin: 100px auto 0 auto;">
                <a alt="Δείτε πως βλέπουν οι χρήστες την βίλα σας" title="Δείτε πως βλέπουν οι χρήστες την βίλα σας" href="fullvillaresult.php?villaID=' . $record['villaID'] . '" style="color: black; text-decoration: none;">
                    <img src="villasprofileimages/' . $record['mainImageName'] . '" style="margin: 15px 0 0 20px; float:left; width: 230px; height: 150px;"/>
                    <div class="villainfo" style=" float:left; margin:15px 0 0 0; width: 265px; height: 150px;">
                        <p style="font-size: 1.4em; width: 270px; text-align: center;">' . $record['villasName'] . '</p>
                        <p style="font-size: 1.2em; margin: 15px 20px 0 20px;">Περιοχή: ' . $area . '</p>
                        <p style="font-size: 1.2em; margin: 15px 20px 0 20px;">Τιμή: ' . $record['price'] . '&euro;</p>
                        <p style="font-size: 1.2em; margin: 15px 20px 0 20px;">Χωρητικότητα: ' . $record['capacity'] . ' άτομα</p>
                    </div>
                </a>
            </div>
            <a style="margin:10px 0 0 100px;" class="whitebutton" href="updatevilla.php?id=' . $record['villaID'] . '">Επεξεργασία Στοιχείων</a>
            <a style="margin:10px 0 0 20px;" class="whitebutton" href="editphotosgallery.php?id=' . $record['villaID'] . '">Επεξεργασία Φωτογραφιών</a>';
                    } else {//Αν δεν έχει βίλα εμφανίζει την φόρμα εισαγωγής
                        require('hellomessage.php');
                        require('uploadvilla_form.php');
                    }
                } catch (PDOException $e) {
                    header('Location: index.php?msg = Αδύνατη η σύνδεση με τον server');
                    exit();
                }
            }
            ?>
        </div>

    </body>
</html>
