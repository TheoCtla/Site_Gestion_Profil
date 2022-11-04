<?php
$bdd = new PDO('mysql:host=localhost;dbname=gobeboucollection', 'root', '');
if (isset($_POST['forminscription'])) {
   $pseudo = htmlspecialchars($_POST['pseudo']);
   $mail = htmlspecialchars($_POST['mail']);
   $mail2 = htmlspecialchars($_POST['mail2']);
   $mdp = sha1($_POST['mdp']);
   $mdp2 = sha1($_POST['mdp2']);
   if (!empty($_POST['pseudo']) and !empty($_POST['mail']) and !empty($_POST['mail2']) and !empty($_POST['mdp']) and !empty($_POST['mdp2'])) {
      $pseudolength = strlen($pseudo);
      if ($pseudolength <= 255) {
         if ($mail == $mail2) {
            if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
               $reqmail = $bdd->prepare("SELECT * FROM user WHERE email = ?");
               $reqmail->execute(array($mail));
               $mailexist = $reqmail->rowCount();
               if ($mailexist == 0) {
                  if ($mdp == $mdp2) {
                     $insertmbr = $bdd->prepare("INSERT INTO user(pseudo, email, mdp) VALUES(?, ?, ?)");
                     $insertmbr->execute(array($pseudo, $mail, $mdp));
                  } else {
                     $erreur = "Vos mots de passes ne correspondent pas !";
                  }
               } else {
                  $erreur = "Adresse mail déjà utilisée !";
               }
            } else {
               $erreur = "Votre adresse mail n'est pas valide !";
            }
         } else {
            $erreur = "Vos adresses mail ne correspondent pas !";
         }
      } else {
         $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
   if (isset($pseudo)) {
      echo $pseudo;
   }
   if (isset($mail)) {
      echo $mail;
   }
   if (isset($mail2)) {
      echo $mail2;
   }
   if (isset($erreur)) {
      echo '<font color="red" class="err">' . $erreur . "</font>";
   }
}
?>

<html>

<head>
   <title>TUTO PHP</title>
   <meta charset="utf-8">
   <link rel="stylesheet" href="../front/register.css">
   <link rel="stylesheet" href="../front/reset.css">
</head>

<body>
   <h2 class="titre">Inscription</h2>
   <div class="login-box">
      <form method="POST" action="" id="form">
         <div class="user-box">
            <input type="text" id="pseuso" name="pseudo" required>
            <label for="pseudo">Pseudo</label>
         </div>
         <div class="user-box">
            <input type="email" id="email" name="mail" required>
            <label for="mail" class="text">E-Mail</label>
         </div>
         <div class="user-box">
            <input type="email" id="mail2" name="mail2" required>
            <label for="mail2" class="text">Confirmation du mail</label>
         </div>
         <div class="user-box">
            <input type="password" id="mdp" name="mdp" required>
            <label for="mdp" class="text">Mot de passe</label>
         </div>
         <div class="user-box">
            <input type="password" id="mdp2" name="mdp2" required>
            <label for="mdp2" class="text">Confirmation du mot de passe</label>
         </div>
         <input type="submit" id="bouton" name="forminscription" value="Je m'inscris">
         <div id="inscription">
            <a>Vous avez déjà un compte ?</a>
            <a href="./login.php" class="connectez">Connectez-vous !</a>
         </div>
      </form>
   </div>
</body>

</html>