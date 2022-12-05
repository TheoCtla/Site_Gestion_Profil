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
   // if (isset($pseudo)) {
   //    echo $pseudo;
   // }
   // if (isset($mail)) {
   //    echo $mail;
   // }
   // if (isset($mail2)) {
   //    echo $mail2;
   // }
}
?>

<html>


<head>
   <meta charset="utf-8">
   <link rel="stylesheet" href="../front/register.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,600,0,0" />
</head>

<body>
   <img class="clouds" src="../IMG/bg.svg" />
   <div class="signup">
      <h2>Inscription</h2>
      <h3>C'est simple et rapide !</h3>
      <form class="form" method="POST">
         <div class="textbox">
            <input type="text" name="pseudo" required />
            <label>Nom</label>
            <span class="material-symbols-outlined"> account_circle </span>
         </div>
         <div class="textbox">
            <input type="text" name="mail" required />
            <label>Email</label>
            <span class="material-symbols-outlined"> email </span>
         </div>
         <div class="textbox">
            <input type="text" name="mail2" required />
            <label>Confirmation Email</label>
            <span class="material-symbols-outlined"> email </span>
         </div>
         <div class="textbox">
            <input type="password" name="mdp" required />
            <label>Mot de passe</label>
            <span class="material-symbols-outlined"> key </span>
         </div>
         <div class="textbox">
            <input type="password" name="mdp2" required />
            <label>Confirmation mot de passe</label>
            <span class="material-symbols-outlined"> key </span>
         </div>
         <p>
            Tu as déjà un compte ?
            <a href="../back/login.php">Connecte-toi</a>
         </p>

         <button type="submit" name="forminscription">
            Rejoin-nous
            <span class="material-symbols-outlined"> arrow_forward </span>
         </button>
      </form>
   </div>
</body>

</html>