<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=gobeboucollection', 'root', '');


if (isset($_SESSION['id'])) {
   $requser = $bdd->prepare("SELECT * FROM user WHERE id = ?");
   $requser->execute(array($_SESSION['id']));
   $user = $requser->fetch();
   if (isset($_POST['newpseudo']) and !empty($_POST['newpseudo']) and $_POST['newpseudo'] != $user['pseudo']) {
      $newpseudo = htmlspecialchars($_POST['newpseudo']);
      $insertpseudo = $bdd->prepare("UPDATE user SET pseudo = ? WHERE id = ?");
      $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
      header('Location: profil.php?id=' . $_SESSION['id']);
   }
   if (isset($_POST['newmail']) and !empty($_POST['newmail']) and $_POST['newmail'] != $user['mail']) {
      $newmail = htmlspecialchars($_POST['newmail']);
      $insertmail = $bdd->prepare("UPDATE user SET email = ? WHERE id = ?");
      $insertmail->execute(array($newmail, $_SESSION['id']));
      header('Location: profil.php?id=' . $_SESSION['id']);
   }
   if (isset($_POST['newmdp1']) and !empty($_POST['newmdp1']) and isset($_POST['newmdp2']) and !empty($_POST['newmdp2'])) {
      $mdp1 = sha1($_POST['newmdp1']);
      $mdp2 = sha1($_POST['newmdp2']);
      if ($mdp1 == $mdp2) {
         $insertmdp = $bdd->prepare("UPDATE user SET mdp = ? WHERE id = ?");
         $insertmdp->execute(array($mdp1, $_SESSION['id']));
         header('Location: profil.php?id=' . $_SESSION['id']);
      } else {
         $msg = "Vos deux mdp ne correspondent pas !";
      }
   }
?>
   <html>

   <head>
      <title>TUTO PHP</title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="../front/editionprofil.css">
   </head>

   <body>
      <img class="clouds" src="../IMG/Clouds-66.7s-1920px.svg">
      <div class="signup">
         <h2>Edition de mon profil</h2>

         <form class="form" method="POST" action="" enctype="multipart/form-data">
            <div class="textbox">
               <label>Modifier Pseudo :</label>
               <input type="text" name="newpseudo" placeholder="Pseudo" value="<?php echo $user['pseudo']; ?>" />
            </div>
            <div class="textbox">
               <label>Modifier Mail :</label>
               <input type="email" name="newmail" placeholder="Mail" value="<?php echo $user['email']; ?>" />
            </div>
            <div class="textbox">
               <label>Modifier Mot de passe :</label>
               <input type="password" name="newmdp1" placeholder="Mot de passe" />
            </div>
            <div class="textbox">
               <label>Modifier confirmation de mot de passe :</label>
               <input type="password" name="newmdp2" placeholder="Confirmation du mot de passe" />
            </div>
            <div class="textbox">
               <input type="submit" value="Mettre à jour mon profil !" />
         </form>
         <?php if (isset($msg)) {
            echo $msg;
         } ?>

      </div>
   </body>

   </html>
<?php
} else {
   header("Location: connexion.php");
}
?>