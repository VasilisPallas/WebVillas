<!-- 8ψήφιος αλφαριθμητικός κωδικός για salt(το salt είναι τα ψηφία που μπαίνουν πριν από τον κρυπτογραφημένο κωδικό) -->
<?php
function generateRandomString($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
?>