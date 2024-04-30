<?php
require_once('../../header.php');

session_start();

if (!isset($_SESSION) || $_SESSION['role'] !== 'admin') {
    header('Location:../index.php');
    die;
}

$rqUsers = $bdd->prepare('SELECT * FROM users WHERE id=?');
$rqUsers->execute([$_GET["id"]]);
$user = $rqUsers->fetch();

$dir = './upload/';

if (isset($_POST["username"]) && isset($_POST["role"])) {
    $updateInfo = [
        'username' => $_POST['username'],
        'password' => $_POST['password'],
        'lastname' => $_POST['lastname'],
        'firstname' => $_POST['firstname'],
        'email' => $_POST['email'],
        'role' => $_POST['role']
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
        ($updateInfo['password'] ? ' password = :password,' : '') .
        ($updateInfo['role'] ? ' role = :role,' : '');

    // Suppression de la dernière virgule inutile
    $sqlUpdate = rtrim($sqlUpdate, ',');
    $sqlUpdate = $sqlUpdate . ' WHERE id=:id';

    $rqUpdateUser = $bdd->prepare($sqlUpdate);

    /**
     * Préparation des paramètres SQL nommés
     */
    $preparedArguments['id'] = $_GET['id'];
    ($updateInfo['username'] ? $preparedArguments['username'] = $updateInfo['username'] : '');
    ($updateInfo['password'] ? $preparedArguments['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT) : '');
    ($updateInfo['lastname'] ? $preparedArguments['lastname'] = $updateInfo['lastname'] : '');
    ($updateInfo['firstname'] ? $preparedArguments['firstname'] = $updateInfo['firstname'] : '');
    ($updateInfo['email'] ? $preparedArguments['email'] = $updateInfo['email'] : '');
    ($updateInfo['role'] ? $preparedArguments['role'] = $updateInfo['role'] : '');

    $rqUpdateUser->execute($preparedArguments);


    header('Location:index.php');
    die;
}

function role($user)
{
    if ($user === 'user') {
        return 'admin';
    } elseif ($user === 'admin') {
        return 'user';
    }
}

?>
</head>

<body>

    <!-- <nav class="navbar">
        <div class="navbarContainer">
            <div class="navbarLogoTitle">
                <img src="/Projet/IMG/logo.svg" alt="logo" class="logo">
            </div>
            <div class="navbarLinks">
                <div class="navbarLinkBox">
                    <a href="../index.php" class="navbarLink ">Acceuil</a>
                </div>
                <div class="navbarLinkBox">
                    <a href="../racquets/index.php" class="navbarLink ">Raquettes</a>
                </div>
                <div class="navbarLinkBox">
                    <a href="index.php" class="navbarLink ">Utilisateurs</a>
                </div>
                <div class="navbarLinkBox">
                    <a href="../../signOut.php" class="navbarLink ">Se déconnecter</a>
                </div>
            </div>
        </div>
    </nav> -->

    <div class="container">
        <h1>Modifier les caracteristiques de <?= $user["username"] ?> :</h1>

        <?php if (!empty($_SESSION['error']) ) {
            echo '<p class="error">'.$_SESSION['error'].'</p>';
            unset($_SESSION['error']);
        }
        ?>

        <form enctype="multipart/form-data" method="POST" class="addUser">

            <div class="label-input">
                <label for="username">Son identifiant :</label>
                <input type="text" name="username" placeholder="Identifiant" value=<?= "'" . $user['username'] . "'" ?>>
            </div>

            <div class="label-input">
                <label for="password">Son mot de passe :</label>
                <input type="password" name="password" placeholder="Nouveau mot de passe">
            </div>

            <div class="label-input">
                <label for="lastname">Son nom de famille :</label>
                <input type="text" name="lastname" placeholder="Nom de famille" value=<?= "'" . $user['lastname'] . "'" ?>>
            </div>

            <div class="label-input">
                <label for="firstname">Son prénom :</label>
                <input type="text" name="firstname" placeholder="Prénom" value=<?= "'" . $user['firstname'] . "'" ?>>
            </div>

            <div class="label-input">
                <label for="email">Son adresse e-mail :</label>
                <input type="email" name="email" placeholder="E-mail" value=<?= "'" . $user['email'] . "'" ?>>
            </div>

            <div class="label-input">
                <label for="role">Son rôle :</label>
                <select name="role">
                    <option value=<?= $user['role'] ?>><?= $user['role'] ?></option>
                    <option value=<?= role($user['role']) ?>><?= role($user['role']) ?></option>
                </select>
            </div>

            <input type="submit" value="Modifier">
            <a href="index.php" class="navbarLink ">Annuler</a>
        </form>
    </div>

    <?php
    require_once('../../footer.php');
    ?>