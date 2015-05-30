<form name="login" id="login" action="con_login.php" method="POST" onsubmit="return login_validate();">
    <table>
        <tr>
            <td  style="padding: 0 0 25px 60px; font-size: 1.2em; color: black;">Όνομα χρήστη</td>
            <td  style="padding-right: 70px;"><input class="inputs" style="width: 150px; height: 15px;" type="text" id="username" name="username" size="20" maxlength="20"></td>

        </tr>
        <tr>
            <td style="padding: 0 0 25px 60px; font-size: 1.2em; color: black;">Κωδικός</td>
            <td  style="padding-right: 70px;" ><input class="inputs" style="width: 150px; height: 15px;" type="password" id="password" name="password" size="50" maxlength="50"></td>
        </tr>
        <tr>
            <td><input class="whitebutton" style="margin-left: 50px;"  type="submit" value="Σύνδεση"></td>
        </tr>
    </table>
</form>
