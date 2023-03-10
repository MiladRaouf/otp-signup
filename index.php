<?php

require "./bootstrap/init.php";

if (empty($_COOKIE['user']))
    redirect('/auth.php?action=login');

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    logOut(getAuthenticatUserBySession($_COOKIE['user'])->email);
}
include './templates/index-tpl.php';
