<?php
if (isset($_SESSION['username'])) {
    try {
        require('params.php');
        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject->exec('set names utf8');
        $sql = 'SELECT * FROM villas WHERE villaID=:id and users_username=:user;';
        $statement = $pdoObject->prepare($sql);
        $statement->execute(array(':id' => $_GET['id'], ':user' => $_SESSION['username']));
        if ($record = $statement->fetch()) {
            $villaname = $record['villasName'];
            $area = str_replace(array('Θράκη-', 'Έβρος-', 'Ροδόπη-', 'Μακεδονία-', 'Χαλκιδική-', 'Πέλλα-', 'Ημαθία-', 'Πιερία-', 'Θεσσαλία-', 'Μαγνησία-', 'Ήπειρος-', 'Θεσπρωτία-', 'Στερεά Ελλάδα-', 'Αττική-', 'Βοιωτία-', 'Φθιώτιδα-', 'Φωκίδα-', 'Αιτωλοακαρνανία-', 'Ευρυτανία-', 'Εύβοια-', 'Πελοπόννησος-', 'Αχαΐα-', 'Ηλεία-', 'Αρκαδία-', 'Αργολίδα-', 'Μεσσηνία-', 'Λακωνία-', 'Αιγαίο-', 'Κυκλάδες-', 'Δωδεκάνησα-', 'Ιόνιο-', 'Κρήτη-'), '', $record['area']);
            $address = $record['address'];
            $addressnumber = $record['addressNumber'];
            $postalcode = $record['postalCode'];
            $telephone = $record['telephone'];
            $mobilephone = $record['mobilePhone'];
            $squaremeter = $record['squareMeter'];
            $price = $record['price'];
            $coords = $record['coords'];
            $capacity = $record['capacity'];
            //stoixeia checkbox
            $garage = $record['garage'];
            $wifi = $record['wifi'];
            $pool = $record['pool'];
            $jacuzzi = $record['jacuzzi'];
            $spa = $record['spa'];
            $gym = $record['gym'];
            ///////////////////
            $rating = $record['rating'];
            $villasdescr = $record['villasDescr'];
        } else {
            header('Location: index.php?msg=den exete prosvasi');
            exit();
        }
    } catch (PDOException $e) {
        header('Location: index.php?msg=Αδύνατη η σύνδεση με τον server');
        exit();
    }
}
?>

