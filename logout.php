<?php

if(isset($_POST['logout-btn'])) {
        header("Location: login.php");
        session_destroy();
    }
?>