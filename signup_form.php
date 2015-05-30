<span class="signuptab">
    <form class="left" name='signup' id='signup' method='POST' action="signuphandler.php" onsubmit="return signup_validate()">
        <table>
            <tr>
                <td  style="padding: 0 0 25px 60px; font-size: 1.2em; color: black;">Όνομα</td>
                <td><input class="inputs" style="width: 150px; height: 15px; " type="text" id="firstname" name="firstname" size="20" maxlength="20"></td>

            </tr>
            <tr>
                <td  style="padding: 0 0 25px 60px; font-size: 1.2em; color: black;">Επώνυμο</td>
                <td><input class="inputs" style="width: 150px; height: 15px; " type="text" id="surname" name="surname" size="45" maxlength="45"></td>

            </tr>
            <tr>
                <td  style="padding: 0 0 25px 60px; font-size: 1.2em; color: black;">Όνομα χρήστη</td>
                <td><input class="inputs" style="width: 150px; height: 15px; " type="text" id="username_" name="username_" size="35" maxlength="35"></td>

            </tr>
            <tr>
                <td style="padding: 0 0 25px 70px; font-size: 1.2em; color: black;">Email</td>
                <td><input class="inputs" style="width: 150px; height: 15px;" type="text" id="email" name="email" size="45" maxlength="45"></td>

            </tr>
            <tr>
                <td style="padding: 0 0 25px 60px; font-size: 1.2em; color: black;">Κωδικός</td>
                <td><input class="inputs" style="width: 150px; height: 15px;" type="password" id="password_" name="password_" size="50" maxlength="50"></td>
            </tr>
            <tr>
                <td><input class="whitebutton" style="margin-left: 50px;"  type="submit" value="Εγγραφή"></td>
            </tr>
        </table>
    </form>
</span>
<span id="right" style="margin-left: 20px; padding-top: 10px;">
    <h2>Είστε ιδιοκτήτης βίλας;</h2>
    <h3>Εγγραφείτε για να:</h3>
    <br/>
    <p style="padding-left: 7px;"> <span style="color: green; font-family: 'Segoe UI Symbol'">&#xe10b;</span> Ανεβάσετε την βίλα σας, ώστε να μπορούν να την δουν<br/>οι επισκέπτες του Webvillas!</p>
    <p style="padding-left: 7px;"> <span style="color: green; font-family: 'Segoe UI Symbol'">&#xe10b;</span> Επεξεργαστείτε τα στοιχεία της βίλας σας ανα πάσα<br/> στιγμή!</p>
</span>