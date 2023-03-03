<?php

function registerValidation(array $params): void
{
    if (empty($params['name']) || empty($params['phone'] || empty($params['email']))) {
        redirectAndSetMessage('all input fields required', 'auth.php?action=register');
    }

    if (!filter_var($params['email'], FILTER_VALIDATE_EMAIL)) {
        redirectAndSetMessage('Enter the valid email address', 'auth.php?action=register');
    }

    if (isUserExists($params['phone'], $params['email'])) {
        redirectAndSetMessage('User Exists with this data', 'auth.php?action=register');
    }
}
