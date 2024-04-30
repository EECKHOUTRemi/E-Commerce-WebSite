<?php
require_once('../../header.php');

session_start();

if (!isset($_SESSION) || $_SESSION['role'] !== 'admin') {
    header('Location:../index.php');
    die;
}

$result = $bdd->query('SELECT * FROM users');
$users = $result->fetchAll();
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
    </nav>

    <div class="container">
        <table>
            <caption>Les Utilisateurs</caption>
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Identifiant</th>
                    <th scope="col">Nom de famille</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Adresse e-mail</th>
                    <th scope="col">Rôle</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($users as $user) {                    
                ?>
                    <tr>
                        <td><?= $user["id"] ?></td>
                        <td><?= $user["username"] ?></td>
                        <td><?= $user["lastname"] ?></td>
                        <td><?= $user["firstname"] ?></td>
                        <td><?= $user["email"] ?></td>
                        <td><?= $user["role"] ?></td>
                        <td>
                            <a href=<?= "updateUser.php?id=" . $user["id"] ?>>Modifier</a><br>
                            --------<br>
                            <a href=<?= "deleteUser.php?id=" . $user['id'] ?>>Supprimer</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
                <tr>
                    <?php
                    for ($i = 0; $i < 6; $i++) {
                    ?>
                        <td>--</td>
                    <?php
                    }
                    ?>
                    <td><a href="addUser.php">Ajouter un utilisateur</a></td>
                </tr>
            </tbody>
        </table>
    </div>

    <?php
    require_once('../../footer.php');
    ?>