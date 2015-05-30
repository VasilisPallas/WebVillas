<!-- Έλεγχος άμα είναι συνδεμένος -->
<?php require('con_is_logged_in.php'); ?>

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
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <?php require('style1.php'); ?>
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

            <!-- Αν ΔΕΝ έχει συνδεθεί εμφανίζει την επιλογη Συνδεση - Εγγραφή -->
            <?php if (!isset($_SESSION['username'])) { ?>
                <div class="tabs">
                    <div class="formsbutton"><a  href="#" onclick="visibility()">Σύνδεση ή Εγγραφή</a></div>

                    <div id="visibility_button"  style="color:white; visibility:hidden;">

                        <!-- the tabs -->
                        <ul class="css-tabs">
                            <li><a href="#">Συνδεθείτε</a></li>
                            <li><a href="#">Εγγραφείτε</a></li>
                        </ul>
                        <!-- tab "panes" -->
                        <div class="css-panes">
                            <div><?php require('login.php'); ?></div>
                            <div id="signupdiv" style="height: 350px;"><?php require('signup.php'); ?></div>
                        </div>
                        <script>
                            $(function() {
                                $("ul.css-tabs").tabs("div.css-panes > div");
                            });
                        </script>
                    </div>
                </div>
            <?php } ?>




            <div class="hypericon" onclick="menuhide()">
                <a href="index.php"><img src="images/logoimage.png" title="WebVillas" alt="WebVillas"/></a>
                <a href="#"  alt="style 1" title="style 1"><img id="style1" src="images/style1.png"/></a>
                <a href="#"  alt="style 2" title="style 2"><img id="style2" src="images/style2.png"/></a>
            </div>

        </div>

        <div class="updatevilla">
            <?php require('updatevilla_form.php'); ?>
        </div>
    </body>
</html>
