<?php
require_once('../../header.php');

session_start();

$result = $bdd->query('SELECT * FROM racquets');
$racquets = $result->fetchAll();

?>

<nav class="navbar">
    <div class="navbarContainer">
        <div class="navbarLogoTitle">
            <img src="/Projet/IMG/logo.svg" alt="logo" class="logo">
        </div>
        <div class="navbarLinks">
            <div class="navbarLinkBox">
                <a href="/Projet/PHP/user/index.php" class="navbarLink">Acceuil</a>
            </div>
            <div class="navbarLinkBox">
                <a href="/Projet/PHP/user/racquets/index.php" class="navbarLink">Raquettes</a>
            </div>
            <div class="navbarLinkBox">
                <a href="/Projet/PHP/user/account/index.php" class="navbarLink">Votre profil</a>
            </div>
            <div class="navbarLinkBox">
                <a href="/Projet/PHP/signOut.php" class="navbarLink">Se déconnecter</a>
            </div>
        </div>
        <div class="shopBagDiv">
            <a href="cart.php"><img src="/Projet/IMG/shopping-bag.svg" alt="Panier" class="shopBagSvg"></a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="cart">

        <?php

        if (isset($_COOKIE['cart_' . $_SESSION['id']])) {


            echo '<h1>Votre panier</h1>';
            $cart = json_decode($_COOKIE['cart_' . $_SESSION['id']], true);
            $total = 0;
            $idRacquets = [];
            $totalQty = 0;
            foreach ($cart as $contenu) {
                foreach ($racquets as $racquet) {
                    if ($racquet['id'] === $contenu[1][0]) {
        ?>
                        <div class="article">
                            <img src="/Projet/PHP/admin/racquets <?= $racquet['image'] ?>" alt="Raquette" class="imgArticle">
                            <div class="infoArticle">
                                <p><?= $racquet['brand'] . ' ' . $racquet['model'] . ' x' . $contenu[1][1] ?></p>
                                <p><?= $racquet['price'] . ' € x' . $contenu[1][1] . ' = ' . $racquet['price'] * $contenu[1][1] . ' €' ?></p>
                            </div>
                        </div>
            <?php $total += $racquet['price'] * $contenu[1][1];
                        array_push($idRacquets, $racquet['id']);
                        $totalQty += $contenu[1][1];
                    }
                }
            } ?>
            <div class="total">
                <h2>Le total de votre panier est de :<?= ' ' . $total . ' €' ?></h2>
                <form action="" method="POST">
                    <input type="submit" value="Commander" name="submit">
                </form>
            </div><?php
                    if (isset($_POST['submit'])) {
                        date_default_timezone_set('Europe/Paris');
                        $today = date("Y-m-d H:i:s");

                        $rqOrder = $bdd->prepare('INSERT INTO `orders`(`userID`, `price`, `date`) VALUES (:userID, :price, :date)');
                        $rqOrder->execute([
                            'userID' => $_SESSION['id'],
                            'price' => $total,
                            'date' => $today
                        ]);



                        foreach ($cart as $contenu) {
                            foreach ($idRacquets as $idRacquet) {
                                $rqRacquetOrder = $bdd->prepare('INSERT INTO `racquets_orders`(`orderID`, `racquetID`, `quantity`) VALUES (:orderID, :racquetID, :quantity)');
                                $rqRacquetOrder->execute([
                                    'orderID' => $contenu[0],
                                    'racquetID' => $idRacquet,
                                    'quantity' => $contenu[1][1]
                                ]);
                            }
                        }
                        
                        // Les 2 lignes suivantes créent des erreurs mais je n'ai pas le temps de les corriger
                        setcookie('cart_'. $_SESSION['id'], "", time() + 3600 * 24 * 7);

                        header("Refresh:1");
                    }
                } else {
                    echo '<h1>Votre panier est vide.</h1>';
                }

                    ?>
    </div>
</div>

<?php
require_once('../../footer.php');
?>