<!-- έλεγχος αν στάλθηκαν -->
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require('functions.php');
    $emailvalidation = filter_input(INPUT_POST, $_POST['email'], FILTER_VALIDATE_EMAIL);
    if (!isset($_POST['firstname'], $_POST['surname'], $_POST['username_'], $_POST['password_'], $_POST['email']) && $emailvalidation=!FALSE) {
        header('Location: index.php?msg=error');
        exit();
    }
//Αν δεν έχει στείλει κενά textbox
    if ($_POST['firstname'] != "" && $_POST['surname'] != "" && $_POST['username_'] != "" && $_POST['password_'] != "" && $_POST['email'] != "") {

        $passwordlength = strlen($_POST['password_']);
        if ($passwordlength < 8) {
            header('Location: index.php?msg=O Κωδικός πρέπει να είναι μεγαλύτερος απο 8 χαρακτήρες');
            exit();
        }
        //έλεγχος ύπαρξης του username ήδη στην db
        try {
            require('params.php');
            $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
            $pdoObject->exec('set names utf8');
            $sql = 'select username,email from users where username=:username OR email=:email limit 1;';


            $statement = $pdoObject->prepare($sql);
            $statement->execute(array(':username' => $_POST['username_'], ':email' => $_POST['email']));
            $results = $statement->rowCount();
            if ($results === 0) {




                try {
                    //το salt
                    $salt = '$1$' . generateRandomString() . '$';
                    $encryptedpass = crypt($_POST['password_'], $salt);

                    require('params.php');
                    $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
                    $pdoObject->exec('set names utf8');
                    $sql = 'INSERT INTO users (username,firstName,surName,password,salt,email)
            VALUES (:username,:firstname,:surname,:password,:salt,:email)';
                    $statement = $pdoObject->prepare($sql);
                    $myResult = $statement->execute(array(':username' => $_POST['username_'],
                        ':firstname' => $_POST['firstname'],
                        ':surname' => $_POST['surname'],
                        ':password' => $encryptedpass,
                        ':salt' => $salt,
                        ':email' => $_POST['email']));
                    $statement->closeCursor();
                    $pdoObject = null;
                } catch (PDOException $e) {
                    header('Location: index.php?msg=Αδύνατη η σύνδεση με τον server');
                    exit();
                }

                if (!$myResult) {
                    header('Location: index.php?msg=ERROR: failed to execute sql query');
                    exit();
                } else {
                    //Αν ο χρήστης έγινε μέλος
                    $verification_code = rand(10000, 99999);

                    try {
                        require('params.php');
                        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
                        $pdoObject->exec('set names utf8');

                        $sql = "UPDATE users SET verificationCode=:verification_code WHERE username=:username;";
                        $statement = $pdoObject->prepare($sql);
                        $myResult = $statement->execute(array(':verification_code' => $verification_code,
                            ':username' => $_POST['username_']));
                        $statement->closeCursor();
                        $pdoObject = null;
                    } catch (PDOException $e) {
                        header('Location: index.php?msg=Αδύνατη η σύνδεση με τον server');
                        exit();
                    }

                    //MAIL
                    require_once "Mail.php";

                    $from = 'vspallas@gmail.com';
                    $to = $_POST['email'];
                    $subject = 'Κωδικός Ενεργοποίησης Λογαριασμού';
                    $body = "\t\tΓεια σας " . $_POST['surname'] . " " . $_POST['firstname'] . ".\n\n  Ευχαριστούμε για την εγγραφή σας στο WebVillas!\n\n  Ο κωδικός ενεργοποίησης είναι ο " . $verification_code . ".\n\n  ΠΡΟΣΟΧΗ! Ο συγκεκριμένος κωδικός μπορεί να χρησιμοποιηθεί μόνο μια φορά.\n\n\t\tΓια οποιοδήποτε πρόβλημα επικοινωνήστε με την ομάδα του WebVillas!";

                    $headers = array(
                        'From' => $from,
                        'To' => $to,
                        'Subject' => $subject
                    );

                    $smtp = Mail::factory('smtp', array(
                                'host' => 'ssl://smtp.gmail.com',
                                'port' => '465',
                                'auth' => true,
                                'username' => 'vspallas@gmail.com',
                                'password' => 'todaywasagoodday'
                    ));

                    $mail = $smtp->send($to, $headers, $body);
                    header('Location: verification.php?email=' . $_POST['email']);
                    exit();
                }
            } else {
                header('Location: index.php?msg=to username h to email uparxoun hdh');
                exit();
            }
            $statement->closeCursor();
            $pdoObject = null;
        } catch (PDOException $e) {
            header('Location: index.php?msg=Αδύνατη η σύνδεση με τον server');
            exit();
        }
    } else {
        header('Location: index.php?msg=Empty fields');
        exit();
    }
} else {
    header('Location: index.php?msg=Ta dedomena einai lathos');
    exit();
}
?>
