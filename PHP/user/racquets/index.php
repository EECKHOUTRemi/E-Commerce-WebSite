<?php
require_once('../../header.php');

session_start();

if (!isset($_SESSION['id'])) {
    header('Location:../index.php');
    die;
}

$result = $bdd->query('SELECT * FROM racquets ORDER BY brand');
$racquets = $result->fetchAll();
?>

<nav class="navbar">
    <div class="navbarContainer">
        <div class="navbarLogoTitle">
            <img src="/Projet/IMG/logo.svg" alt="logo" class="logo">
        </div>
        <div class="navbarLinks">
            <div class="navbarLinkBox">
                <a href="/Projet/PHP/user/index.php" class="navbarLink ">Acceuil</a>
            </div>
            <div class="navbarLinkBox">
                <a href="/Projet/PHP/user/racquets/index.php" class="navbarLink ">Raquettes</a>
            </div>
            <div class="navbarLinkBox">
                <a href="/Projet/PHP/user/account/index.php" class="navbarLink ">Votre profil</a>
            </div>
            <div class="navbarLinkBox">
                <a href="/Projet/PHP/signOut.php" class="navbarLink ">Se déconnecter</a>
            </div>
        </div>
        <div class="shopBagDiv">
            <a href="cart.php"><img src="/Projet/IMG/shopping-bag.svg" alt="Panier" class="shopBagSvg"></a>
        </div>
    </div>
</nav>

<div class="container" style="margin-bottom: 100px;">
    <h1 class="titleRacquets">Voici les raquettes que nous proposons</h1>

    <div class="cards">

        <?php
        foreach ($racquets as $racquet) {
        ?>
            <div class="cardRacquet">
                <img src="/Projet/PHP/admin/racquets<?= $racquet['image'] ?>" alt="<?= $racquet["brand"] . ' ' . $racquet["model"] ?>" class="imgRacquet">
                <a href=<?= "details.php?id=". $racquet["id"] ?> class="linkDetails"> <?= $racquet["brand"] . ' ' . $racquet["model"] ?> </a> 
            </div>
        <?php
        }
        ?>
    </div>
</div>

<?php
require_once('../../footer.php');
?>