<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Js Modal</title>
    <link rel="stylesheet" href="../front/collection.css">
    <script defer src="script.js"></script>
</head>

<body>

    <button id="open-btn">
        <p>Ajouter une carte</p>
    </button>
    <img class="clouds" src="../IMG/Twinkle Star-2.6s-1973px.svg">
    <div class="signup">
        <div class="form">
            <h2>Profil de <?php echo $userinfo['pseudo']; ?></h2>
            <span> Pseudo = <?php echo $userinfo['pseudo']; ?></span>
            <span>Mail = <?php echo $userinfo['email']; ?>
                <?php
                if (isset($_SESSION['id']) and $userinfo['id'] == $_SESSION['id']) {
                ?>
                    <div class="textbox">
                        <a href="collection.php">Voir ma collection</a>
                        <a href="editionprofil.php">Editer mon profil</a>
                        <a href="deconnexion.php">Se déconnecter</a>
                    </div>
        </div>
    <?php
                }
    ?>
    </div>
    </div>

    <div id="modal-container">
        <div id="modal">
            <form action="collection.php" method="POST">
                <label for="product-name">Nom du produit :</label>
                <input type="text" id="product-name" name="productname">
                <br>
                <label for="product-description">Description du produit :</label>
                <textarea id="product-description" name="productdescription"></textarea>
                <br>
                <label for="product-price">Prix du produit :</label>
                <input type="number" id="product-price" name="productprice">
                <br>
                <label for="product-image">Image du produit :</label>
                <input type="file" id="product-image" name="productimage">
                <br>
                <input type="submit" name="formcard" value="Enregistrer le produit">
            </form>
            <div id="close-btn">
                &times;
            </div>
        </div>
    </div>
    <div class="parent"> <?php
                            session_start();

                            $bdd = new PDO('mysql:host=localhost;dbname=gobeboucollection', 'root', '');

                            $test = $_SESSION['id'];


                            $sql = ('SELECT * FROM article WHERE user_id =' . $test . '');
                            $requete = $bdd->query($sql);
                            $article = $requete->fetchAll();

                            // Loop through the result set and create a card for each product
                            foreach ($article as $article) {
                                // Get the product information from the result set
                                $productName = $article['name'];
                                $productDescription = $article['description'];
                                $productPrice = $article['price'];
                                $productImage = $article['image'];
                                // Create the HTML for the product card
                                echo "<div class='card'>";
                                echo "  <img src='$productImage' alt='Product Image'>";
                                echo "  <div class='card-body'>";
                                echo "    <h4 class='card-title'>$productName</h4>";
                                echo "    <p class='card-text'>$productDescription</p>";
                                echo "    <p class='card-text'>Prix : $productPrice</p>";
                                echo "  </div>";
                                echo "</div>";
                            }
                            ?>
    </div>
</body>

</html>




<?php
// Connect to the database

$bdd = new PDO('mysql:host=localhost;dbname=gobeboucollection', 'root', '');


if (isset($_GET['id']) and $_GET['id'] > 0) {
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM user WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();
}


if (isset($_POST['formcard'])) {
    $name = htmlspecialchars($_POST['productname']);
    $description = htmlspecialchars($_POST['productdescription']);
    $price = htmlspecialchars($_POST['productprice']);
    $image = htmlspecialchars($_POST['productimage']);
    $iduser = $_SESSION['id'];
    //echo "    <h4 class='card-title'>$name</h4>";
    if (!empty($_POST['productname']) and !empty($_POST['productdescription']) and !empty($_POST['productprice'])) {
        $insertcard = $bdd->prepare("INSERT INTO article(name, description, price,image,user_id) VALUES(?, ?, ?,?,?)");
        $insertcard->execute(array($name, $description, $price, $image, $iduser));
        header("Location: collection.php");
    } else {
        $erreur = "Tous les champs doivent être complétés !";
    }
}

// Close the database connection

?>

<script>
    let openBtn = document.getElementById('open-btn');
    let modalContainer = document.getElementById('modal-container');
    let closeBtn = document.getElementById('close-btn');


    openBtn.addEventListener('click', function() {
        modalContainer.style.display = 'block';
    });


    closeBtn.addEventListener('click', function() {
        modalContainer.style.display = 'none';
    });


    window.addEventListener('click', function(e) {

        if (e.target === modalContainer) {
            modalContainer.style.display = 'none';
        }
    })
</script>