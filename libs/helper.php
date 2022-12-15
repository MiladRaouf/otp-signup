<?php

function siteUrl(string $uri = ''): string
{
    return BASE_URL . $uri;
}

function preDump(mixed $data): void
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}

function prePrint(mixed $data): void
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function redirect(string $address = BASE_URL): void
{
    header('location: ' . $address);
    die();
}

function redirectAndSetMessage(string $message, string $address): void
{
    $_SESSION['error'] = $message;
    redirect(siteUrl($address));
}
