<?php
require_once('header.php');

session_start();

if (isset($_POST["username"]) && isset($_POST["password"])) {

    $rqUsers = $bdd->prepare('SELECT * FROM users WHERE username=?');
    $rqUsers->execute([$_POST["username"]]);
    $user = $rqUsers->fetch();

    $username = $_POST['username'];
    $verifyPassword = password_verify($_POST['password'], $user['password']);

    if ($username === $user['username'] && $verifyPassword === True) {

        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'user') {
            header("Location:user/index.php?id=" . $user['id']);
            die;
        } else {
            header("Location:admin/index.php");
            die;
        }
    }
} else {
    if (isset($_SESSION["id"])) {
        if ($_SESSION['role'] === 'user') {
            header("Location:user/index.php");
            die;
        } else {
            header("Location:admin/index.php");
            die;
        }
    }
}
?>

</head>

<body>

    <!-- ------------------------------------------ Navbar ------------------------------------------ -->

    <nav class="navbar">
        <div class="navbarContainer">
            <div class="navbarLogoTitle">
                <img src="/Projet/IMG/logo.svg" alt="logo" class="logo">
            </div>
        </div>
    </nav>

    <!-- ------------------------------------------ Container ------------------------------------------ -->

    <div class="container">

        <div class="cardForm">

            <h1>Connectez-vous !</h1>

            <form action="" method="POST">
                <div class="form">

                    <div class="username">
                        <label for="username">Votre identifiant :</label>
                        <input type="text" name="username" class="formUsername" placeholder="Identifiant">
                    </div>

                    <div class="password">
                        <label for="password">Votre mot de passe :</label>
                        <input type="password" name="password" class="formPassword" placeholder="Mot de passe">
                    </div>

                    <div class="submit">
                        <input type="submit" value="Connexion" class="submit">
                    </div>

                </div>
            </form>

            <p>Vous n'avez pas de compte ? <a href="signUp.php">Créez-en un !</a></p>
        </div>
    </div>

    <?php
    require_once('footer.php');
    ?>