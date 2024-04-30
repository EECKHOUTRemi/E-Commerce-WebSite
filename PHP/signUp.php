<?php
require_once('header.php');

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role'])) {

    $cryptedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $rqUsers = $bdd->prepare('INSERT INTO users (username, password, role) VALUES (:username, :password, :role)');
    $rqUsers->execute([
        'username' => $_POST['username'],
        'password' => $cryptedPassword,
        'role' => 'user',
    ]);

    header("Location:index.php");
    die;
}
?>

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

            <h1>Inscrivez vous !</h1>

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
                        <input type="submit" value="Inscription" class="submit">
                    </div>

                </div>
            </form>

            <p>Vous avez un compte ? <a href="index.php">Connectez vous !</a></p>
        </div>
    </div>

    <?php
    require_once('footer.php');
    ?>