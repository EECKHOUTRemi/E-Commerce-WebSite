<?php
require_once('../../header.php');

session_start();

if (!isset($_SESSION) || $_SESSION['role'] !== 'admin') {
    header('Location:../index.php');
    die;
}

$result = $bdd->query('SELECT * FROM users');
$users = $result->fetchAll();

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role'])) {

    $cryptedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $rqUsers = $bdd->prepare('INSERT INTO users (username, password, role) VALUES (:username, :password, :role)');
    $rqUsers->execute([
        'username' => $_POST['username'],
        'password' => $cryptedPassword,
        'role' => $_POST['role'],
    ]);

    header("Location:index.php");
    die;
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
        <h1>Ajouter un utilisateur :</h1>
        <form enctype="multipart/form-data" method="POST" class="addUser">

            <div class="formUsername label-input">
                <label for="username">Son identifiant : </label>
                <input type="text" name="username" placeholder="Identifiant">
            </div>

            <div class="formPassword label-input">
                <label for="password">Son mot de passe : </label>
                <input type="password" name="password" placeholder="Mot de passe">
            </div>

            <div class="formRole label-input">
                <label for="role">Son rôle : </label>
                <select name="role">
                    <option value="user">User</option>
                    <option value=admin>Admin</option>
                </select>
            </div>

            <input type="submit" value="Ajouter">
        </form>
    </div>

    <?php
    require_once('../../footer.php');
    ?>