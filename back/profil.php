<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=gobeboucollection', 'root', '');


if (isset($_GET['id']) and $_GET['id'] > 0) {
   $getid = intval($_GET['id']);
   $requser = $bdd->prepare('SELECT * FROM user WHERE id = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();
?>
   <html>

   <head>
      <title>TUTO PHP</title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="../front/profil.css">
   </head>

   <body>
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
                  <a href="editionprofil.php">Editer mon profil</a>
                  <a href="deconnexion.php">Se déconnecter</a>
               </div>
            </div>
         <?php
         }
         ?>
      </div>
      </div>
   </body>

   </html>
<?php
}
?>