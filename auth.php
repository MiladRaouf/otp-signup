<?php

require 'bootstrap/init.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_GET['action'];
    $params = $_POST;

    if ($action == 'register') {
        registerValidation($params);

        if (createUser($params)) {
            $_SESSION['email'] = $params['email'];
            redirect('auth.php?action=verify');
        }
    }
    
    if ($action = 'verify') {
        // var_dump(issetToken($params['token'], $_SESSION['hash']));
        // include 'templates/verify.php';
        // die();
        
        if (!issetToken($params['token'], $_SESSION['hash']))
            redirectAndSetMessage('token not exist', 'auth.php?action=verify');

        $session = bin2hex(random_bytes(32));

        if (chengeLoginSession($session, $_SESSION['email'])) {
            setcookie('user', $session, time() + 1728000, '/');
            deleteTokenByHash($_SESSION['hash']);
            unset($_SESSION['email'], $_SESSION['hash']);
            redirect();
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'verify' && isset($_SESSION['email'])) {
    if (isset($_SESSION['hash']) && isAliveToken($_SESSION['hash'])) {
        # send old token
        sendTokenByEmail($_SESSION['email'], findTokenByHash($_SESSION['hash'])->token);
    } else {
        $tokenResult = generateToken();
        $_SESSION['hash'] = $tokenResult['hash'];
        sendTokenByEmail($_SESSION['email'], $tokenResult['token']);
    }

    include 'templates/verify.php';
    die();
}

if (isset($_GET['action']) && $_GET['action'] == 'register')
    include 'templates/register.php';
else
    include 'templates/login.php';
