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
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="author" content="Vasilis Pallas, Maria Konovesi">
        <?php require('style1.php'); ?>
        <title>Καλωσήρθατε στο WebVillas - Αναζητήστε την βίλα της αρεσκεία σας για τις διακοπές σας ή ανεβάστε την δικιά σας βίλα ώστε να μπορούν να την αναζητήσουν οι επικέπτες της σελίδας!</title>
    </head>
    <body>
        <a name="top"></a>
        <div id="header">
            <!-- Αν έχει συνδεθεί εμφανίζει δεξιά κουμπί για να πηγαίνει στην userpage και κουμπί για αποσύνδεση -->
            <?php if (isset($_SESSION['username'])) { ?>
                <div class="userbutton" style="margin: 15px 50px 0 0;">
                    <a href="con_logout.php" style=" color: white;">Αποσύνδεση</a>
                </div>
                <div  style="float: right; margin: 4px 5px 0 0;">
                    <p style="color: white; cursor: default;">|</a>
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

            <!-- Οι εικόνες που περνάνε στην Homepage -->
            <div class="imagesslide">
                <script>
                    $(function() {
                        $(".rslides").responsiveSlides();
                    });
                </script>
                <ul class="rslides">
                    <li><img src="images/villa.png"></li>
                    <li><img src="images/villa2.png" alt=""></li>
                    <li><img src="images/villa3.png" alt=""></li>
                    <li><img src="images/villa4.png" alt=""></li>
                    <li><img src="images/villa5.png" alt=""></li>
                    <li><img src="images/villa6.png" alt=""></li>
                </ul>
            </div>



            <div class="hypericon" onclick="menuhide()">
                <a href="index.php"><img src="images/logoimage.png" title="WebVillas" alt="WebVillas"/></a>
                <a href="#"  alt="style 1" title="style 1"><img id="style1" src="images/style1.png"/></a>
                <a href="#"  alt="style 2" title="style 2"><img id="style2" src="images/style2.png"/></a>
            </div>

        </div>

        <div class="search" id="search" onclick="menuhide()">
            <?php require('search_form.php'); ?>
        </div>


        <div class="results" id="results" name="results">
            <a href="getresults.php?area=Σαντορίνη">
                <div id="autoresults">
                    <img src="autoresultimages/santorini.jpg"/>
                    <p>Διακοπές στην Σαντορίνη</p>
                </div>
            </a>
            <a href="getresults.php?area=Μύκονος">
                <div id="autoresults">
                    <img src="autoresultimages/mukonos.jpg"/>
                    <p>Διακοπές στην Μύκονο</p>
                </div>
            </a>
            <a href="getresults.php?area=Ρόδος">
                <div id="autoresults">
                    <img src="autoresultimages/rodos.jpg"/>
                    <p>Διακοπές στην Ρόδο</p>
                </div>
            </a>
            <a href="getresults.php?area=Κως">
                <div id="autoresults">
                    <img src="autoresultimages/kws.jpg"/>
                    <p>Διακοπές στη Κω</p>
                </div>
            </a>
            <a href="getresults.php?area=Αιγαίο">
                <div id="autoresults">
                    <img src="autoresultimages/aigaio.jpg"/>
                    <p>Διακοπές στο Αιγαίο</p>
                </div>
            </a>
            <a href="getresults.php?area=Κέρκυρα">
                <div id="autoresults">
                    <img src="autoresultimages/kerkura.jpg"/>
                    <p>Διακοπές στην Κέρκυρα</p>
                </div>
            </a>
            <a href="getresults.php?area=Ζάκυνθος">
                <div id="autoresults">
                    <img src="autoresultimages/zakunthos.JPG"/>
                    <p>Διακοπές στην Ζάκυνθο</p>
                </div>
            </a>
            <a href="getresults.php?area=Ιόνιο">
                <div id="autoresults">
                    <img src="autoresultimages/ionio.jpg"/>
                    <p>Διακοπές στο Ιόνιο</p>
                </div>
            </a>
            <a href="getresults.php?area=Κρήτη">
                <div id="autoresults">
                    <img src="autoresultimages/krhth.jpg"/>
                    <p>Διακοπές στην Κρήτη</p>
                </div>
            </a>
        </div>
        <input id="visibility_check" style="visibility:hidden;" type="checkbox" />
        <div class="backtotop"> <a href="#top"> <img src="images/backtotop.png"/> </a> </div>
        <div class="footer">
            <p id="footer_menu">&copy; 2014 - WebVillas | <a href="a.html">Policy Privacy</a> | <a href="b.html">Επικοινωνία</a></p>
            <p id="design">..:: design: V.Pallas, M.Konovesi ::..</p>
        </div>
    </body>
</html>