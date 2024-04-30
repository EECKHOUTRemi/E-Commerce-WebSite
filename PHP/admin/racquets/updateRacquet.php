<?php
require_once('../../header.php');

session_start();

if (!isset($_SESSION) || $_SESSION['role'] !== 'admin') {
    header('Location:../index.php');
    die;
}

$rqRacquets = $bdd->prepare('SELECT * FROM racquets WHERE id=?');
$rqRacquets->execute([$_GET["id"]]);
$racquet = $rqRacquets->fetch();

$dir = './upload/';

if (isset($_POST['brand']) || isset($_POST['model']) || isset($_POST['price']) || isset($_POST['head_size']) || isset($_POST['string_pattern']) || isset($_POST['weight']) || isset($_POST['grip_size']) || isset($_FILES['image'])) {


    $updateInfo = [
        'brand' => $_POST['brand'],
        'model' => $_POST['model'],
        'price' => $_POST['price'],
        'head_size' => $_POST['head_size'],
        'string_pattern' => $_POST['string_pattern'],
        'weight' => $_POST['weight'],
        'grip_size' => $_POST['grip_size'],
        'image' => $_FILES['image']['name']
    ];

    /**
     * Préparation de la requête SQL d'update
     */
    $sqlUpdate = 'UPDATE racquets SET ' .
        ('head_size = ' . ($updateInfo['head_size'] ? ':head_size' : 'NULL') . ',') .
        ('string_pattern = ' . ($updateInfo['string_pattern'] ? ':string_pattern' : 'NULL') . ',') .
        ('weight = ' . ($updateInfo['weight'] ? ':weight' : 'NULL') . ',') .
        ('grip_size = ' . ($updateInfo['grip_size'] ? ':grip_size' : 'NULL') . ',') .
        ($updateInfo['brand'] ? ' brand = :brand,' : '') .
        ($updateInfo['model'] ? ' model = :model,' : '') .
        ($updateInfo['price'] ? ' price = :price,' : '') .
        ($updateInfo['image'] ? ' image = :image,' : '');

        
        // Suppression de la dernière virgule inutile
        $sqlUpdate = rtrim($sqlUpdate, ',');
        $sqlUpdate = $sqlUpdate . ' WHERE id=:id';

        $rqUpdateRacquet = $bdd->prepare($sqlUpdate);
        
        /**
     * Préparation des paramètres SQL nommés
     */
    $preparedArguments['id'] = $_GET['id'];
    ($updateInfo['brand'] ? $preparedArguments['brand'] = $updateInfo['brand'] : '');
    ($updateInfo['model'] ? $preparedArguments['model'] = $updateInfo['model'] : '');
    ($updateInfo['price'] ? $preparedArguments['price'] = $updateInfo['price'] : '');
    ($updateInfo['head_size'] ? $preparedArguments['head_size'] = $updateInfo['head_size'] : '');
    ($updateInfo['string_pattern'] ? $preparedArguments['string_pattern'] = $updateInfo['string_pattern'] : '');
    ($updateInfo['weight'] ? $preparedArguments['weight'] = $updateInfo['weight'] : '');
    ($updateInfo['grip_size'] ? $preparedArguments['grip_size'] = $updateInfo['grip_size'] : '');
    ($updateInfo['image'] ? $preparedArguments['image'] = $dir . $updateInfo['image'] : '');

    $rqUpdateRacquet->execute($preparedArguments);


    /**foreach ($updateInfo as $column => $element) {

        if ($dir.$element !== $racquet[$column] && $element != Null) {

            if ($column === 'image') {
                
                unlink($racquet['image']);
                move_uploaded_file($_FILES['image']['tmp_name'], $dir . $element);
                
                $rqUpdateRacquet = $bdd->prepare('UPDATE `racquets` SET `image`=:dataUpdated WHERE id=:id');
                $rqUpdateRacquet->execute([
                    'dataUpdated' => $dir . $element,
                    'id' => $_GET["id"]
                ]);
                
            } else {
                
                $rqUpdateRacquet = $bdd->prepare('UPDATE `racquets` SET ' . $column . '=:dataUpdated WHERE id=:id');
                $rqUpdateRacquet->execute([
                    'dataUpdated' => $element,
                    'id' => $_GET["id"]
                ]);
            }
        }*/

        header('Location:index.php');
        die;
    //}
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
        <h1>Modifier les caracteristiques de la <?= $racquet["brand"] . ' ' . $racquet['model'] ?> :</h1>
        <form enctype="multipart/form-data" method="POST" class="addRacquet">

            <div class="formBrand label-input">
                <label for="brand">La marque : </label>
                <input type="text" name="brand" value=<?= "'" . $racquet['brand'] . "'" ?>>
            </div>

            <div class="formModel label-input">
                <label for="model">Le modèle : </label>
                <input type="text" name="model" value=<?= "'" . $racquet['model'] . "'" ?>>
            </div>

            <div class="formPrice label-input">
                <label for="price">Le prix : </label>
                <input type="text" name="price" value=<?= "'" . $racquet['price'] . "'" ?>> €
            </div>

            <div class="formHeadSize label-input">
                <label for="head_size">La taille du tamis : </label>
                <input type="text" name="head_size" value=<?= "'" . $racquet['head_size'] . "'" ?>> cm
            </div>

            <div class="formStringPattern label-input">
                <label for="string_pattern">Le pattern du tamis : </label>
                <input type="text" name="string_pattern" value=<?= "'" . $racquet['string_pattern'] . "'" ?>>
            </div>

            <div class="formWeight label-input">
                <label for="weight">Le poids : </label>
                <input type="text" name="weight" value=<?= "'" . $racquet['weight'] . "'" ?>> g
            </div>

            <div class="formHadleSize label-input">
                <label for="handle_size">La taille du manche : </label>
                <input type="text" name="grip_size" value=<?= "'" . $racquet['grip_size'] . "'" ?>>
            </div>

            <div class="formImg label-input">
                <label for="image">L'image : </label>
                <input type="file" name="image">
            </div>

            <input type="submit" value="Modifier">
            <a href="index.php" class="navbarLink ">Annuler</a>
        </form>
    </div>

    <?php
    require_once('../../footer.php');
    ?>