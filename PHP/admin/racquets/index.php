<?php
require_once('../../header.php');

session_start();

if (!isset($_SESSION) || $_SESSION['role'] !== 'admin') {
    header('Location:../index.php');
    die;
}

$result = $bdd->query('SELECT * FROM racquets');
$racquets = $result->fetchAll();
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
                    <a href="index.php" class="navbarLink ">Raquettes</a>
                </div>
                <div class="navbarLinkBox">
                    <a href="../users/index.php" class="navbarLink ">Utilisateurs</a>
                </div>
                <div class="navbarLinkBox">
                    <a href="../../signOut.php" class="navbarLink ">Se déconnecter</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <table>
            <caption>Les Raquettes</caption>
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Marque</th>
                    <th scope="col">Modèle</th>
                    <th scope="col">Prix</th>
                    <th scope="col">Taille du tamis</th>
                    <th scope="col">Pattern du tamis</th>
                    <th scope="col">Poids</th>
                    <th scope="col">Taille du manche</th>
                    <th scope="col">Chemin de l'image</th>
                    <th scope="col">Image</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($racquets as $racquet) {
                ?>
                    <tr>
                        <td><?= $racquet["id"] ?></td>
                        <td><?= $racquet["brand"] ?></td>
                        <td><?= $racquet["model"] ?></td>
                        <td><?= $racquet["price"] ?> €</td>
                        <td><?= $racquet["head_size"] ?> cm</td>
                        <td><?= $racquet["string_pattern"] ?></td>
                        <td><?= $racquet["weight"] ?> g</td>
                        <td><?= $racquet["grip_size"] ?></td>
                        <td><?= $racquet["image"] ?></td>
                        <td style="text-align: center;"><img src="<?= $racquet['image'] ?>" alt="Raquette" height="100px"></td>
                        <td>
                            <a href=<?= "updateRacquet.php?id=" . $racquet["id"] ?>>Modifier</a><br>
                            --------<br>
                            <a href=<?= "deleteRacquet.php?id=" . $racquet['id'] ?>>Supprimer</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
                <tr>
                    <?php
                    for ($i = 0; $i < 10; $i++) {
                    ?>
                        <td>--</td>
                    <?php
                    }
                    ?>
                    <td><a href="addRacquet.php">Ajouter une raquette</a></td>
                </tr>
            </tbody>
        </table>
    </div>

    <?php
    require_once('../../footer.php');
    ?>