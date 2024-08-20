<?php

session_start();
echo $_SESSION['passkey_verified'];
session_destroy();
?>