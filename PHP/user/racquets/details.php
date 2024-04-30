<?php
require_once('../../header.php');

session_start();

if (!isset($_SESSION['id'])) {
    header('Location:../index.php');
    die;
}

$rqRacquets = $bdd->prepare('SELECT * FROM racquets WHERE id=?');
$rqRacquets->execute([$_GET["id"]]);
$racquet = $rqRacquets->fetch();

if (isset($_POST['qty'])) {

    $product = [$racquet['id'], (int)$_POST['qty']];

    $result = $bdd->query('SELECT * FROM orders');
    $orders = $result->fetchAll();
    foreach ($orders as $order) {
        $maxId = 0;
        if ($order['id'] > $maxId) {
            $maxId = $order['id'];
        }
    }

    if (!isset($_COOKIE['cart_' . $_SESSION['id']])) {

        setcookie('cart_' . $_SESSION['id'], json_encode([1 => [$maxId+1,$product]]), time() + 3600 * 24 * 7);
    } else {
        $cookie = json_decode($_COOKIE['cart_' . $_SESSION['id']], true);
        array_push($cookie, [$maxId+1,$product]);
        setcookie('cart_' . $_SESSION['id'], json_encode($cookie), time() + 3600 * 24 * 7);
    }

    header("Location:index.php");
}

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

<div class="container">
    <div class="containerProduct">

        <div class="title">
            <h1><?= $racquet['brand'] . ' ' . $racquet['model'] ?></h1>
        </div>

        <div class="product">

            <div class="left">
                <img src="/Projet/PHP/admin/racquets<?= $racquet['image'] ?>" alt="<?= $racquet["brand"] . ' ' . $racquet["model"] ?>" class="img">
            </div>

            <div class="right">

                <div class="infos">
                    <label><b>Poids :</b></label>
                    <?= $racquet['weight'] ?> g
                </div>

                <div class="infos">
                    <label><b>Taille du manche :</b></label>
                    <?= $racquet['grip_size'] ?>
                </div>

                <div class="infos">
                    <label><b>Pattern du cordage :</b></label>
                    <?= $racquet['string_pattern'] ?>
                </div>

                <div class="infos">
                    <label><b>Taille du tamis :</b></label>
                    <?= $racquet['head_size'] ?> cm
                </div>

                <div class="infos">
                    <label><b>Prix :</b></label>
                    <?= $racquet['price'] ?> €
                </div>

                <div class="formBuy">
                    <form action="" method="POST">
                        <input type="number" name="qty" class="buyNb" value=1 min=1>
                        <input type="submit" class="buyBtn" value="Ajouter au panier">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once('../../footer.php');
?>