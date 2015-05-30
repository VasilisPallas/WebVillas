<!-- Όταν κάνει εγγραφή στέλνει με GET το email για να βρούμε τα στοιχεία του και εμφανιστούν τα στοιχεία του στην φόρμα -->
<?php
try {
    require('params.php');
    $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');
    $sql = 'SELECT * FROM users WHERE email=:email';
    $statement = $pdoObject->prepare($sql);
    $myResult = $statement->execute(array(':email' => $_GET['email']));
    if ($record = $statement->fetch()) {
        $username = $record['username'];
        $email = $record['email'];
    }
    $statement->closeCursor();
    $pdoObject = null;
} catch (PDOException $e) {
    header('Location: index.php?msg=Αδύνατη η σύνδεση με τον server');
    exit();
}
?>

<meta charset="UTF-8">

<form name="verification" id="verification" method="POST" action="verificationhandler.php" onsubmit="return verification_validate()">
    <table>
        <tr>
            <td  style="padding: 0 0 25px 60px; font-size: 1.2em; color: black;">Όνομα χρήστη</td>
            <td><input class="inputs" readonly="readonly" style="width: 210px; height: 25px; " type="text" id="username" name="username"  size="20" maxlength="20" value="<?php echo $username ?>" /></td>

        </tr>
        <tr>
            <td style="padding: 0 0 25px 70px; font-size: 1.2em; color: black;">Email</td>
            <td><input class="inputs" readonly="readonly" style="width: 210px; height: 25px;" type="text"  id="email" name="email" size="45" maxlength="45" value="<?php echo $email ?>" ></td>

        </tr>

        <tr>
            <td style="padding: 0 0 25px 60px; font-size: 1.2em; color: black;">Verification code</td>
            <td><input class="inputs" style="width: 80px; height: 25px;" type="text" id="verificationcode" name="verificationcode" size="5" maxlength="5"></td>
        </tr>

        <tr>
            <td style="padding-left: 70px;"><img src="CaptchaSecurityImages.php" alt="Captcha" /></td>
        </tr>
        <tr>
            <td style="padding: 0 0 25px 60px; font-size: 1.2em; color: black;">Security Code</td>
            <td> <input style="width: 100px; height: 25px;" class="inputs" id="security_code" name="security_code" type="text" maxlength="6"/></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td colspan="2"><input class="whitebutton" style="margin-left: 50px;" type="submit" value="Ενεργοποίηση λογαριασμόυ"></td>
        </tr>
    </table>
</form>