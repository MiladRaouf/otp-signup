<?php

require "./bootstrap/init.php";

if(empty($_COOKIE['user']))
    redirect('/auth.php?action=login');

echo 'hello from auth project';