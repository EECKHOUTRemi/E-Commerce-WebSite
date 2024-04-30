<?php
require_once('../../header.php');

session_start();

if (!isset($_SESSION)) {
    header('Location:../../index.php');
    die;
}

// Une erreur d'INSERT fait qu'il y a des doublons dans la base de données, n'ayant pas le temps de corriger cela, les doublons sont visibles dans le détail des commandes de l'utilisateur
$result = $bdd->query('SELECT * FROM orders 
    LEFT JOIN racquets_orders ON racquets_orders.orderID = orders.id 
    LEFT JOIN racquets ON racquets.id = racquets_orders.racquetID
    WHERE orders.id=' . $_GET['id'] );

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
    <h1>Votre commande :</h1>

    <table>
        <thead>
            <tr>
                <th scope="col">Raquette</th>
                <th scope="col">Prix de la raquette</th>
                <th scope="col">Nombre de raquettes</th>
                <th scope="col">Prix total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($orders as $order) {
            ?>
                <tr>
                    <td><?= $order['brand'] . ' ' . $order['model'] ?></td>
                    <td><?= $order['price'] ?></td>
                    <td><?= $order['quantity'] ?></td>
                    <td><?= $order['price']*$order['quantity'] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div> 
</div>


<?php
require_once('../../footer.php');
?>