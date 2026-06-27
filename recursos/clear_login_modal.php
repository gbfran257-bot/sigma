<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['show_login_modal'])) {
    unset($_SESSION['show_login_modal']);
}

echo 1;
