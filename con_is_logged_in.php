<?php
session_start();
if (!isset($_SESSION['username'])) { //αν ο χρήστης προσπαθήσει να μπει στην userpage χωρίς να κάνει login τον πηγαίνει στην σελίδα 
    header('Location:unauthorized.php');
    exit();
}
?>