<form id="villaform" name="villaform"  enctype="multipart/form-data" action="updatevillahandler.php?id=<?php echo $_GET['id'] ?>" method="POST">
    <table style="width:100%;">

        <tr>
            <td width="25%">&nbsp</td>
            <td style = "font-size: 1.2em;"><em>Τα πεδία με * είναι υποχρεωτικά!</em></td>

        </tr>

        <tr><td></td></tr>
        <tr><td></td></tr>
        <tr><td></td></tr>
        <tr>
            <td class="right" style = "padding: 0 0 25px 60px; font-size: 1.2em;">* Όνομα Βίλας</td>
            <td><input style="width: 215px; height: 17px; " class="inputs" type="text" id="villaname" name="villaname" size="50" maxlength="50" value="<?php echo $villaname ?>"></td>
        </tr>

        <tr>
            <td class="right"  style = "padding: 0 0 25px 75px; font-size: 1.2em;">* Νομός</td>
            <td>
                <select style="width: 235px; font-size: 1em; height: 30px; " class="inputs" id="area" name="area">
                    <option value="-1" style="color:red;" selected="selected">--Επιλέξτε Νομό--</option>
                    <optgroup label="Θράκη">
                        <option value="Θράκη-Έβρος-Αλεξανδρούπολη" <?php if ($area == 'Αλεξανδρούπολη') echo 'selected="selected"' ?> >Ν.Έβρου - Αλεξανδρούπολη</option>
                        <option value="Θράκη-Ροδόπη-Κομοτηνή" <?php if ($area == 'Κομοτηνή') echo 'selected="selected"' ?> >Ν.Ροδόπης - Κομοτηνή</option>
                        <option value="Θράκη-Ξάνθη" <?php if ($area == 'Ξάνθη') echo 'selected="selected"' ?> >Ν.Ξάνθης - Ξάνθη</option>
                    </optgroup>
                    <optgroup label="Μακεδόνια">
                        <option value="Μακεδονία-Καβάλα" <?php if ($area == 'Καβάλα') echo 'selected="selected"' ?> >Ν.Καβάλας - Καβάλα</option>
                        <option value="Μακεδονία-Δράμα" <?php if ($area == 'Δράμα') echo 'selected="selected"' ?> >Ν.Δράμας - Δράμα</option>
                        <option value="Μακεδονία-Σέρρες" <?php if ($area == 'Σέρρες') echo 'selected="selected"' ?> >Ν.Σερρών - Σέρρες</option>
                        <option value="Μακεδονία-Κιλκίς" <?php if ($area == 'Κιλκίς') echo 'selected="selected"' ?> >Ν.Κιλκίς - Κιλκίς</option>
                        <option value="Μακεδονία-Θεσσαλονίκη" <?php if ($area == 'Θεσσαλονίκη') echo 'selected="selected"' ?> >Ν.Θεσσαλονίκης - Θεσσαλονίκη</option>
                        <option value="Μακεδονία-Χαλκιδική-Πολύγυρος" <?php if ($area == 'Πολύγυρος') echo 'selected="selected"' ?> >Ν.Χαλκιδικής - Πολύγυρος</option>
                        <option value="Μακεδονία-Πέλλα-Έδεσσα" <?php if ($area == 'Έδεσσα') echo 'selected="selected"' ?> >Ν.Πέλλης - Έδεσσα</option>
                        <option value="Μακεδονία-Ημαθία-Βέροια" <?php if ($area == 'Βέροια') echo 'selected="selected"' ?> >Ν.Ημαθίας - Βέροια</option>
                        <option value="Μακεδονία-Φλώρινα" <?php if ($area == 'Φλώρινα') echo 'selected="selected"' ?>>Ν.Φλώρινας - Φλώρινα</option>
                        <option value="Μακεδονία-Κοζάνη" <?php if ($area == 'Κοζάνη') echo 'selected="selected"' ?>>Ν.Κοζάνης - Κοζάνη</option>
                        <option value="Μακεδονία-Καστοριά" <?php if ($area == 'Καστοριά') echo 'selected="selected"' ?>>Ν.Καστοριάς - Καστοριά</option>
                        <option value="Μακεδονία-Πιερία-Κατερίνη" <?php if ($area == 'Κατερίνη') echo 'selected="selected"' ?>>Ν.Πιερίας - Κατερίνη</option>
                        <option value="Μακεδονία-Γρεβενά" <?php if ($area == 'Γρεβενά') echo 'selected="selected"' ?>>Ν.Γρεβενών - Γρεβενά</option>
                    </optgroup>
                    <optgroup label="Θεσσαλία">
                        <option value="Θεσσαλία-Λάρισα" <?php if ($area == 'Λάρισα') echo 'selected="selected"' ?> >Ν.Λαρίσης - Λάρισα</option>
                        <option value="Θεσσαλία-Μαγνησία-Βόλος" <?php if ($area == 'Βόλος') echo 'selected="selected"' ?>>Ν.Μαγνησίας - Βόλος</option>
                        <option value="Θεσσαλία-Καρδίτσα" <?php if ($area == 'Καρδίτσα') echo 'selected="selected"' ?>>Ν.Καρδίτσας - Καρδίτσα</option>
                        <option value="Θεσσαλία-Τρίκαλα" <?php if ($area == 'Τρίκαλα') echo 'selected="selected"' ?>>Ν.Τρικάλων - Τρίκαλα</option>
                    </optgroup>
                    <optgroup label="Ήπειρος">
                        <option value="Ήπειρος-Ιωάννινα" <?php if ($area == 'Ιωάννινα') echo 'selected="selected"' ?>>Ν.Ιωαννίνων - Ιωάννινα</option>
                        <option value="Ήπειρος-Θεσπρωτία-Ηγουμενίτσα" <?php if ($area == 'Ηγουμενίτσα') echo 'selected="selected"' ?>>Ν.Θεσπρωτίας - Ηγουμενίτσα</option>
                        <option value="Ήπειρος-Πρέβεζα" <?php if ($area == 'Πρέβεζα') echo 'selected="selected"' ?> >Ν.Πρεβέζης - Πρέβεζα</option>
                        <option value="Ήπειρος-Άρτα" <?php if ($area == 'Άρτα') echo 'selected="selected"' ?> >Ν.Άρτης - Άρτα</option>
                    </optgroup>
                    <optgroup label="Στερεά Ελλάδα">
                        <option value="Στερεά Ελλάδα-Αττική-Αθήνα" <?php if ($area == 'Αθήνα') echo 'selected="selected"' ?> >Ν.Αττικής - Αθήνα</option>
                        <option value="Στερεά Ελλάδα-Βοιωτία-Λιβαδιά" <?php if ($area == 'Λιβαδιά') echo 'selected="selected"' ?> >Ν.Βοιωτίας - Λιβαδιά</option>
                        <option value="Στερεά Ελλάδα-Φθιώτιδα-Λαμία" <?php if ($area == 'Λαμία') echo 'selected="selected"' ?> >Ν.Φθιώτιδα - Λαμία</option>
                        <option value="Στερεά Ελλάδα-Φωκίδα-Άμφισσα" <?php if ($area == 'Άμφισσα') echo 'selected="selected"' ?> >Ν.Φωκίδας - Άμφισσα</option>
                        <option value="Στερεά Ελλάδα-Αιτωλοακαρνανία-Μεσολόγγι" <?php if ($area == 'Μεσολόγγι') echo 'selected="selected"' ?> >Ν.Αιτωλοακαρνανίας - Μεσολόγγι</option>
                        <option value="Στερεά Ελλάδα-Ευρυτανία-Καρπενήσι" <?php if ($area == 'Καρπενήσι') echo 'selected="selected"' ?> >Ν.Ευρυτανίας - Καρπενήσι</option>
                        <option value="Στερεά Ελλάδα-Εύβοια-Χαλκίδα" <?php if ($area == 'Χαλκίδα') echo 'selected="selected"' ?> >Ν.Ευβοίας - Χαλκίδα</option>
                    </optgroup>
                    <optgroup label="Πελοπόννησος">
                        <option value="Πελοπόννησος-Κόρινθος" <?php if ($area == 'Κόρινθος') echo 'selected="selected"' ?> >Ν.Κορινθίας - Κόρινθος</option>
                        <option value="Πελοπόννησος-Αχαΐα-Πάτρα" <?php if ($area == 'Πάτρα') echo 'selected="selected"' ?> >Ν.Αχαΐας - Πάτρα</option>
                        <option value="Πελοπόννησος-Ηλεία-Πύργος" <?php if ($area == 'Πύργος') echo 'selected="selected"' ?> >Ν.Ηλείας - Πύργος</option>
                        <option value="Πελοπόννησος-Αρκαδία-Τρίπολη" <?php if ($area == 'Τρίπολη') echo 'selected="selected"' ?>>Ν.Αρκαδίας - Τρίπολη</option>
                        <option value="Πελοπόννησος-Αργολίδα-Ναύπλιο" <?php if ($area == 'Ναύπλιο') echo 'selected="selected"' ?> >Ν.Αργολίδος - Ναύπλιο</option>
                        <option value="Πελοπόννησος-Μεσσηνία-Καλαμάτα" <?php if ($area == 'Καλαμάτα') echo 'selected="selected"' ?>>Ν.Μεσσηνίας - Καλαμάτα</option>
                        <option value="Πελοπόννησος-Λακωνία-Σπάρτη" <?php if ($area == 'Σπάρτη') echo 'selected="selected"' ?>>Ν.Λακωνίας - Σπάρτη</option>
                    </optgroup>

                    <optgroup label="Νησιά Αιγαίου">

                        <option value="Αιγαίο-Λέσβος" <?php if ($area == 'Λέσβος') echo 'selected="selected"' ?> >Λέσβος</option>
                        <option value="Αιγαίο-Χίος" <?php if ($area == 'Χίος') echo 'selected="selected"' ?> >Χίος</option>
                        <option value="Αιγαίο-Σάμος" <?php if ($area == 'Σάμος') echo 'selected="selected"' ?> >Σάμος</option>
                        <option value="Αιγαίο-Λήμνος" <?php if ($area == 'Λήμνος') echo 'selected="selected"' ?> >Λήμνος</option>
                        <option value="Αιγαίο-Θάσος" <?php if ($area == 'Θάσος') echo 'selected="selected"' ?> >Θάσος</option>
                        <option value="Αιγαίο-Ικαρία" <?php if ($area == 'Ικαρία') echo 'selected="selected"' ?> >Ικαρία</option>
                        <option value="Αιγαίο-Σκιάθος" <?php if ($area == 'Σκιάθος') echo 'selected="selected"' ?> >Σκιάθος</option>
                        <option value="Αιγαίο-Σκόπελος" <?php if ($area == 'Σκόπελος') echo 'selected="selected"' ?> >Σκόπελο</option>
                        <option value="Αιγαίο-Σπέτσες" <?php if ($area == 'Σπέτσες') echo 'selected="selected"' ?> >Σπέτσες</option>
                        <option value="Αιγαίο-Ύδρα" <?php if ($area == 'Ύδρα') echo 'selected="selected"' ?> >Ύδρα</option>
                        <option value="Αιγαίο-Σύρος" <?php if ($area == 'Σύρος') echo 'selected="selected"' ?> >Σύρος</option>
                        <option value="Αιγαίο-Κυκλάδες-Νάξος" <?php if ($area == 'Νάξος') echo 'selected="selected"' ?>>Νάξος</option>
                        <option value="Αιγαίο-Κυκλάδες-Σαντορίνη" <?php if ($area == 'Σαντορίνη') echo 'selected="selected"' ?> >Σαντορίνη</option>
                        <option value="Αιγαίο-Κυκλάδες-Πάρος" <?php if ($area == 'Πάρος') echo 'selected="selected"' ?>>Πάρος</option>
                        <option value="Αιγαίο-Κυκλάδες-Μύκονος" <?php if ($area == 'Μύκονος') echo 'selected="selected"' ?> >Μύκονος</option>
                        <option value="Αιγαίο-Κυκλάδες-Φολέγανδρος" <?php if ($area == 'Φολέγανδρος') echo 'selected="selected"' ?> >Φολέγανδρος</option>
                        <option value="Αιγαίο-Δωδεκάνησα-Ρόδος" <?php if ($area == 'Ρόδος') echo 'selected="selected"' ?> >Ρόδος</option>
                        <option value="Αιγαίο-Δωδεκάνησα-Κως" <?php if ($area == 'Κως') echo 'selected="selected"' ?> >Κώς</option>
                        <option value="Αιγαίο-Δωδεκάνησα-Κάλυμνος">Κάλυμνος</option>
                        <option value="Αιγαίο-Δωδεκάνησα-Κάρπαθος">Κάρπαθος</option>
                        <option value="Αιγαίο-Δωδεκάνησα-Πάτμος">Πάτμος</option>
                        <option value="Αιγαίο-Δωδεκάνησα-Αστυπάλαια">Αστυπάλαια</option>
                    </optgroup>

                    <optgroup label="Νησιά Ιονίου">
                        <option value="Ιόνιο-Κέρκυρα" <?php if ($area == 'Κέρκυρα') echo 'selected="selected"' ?> >Κέρκυρα</option>
                        <option value="Ιόνιο-Ζάκυνθος" <?php if ($area == 'Ζάκυνθος') echo 'selected="selected"' ?>>Ζάκυνθος</option>
                        <option value="Ιόνιο-Κεφαλονιά" <?php if ($area == 'Κεφαλονιά') echo 'selected="selected"' ?> >Κεφαλονία</option>
                        <option value="Ιόνιο-Λευκάδα" <?php if ($area == 'Λευκάδα') echo 'selected="selected"' ?> >Λευκάδα</option>
                        <option value="Ιόνιο-Κύθυρα" <?php if ($area == 'Κύθυρα') echo 'selected="selected"' ?> >Κύθυρα</option>
                        <option value="Ιόνιο-Ιθάκη" <?php if ($area == 'Ιθάκη') echo 'selected="selected"' ?> >Ιθάκη</option>
                        <option value="Ιόνιο-Παξούς" <?php if ($area == 'Παξούς') echo 'selected="selected"' ?> >Παξούς</option>
                    </optgroup>

                    <optgroup label="Κρήτη">
                        <option value="Αιγαίο-Κρήτη-Χανιά" <?php if ($area == 'Χανιά') echo 'selected="selected"' ?> >Ν.Χανιών - Χανιά</option>
                        <option value="Αιγαίο-Κρήτη-Ρέθυμνο" <?php if ($area == 'Ρέθυμνο') echo 'selected="selected"' ?> >Ν.Ρεθύμνης - Ρέθυμνο</option>
                        <option value="Αιγαίο-Κρήτη-Ηράκλειο" <?php if ($area == 'Ηράκλειο') echo 'selected="selected"' ?> >Ν.Ηρακλείου - Ηράκλειο</option>
                        <option value="Αιγαίο-Κρήτη-Λασίθι-Άγιος Νικόλαος" <?php if ($area == 'Άγιος Νικόλαος') echo 'selected="selected"' ?> >Ν.Λασιθίου - Άγιος Νικόλαος</option>
                    </optgroup>
                </select>
            </td>
        </tr>

        <tr>
            <td class="right" style = "padding: 0 0 25px 75px; font-size: 1.2em;">* Διεύθυνση</td>
            <td><input style="width: 215px; height: 17px; " class="inputs" type="text" id="address" name="address" size="50" maxlength="50" value="<?php echo $address ?>"> <input style="width: 30px; height: 17px;" class="inputs" type="text" id="addressno" name="addressno" size="3" maxlength="3" value="<?php echo $addressnumber ?>"></td>
        </tr>

        <tr>
            <td class="right" style = "padding: 0 0 25px 95px; font-size: 1.2em;">* Τ.Κ</td>
            <td><input class="inputs" style="width: 80px; height: 17px;  " type="text" id="postalcode" name="postalcode" size="10" maxlength="10" value="<?php echo $postalcode ?>"></td>
        </tr>

        <tr>
            <td class="right" style = "padding: 0 0 25px 95px; font-size: 1.2em;">* Τιμή</td>
            <td><input class="inputs" style="width: 65px; height: 17px; " type="text" id="price" name="price" size="7" maxlength="7" value="<?php echo $price ?>">&nbsp;&euro;</td>
        </tr>

        <tr>
            <td class="right" style = "padding: 0 0 25px 20px; font-size: 1.2em;">* Τετραγωνικά μέτρα</td>
            <td><input class="inputs" style="width: 65px; height: 17px; " type="text" id="squaremeter" name="squaremeter" size="4" maxlength="4" value="<?php echo $squaremeter ?>">&nbsp;τετρ. μέτρα</td>
        </tr>

        <tr>
            <td class="right" style = "padding: 0 0 25px 75px; font-size: 1.2em;">* Τηλέφωνο</td>
            <td><input class="inputs" style="width: 95px; height: 17px; " type="text" id="telephone" name="telephone" size="10" maxlength="10" value="<?php echo $telephone ?>"></td>
        </tr>

        <tr>
            <td class="right" style = "padding: 0 0 25px 40px; font-size: 1.2em;">Κινητό Τηλέφωνο</td>
            <td><input class="inputs" style="width: 95px; height: 17px; " type="text" id="mobilephone" name="mobilephone" size="10" maxlength="10" value="<?php echo $mobilephone ?>"></td>
        </tr>

        <tr>
            <td class="right" style = "padding: 0 0 25px 55px; font-size: 1.2em;">* Χωρητικότητα</td>
            <td><input class="inputs" style="width: 35px; height: 17px; " type="text" id="capacity" name="capacity" size="3" maxlength="3" value="<?php echo $capacity ?>">&nbsp;άτομα</td>
        </tr>

        <tr>
            <td class="right" style = "padding: 20px 0 25px 50px; font-size: 1.2em;">* Εγκαταστάσεις</td>
            <td>
                <label><input type="checkbox" id="garage" name="garage" value="1"  <?php if ($garage == 1) echo'checked="checked"' ?> >Γκαράζ</label>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label><input type="checkbox" id="wifi" name="wifi" value="1" <?php if ($wifi == 1) echo'checked="checked"' ?>>Wi-Fi</label>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label><input type="checkbox" id="pool" name="pool" value="1" <?php if ($pool == 1) echo'checked="checked"' ?> >Πισίνα</label>
                <br/><br/>
                <label><input type="checkbox" id="jacuzzi" name="jacuzzi" value="1" <?php if ($jacuzzi == 1) echo'checked="checked"' ?> >Τζακούζι</label>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label><input type="checkbox" id="spa" name="spa" value="1" <?php if ($spa == 1) echo'checked="checked"' ?> >Spa</label>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label><input type="checkbox" id="gym" name="gym" value="1" <?php if ($gym == 1) echo'checked="checked"' ?> >Γυμναστήριο</label>

            </td>
        </tr>

        <tr>
            <td class="right" style = "padding: 20px 0 25px 75px; font-size: 1.2em;">* Αστέρων</td>
            <td>
                <div class="rating">
                    <input type="radio" name="rating" value="0"  /><span id="hide"></span>
                    <input type="radio" name="rating" value="1" <?php if ($rating == 1) echo 'checked="checked"' ?> /><span></span>
                    <input type="radio" name="rating" value="2" <?php if ($rating == 2) echo 'checked="checked"' ?> /><span></span>
                    <input type="radio" name="rating" value="3" <?php if ($rating == 3) echo 'checked="checked"' ?> /><span></span>
                </div>
            </td>
        </tr>

        <tr>
            <td class="right" style = "padding: 10px 0 90px 90px; font-size: 1.2em;">Επιπλέον Περιγραφή</td>
            <td>
                <textarea class="inputs" style="margin-bottom: 0;" id="comments" name="comments" rows="5" onkeyup="check_limit('comments', 150, 'chars_left_counter');"><?php echo $villasdescr ?></textarea>
            </td>
        </tr>
        <tr>
            <td class="right" style = "padding: 0 0 25px 70px; font-size: 1.2em;">* Κύρια Φωτογραφία</td>
            <td><input class="custom-file-input" accept="image/pjpeg" style="margin-bottom: 20px;" name="mainphoto" id="mainphoto" type="file" value="Browse.."></td>
        </tr>
        <tr>
            <td></td>
            <td><a href="maps.php" target="_blank" class="whitebutton" style="margin-bottom: 20px;" >Αλλάξτε τοποθεσία στον χάρτη</a><input  name="coords" id="coords" type="text" value="<?php echo $coords ?>"></td>
        </tr>
        <tr>
            <td></td>
            <td><input class="whitebutton" style="margin: 0 auto; width: 150px"  type="submit" value="Καταχώρηση"></td>
        </tr>

    </table>
</form>