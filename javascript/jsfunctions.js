function looks_like_email(str)
{
    var result = true;
    var papakipos = str.indexOf("@");
    var dotpos = str.indexOf(".");
    var spacepos = str.indexOf(" ");
    var dotposafterpapaki = str.indexOf(".", papakipos);
    var spaceposafterpapaki = str.indexOf(" ", papakipos);

    if (papakipos <= 0)
    {
        result = false;
    }

    if (dotpos <= 0)
    {
        result = false;
    }

    if (spacepos >= 0)
    {
        result = false;
    }

    if (dotposafterpapaki - papakipos == 1)
    {
        result = false;
    }

    if (spaceposafterpapaki - papakipos == 1)
    {
        result = false;
    }

    if (str.indexOf(".") == 0 || str.indexOf(".") == str.length - 1)
    {
        result = false;
    }

    return result;
}


function menuhide()
{
    var check = document.getElementById("visibility_check");

    if (check.checked == true)
    {
        document.getElementById("visibility_button").style.visibility = 'hidden';
        check.checked = false;
        document.getElementById("signupdiv").style.width = '10px';
    }
}


function menushow()
{
    var check = document.getElementById("visibility_check");
    if (check.checked == false)
    {
        document.getElementById("visibility_button").style.visibility = 'visible';
        check.checked = true;
        document.getElementById("signupdiv").style.width = 'auto';
    }

}

function visibility() {
    var check = document.getElementById("visibility_check");

    if (check.checked == false)
    {
        menushow();
    }
    else {
        menuhide();

    }
}


function verification_validate() {
    var verificationcode, security_code, result = true;
    verificationcode = document.getElementById("verificationcode").value;
    security_code = document.getElementById("security_code").value;
    if (verificationcode == "") {
        result = false;
        alert("To πεδίο του κωδικού επιβεβαίωσης είναι κενό!")
    }
    if (security_code == "") {
        result = false;
        alert("Το captcha είναι κενό!")
    }
    return result;
}

function searchresult(area)
{
    var xmlhttp;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else {
        alert("Your browser does not support XMLHTTP!");
    }

    //-----Αποφυγή caching σελίδας-----

    var d = new Date();    // βάλε στη μεταβλητή d την τρέχουσα ημ/νία-ώρα
    var url = "noofresults.php?foo=" + d;

//-----υποβολή ερωτήματος στον server-----
    xmlhttp.open("POST", url, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("area=" + area);

    //-----ορισμός της callback συνάρτησης-----
    //τρέχει αυτόματα κάθε φορά που αλλάζει η παράμετρος readyState
    //του AJAX - εδώ λέμε τι θα κάνουμε με τις απαντήσεις 
    xmlhttp.onreadystatechange = function() {
        //δείτε τα slide θεωρίας για τις διάφορες παραμέτρους
        //αν ο server απάντησε (AJAX readyState 4) και απάντησε επιτυχώς (server http status 200)
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            //η απάντηση του server βρίσκεται στο xmlhttp.responseText
            //την τοποθετούμε μέσα στο δεξιό div
            document.getElementById("ajaxresult").style.visibility = 'visible';
            document.getElementById("ajaxresult").innerHTML = xmlhttp.responseText;
        } else
        {
            document.getElementById("ajaxresult").style.visibility = 'visible';
            document.getElementById("ajaxresult").innerHTML = "Μη αποδεκτή απάντηση<br/>στην AJAX κλίση!";
        }
    }

}

function signup_validate()
{
    var firstname, surname, username, email, password, illegalchars, result = true;
    firstname = document.getElementById("firstname").value;
    surname = document.getElementById("surname").value;
    username = document.getElementById("username_").value;
    email = document.getElementById("email").value;
    password = document.getElementById("password_").value;
    illegalchars = new RegExp("/\W/");

    if (firstname == "")
    {
        result = false;
        alert("το πεδίο του ονόματος είναι κενό");
    }

    if (surname == "")
    {
        result = false;
        alert("το πεδίο του επωνύμου είναι κενό");
    }

    if (username == "")
    {
        result = false;
        alert("το πεδίο του username είναι κενό");
    }

    if (password == "")
    {
        result = false;
        alert("το πεδίο του κωδικού είναι κενό");
    }

    if (email == "")
    {
        result = false;
        alert("το πεδίο του email είναι κενό");
    }

    if (email != "" && !looks_like_email(email))
    {
        result = false;
        alert("Μη επιτρεπτό email");
    }

    if (password != "" && illegalchars.test(password))
    {
        result = false;
        alert("Λατινικά, αριθμοί και underscore!");
    }

    if (password != "" && password.length < 8)
    {
        result = false;
        alert("Ο κωδικός θα πρέπει να έχει περισσότερα από 8 ψηφία!");
    }

    return result;
}

function login_validate()
{
    var username, password, illegalchars, result = true;

    username = document.getElementById("username").value;
    password = document.getElementById("password").value;
    illegalchars = new RegExp("/\W/");

    if (username == "")
    {
        result = false;
        alert("το πεδίο του username είναι κενό");
    }

    if (password == "")
    {
        result = false;
        alert("το πεδίο του κωδικού είναι κενό");
    }

    if (password != "" && illegalchars.test(password))
    {
        result = false;
        alert("Λατινικά, αριθμοί και underscore!");
    }

    if (password != "" && password.length < 8)
    {
        result = false;
        alert("Ο κωδικός θα πρέπει να έχει περισσότερα από 8 ψηφία!");
    }

    return result;
}
