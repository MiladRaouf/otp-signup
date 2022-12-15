<?php

require 'bootstrap/init.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_GET['action'];
    $params = $_POST;

    if ($action == 'register') {
        if (empty($params['name']) || empty($params['phone'] || empty($params['email']))) {
            redirectAndSetMessage('all input fields required', 'auth.php?action=register');
        }

        if (!filter_var($params['email'], FILTER_VALIDATE_EMAIL)) {
            redirectAndSetMessage('Enter the valid email address', 'auth.php?action=register');
        }
    }
}


if (isset($_GET['action']) && $_GET['action'] == 'register')
    include 'templates/register.php';
else
    include 'templates/login.php';

if (isset($_GET['action']) && $_GET['action'] == 'verify')
    include 'templates/login.php';
