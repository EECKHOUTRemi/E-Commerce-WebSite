<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=tennisshop;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/Projet/IMG/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Projet/CSS/global.css">
    <link rel="stylesheet" href="/Projet/PHP/admin/racquets/racquet.css">
    <link rel="stylesheet" href="/Projet/PHP/admin/users/users.css">
    <link rel="stylesheet" href="/Projet/PHP/user/account/account.css">
    <link rel="stylesheet" href="/Projet/CSS/sign.css">
    <link rel="stylesheet" href="/Projet/PHP/user/racquets/racquet.css">
    <link rel="stylesheet" href="/Projet/PHP/user/racquets/details.css">
    <link rel="stylesheet" href="/Projet/PHP/user/racquets/cart.css">
    <title>Tennisshop</title>

</head>

<body>