<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="author" content="Vasilis Pallas, Maria Konovesi">
        <title></title>
        <?php require('style1.php'); ?>
    </head>
    <body style="background-color:#FEBA02">
        <div id="header">
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
        <div class="unathaurorizedmessage">
            <h1>HTTP Error 401.2 - Unauthorized</h1>
            <h2>Η συνδεσή σας έλειξε.</h2>
            <h2>Παρακαλούμε κάντε κλικ <a onclick="menushow()">εδώ για να συνδεθείτε</a></h2>
        </div>
        <input id="visibility_check" style="visibility:hidden;" type="checkbox" />
    </body>
</html>
