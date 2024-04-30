<?php
require_once('../header.php');

session_start();

if (!isset($_SESSION) || $_SESSION['role'] !== 'admin') {
    header('Location:../index.php');
    die;
}

$rqUser = $bdd->prepare('SELECT * FROM `users` WHERE `id`=?');
$rqUser->execute([$_SESSION["id"]]);
$user = $rqUser->fetch();

$nbAccounts = 0;
$nbAdmins = 0;
$nbUsers = 0;

$rqUsers = $bdd->query('SELECT * FROM `users`');

while ($users = $rqUsers->fetch()) {
    $nbAccounts++;
    if ($users['role'] === 'admin') {
        $nbAdmins++;
    } else {
        $nbUsers++;
    }
}

$nbRacquets = 0;
$nbWilson = 0;
$nbHead = 0;
$nbPrince = 0;
$nbYonex = 0;
$nbTechnifibre = 0;

$rqRacquets = $bdd->query('SELECT * FROM `racquets`');

while ($racquets = $rqRacquets->fetch()) {
    $nbRacquets++;
    if ($racquets['brand'] === 'Wilson') {
        $nbWilson++;
    } elseif ($racquets['brand'] === 'Head') {
        $nbHead++;
    } elseif ($racquets['brand'] === 'Prince') {
        $nbPrince++;
    } elseif ($racquets['brand'] === 'Yonex') {
        $nbYonex++;
    } elseif ($racquets['brand'] === 'Technifibre') {
        $nbTechnifibre++;
    }
}

?>

<link rel="stylesheet" href="../../CSS/global.css">
<link rel="stylesheet" href="home.css">
<title>Tennisshop - Acceuil (admin)</title>

</head>

<body>

    <nav class="navbar">
        <div class="navbarContainer">
            <div class="navbarLogoTitle">
                <img src="/Projet/IMG/logo.svg" alt="logo" class="logo">
            </div>
            <div class="navbarLinks">
                <div class="navbarLinkBox">
                    <a href="index.php" class="navbarLink ">Acceuil</a>
                </div>
                <div class="navbarLinkBox">
                    <a href="racquets/index.php" class="navbarLink ">Raquettes</a>
                </div>
                <div class="navbarLinkBox">
                    <a href="users/index.php" class="navbarLink ">Utilisateurs</a>
                </div>
                <div class="navbarLinkBox">
                    <a href="../signOut.php" class="navbarLink ">Se déconnecter</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>Statistiques</h2>

        <div class="statistics">

            <div class="accounts">
                <h3>Les comptes :</h3>
                <p>Nombre de comptes : <i><?= $nbAccounts ?></i></p>
                <p>Nombre de users : <i><?= $nbUsers ?></i></p>
                <p>Nombre d'admins : <i><?= $nbAdmins ?></i></p>
            </div>

            <div class="racquets">
                <h3>Les raquettes :</h3>
                <p>Nombre de raquettes : <i><?= $nbRacquets ?></i> </p>
                <p>Nombre de Wilson : <i><?= $nbWilson ?></i> </p>
                <p>Nombre de Head : <i><?= $nbHead ?></i> </p>
                <p>Nombre de Prince : <i><?= $nbPrince ?></i> </p>
                <p>Nombre de Yonex : <i><?= $nbYonex ?></i> </p>
                <p>Nombre de Technifibre : <i><?= $nbTechnifibre ?></i> </p>
            </div>
        </div>

    </div>

    <?php
    require_once('../footer.php');
    ?>