<?php
require_once('../../header.php');

session_start();

if (!isset($_SESSION)) {
    header('Location:../index.php');
    die;
}

$rqUsers = $bdd->prepare('SELECT * FROM users WHERE id=?');
$rqUsers->execute([$_SESSION["id"]]);
$user = $rqUsers->fetch();

$dir = './upload/';

if (isset($_POST["username"])) {

    $updateInfo = [
        'username' => $_POST['username'],
        'password' => $_POST['password'],
        'lastname' => $_POST['lastname'],
        'firstname' => $_POST['firstname'],
        'email' => $_POST['email'],
        'id' => $_SESSION['id']
    ];

    // TODO mettre un commentaire
    if( !empty($updateInfo['password']) && password_verify($updateInfo['password'], $user['password']) ) {
        $_SESSION['error'] = "Veuillez saisir un mot de passe différent de l'ancien";

        header('Location:updateUser.php?id='.$_GET['id']);
        die;
    }

    /**
     * Préparation de la requête SQL d'update
     */
    $sqlUpdate = 'UPDATE users SET ' .
        ('lastname = ' . ($updateInfo['lastname'] ? ':lastname' : 'NULL') . ',') .
        ('email = ' . ($updateInfo['email'] ? ':email' : 'NULL') . ',') .
        ('firstname = ' . ($updateInfo['firstname'] ? ':firstname' : 'NULL') . ',') .
        ($updateInfo['username'] ? ' username = :username,' : '') .
        ($updateInfo['password'] ? ' password = :password,' : '');

    // Suppression de la dernière virgule inutile
    $sqlUpdate = rtrim($sqlUpdate, ',');
    $sqlUpdate = $sqlUpdate . ' WHERE id=:id';

    $rqUpdateUser = $bdd->prepare($sqlUpdate);

    /**
     * Préparation des paramètres SQL nommés
     */
    $preparedArguments['id'] = $_SESSION['id'];
    ($updateInfo['username'] ? $preparedArguments['username'] = $updateInfo['username'] : '');
    ($updateInfo['password'] ? $preparedArguments['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT) : '');
    ($updateInfo['lastname'] ? $preparedArguments['lastname'] = $updateInfo['lastname'] : '');
    ($updateInfo['firstname'] ? $preparedArguments['firstname'] = $updateInfo['firstname'] : '');
    ($updateInfo['email'] ? $preparedArguments['email'] = $updateInfo['email'] : '');

    $rqUpdateUser->execute($preparedArguments);

    header('Location:index.php');
    die;
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
            <a href="../racquets/cart.php"><img src="/Projet/IMG/shopping-bag.svg" alt="Panier" class="shopBagSvg"></a>
        </div>
    </div>
</nav>

<div class="container">
<div class="cardForm">

<h1>Vos information personnelles </h1>

    <form action="" method="POST" class="form">
        <div class="label-input">
            <label for="username">Votre identifiant :</label>
            <input type="text" name="username" placeholder="Identifiant" value=<?= "'" . $user['username'] . "'" ?>>
        </div>

        <div class="label-input">
            <label for="password">Votre mot de passe :</label>
            <input type="password" name="password" placeholder="Nouveau mot de passe">
        </div>

        <div class="label-input">
            <label for="lastname">Votre nom de famille :</label>
            <input type="text" name="lastname" placeholder="Nom de famille" value=<?= "'" . $user['lastname'] . "'" ?>>
        </div>

        <div class="label-input">
            <label for="firstname">Votre prénom :</label>
            <input type="text" name="firstname" placeholder="Prénom" value=<?= "'" . $user['firstname'] . "'" ?>>
        </div>

        <div class="label-input">
            <label for="email">Votre adresse e-mail :</label>
            <input type="email" name="email" placeholder="E-mail" value=<?= "'" . $user['email'] . "'" ?>>
        </div>

        <input type="submit" value="Modifier" class="submit">
    </form>
</div>
<?php
require_once('../../footer.php');
?>