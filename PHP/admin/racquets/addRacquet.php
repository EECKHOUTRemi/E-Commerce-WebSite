<?php
require_once('../../header.php');

session_start();

if (!isset($_SESSION) || $_SESSION['role'] !== 'admin') {
    header('Location:../index.php');
    die;
}

$result = $bdd->query('SELECT * FROM racquets');
$racquets = $result->fetchAll();

$dir = './upload/';



if (isset($_POST['brand']) && isset($_POST['model']) && isset($_POST['price'])) {

    if (isset($_FILES['image'])) {
        move_uploaded_file($_FILES['image']['tmp_name'], $dir . $_FILES['image']['name']);
    }

    $rqRacquets = $bdd->prepare('INSERT INTO `racquets`(`brand`, `model`, `price`, `head_size`, `string_pattern`, `weight`, `grip_size`, `image`) VALUES (:brand, :model, :price, :head_size, :string_pattern, :racquetWeight, :grip_size, :racquetImage)');
    $rqRacquets->execute([
        'brand' => $_POST['brand'],
        'model' => $_POST['model'],
        'price' => $_POST['price'],
        'head_size' => $_POST['head_size'],
        'string_pattern' => $_POST['string_pattern'],
        'racquetWeight' => $_POST['weight'],
        'grip_size' => $_POST['grip_size'],
        'racquetImage' => $dir . $_FILES['image']['name']
    ]);

    header('Location:index.php');
}
?>

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
    <h1>Ajouter une raquette :</h1>
    <form enctype="multipart/form-data" method="POST" class="addRacquet">

        <div class="formBrand label-input">
            <label for="brand">La marque : </label>
            <input type="text" name="brand" placeholder="Marque">
        </div>

        <div class="formModel label-input">
            <label for="model">Le modèle : </label>
            <input type="text" name="model" placeholder="Modèle">
        </div>

        <div class="formPrice label-input">
            <label for="price">Le prix : </label>
            <input type="text" name="price" placeholder="Prix">
        </div>

        <div class="formHeadSize label-input">
            <label for="head_size">La taille du tamis : </label>
            <input type="text" name="head_size" placeholder="Taille du tamis">
        </div>

        <div class="formStringPattern label-input">
            <label for="string_pattern">Le pattern du tamis : </label>
            <input type="text" name="string_pattern" placeholder="Pattern du tamis">
        </div>

        <div class="formWeight label-input">
            <label for="weight">Le poids : </label>
            <input type="text" name="weight" placeholder="Poids">
        </div>

        <div class="formHadleSize label-input">
            <label for="handle_size">La taille du manche : </label>
            <input type="text" name="grip_size" placeholder="Taille du manche">
        </div>

        <div class="formImg label-input">
            <label for="image">La taille du manche : </label>
            <input type="file" name="image">
        </div>

        <input type="submit" value="Ajouter">
    </form>
</div>

<?php
require_once('../../footer.php');
?>