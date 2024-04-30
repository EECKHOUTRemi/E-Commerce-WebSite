<?php
require_once('../../header.php');

session_start();

if (!isset($_SESSION)) {
    header('Location:../../index.php');
    die;
}

$result = $bdd->query('SELECT * FROM orders WHERE userID=' . $_SESSION['id']);
$orders = $result->fetchAll();
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
            <a href="../racquets/cart.php"><img src="/Projet/IMG/shopping-bag.svg" alt="Panier" class="shopBagSvg"></a>
        </div>
    </div>
</nav>

<div class="container">
    <table>
        <caption>Vos commandes</caption>
        <thead>
            <tr>
                <th scope="col">Date et heure</th>
                <th scope="col">Prix total</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($orders as $order) {
            ?>
                <tr>
                    <td><?= $order["date"] ?></td>
                    <td><?= $order["price"] ?></td>
                    <td><a href=<?= "detailsOrder.php?id=" . $order['id'] ?>>Voir plus</a></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<?php
require_once('../../footer.php');
?>