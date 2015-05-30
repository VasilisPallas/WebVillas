<?php
  session_start();   
  session_destroy(); 
  header("Location: index.php?msg=Επιτυχής Αποσύνδεση!");
  exit();
  ?>