<?php
require_once('../../header.php');

session_start();

if (!isset($_SESSION) || $_SESSION['role'] !== 'admin') {
    header('Location:../index.php');
    die;
}

$rqUsers = $bdd->prepare('SELECT * FROM `users` WHERE `id`=?');
$rqUsers->execute([$_GET["id"]]);
$user = $rqUsers->fetch();

$dir = './upload/';

if (isset($_POST['yesOrNo'])) {
    if ($_POST['yesOrNo'] === 'yes') {
        $rqDeleteUsers = $bdd->prepare('DELETE FROM users WHERE id=?');
        $rqDeleteUsers->execute([$_GET["id"]]);
    }

    header('Location:index.php');
}

?>

</head>

<body>

    <nav class="navbar">
        <div class="navbarContainer">
            <div class="navbarLogoTitle">
                <img src="/Projet/IMG/logo.svg" alt="logo" class="logo">
            </div>
            <div class="navbarLinks">
                <div class="navbarLinkBox">
                    <a href="../index.php" class="navbarLink ">Acceuil</a>
                </div>
                <div class="navbarLinkBox">
                    <a href="../users/index.php" class="navbarLink ">Raquettes</a>
                </div>
                <div class="navbarLinkBox">
                    <a href="index.php" class="navbarLink ">Utilisateurs</a>
                </div>
                <div class="navbarLinkBox">
                    <a href="../../signOut.php" class="navbarLink ">Se déconnecter</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>Voulez-vous vraiment supprimer <?= $user['username'] ?> ?</h1>
        <form action="" method="POST">
            <input type="radio" name="yesOrNo" value="yes"> <label for="yes">Oui</label>
            <input type="radio" name="yesOrNo" value="no"> <label for="no">Non</label>
            <input type="submit" value="Continuer">
        </form>
    </div>

    <?php
    require_once('../../footer.php');
    ?>