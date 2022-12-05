<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=gobeboucollection', 'root','');

 
if(isset($_POST['formconnexion'])) {
   $mailconnect = htmlspecialchars($_POST['mailconnect']);
   $mdpconnect = sha1($_POST['mdpconnect']);
   if(!empty($mailconnect) AND !empty($mdpconnect)) {
      $requser = $bdd->prepare("SELECT * FROM user WHERE email = ? AND mdp = ?");
      $requser->execute(array($mailconnect, $mdpconnect));
      $userexist = $requser->rowCount();
      if($userexist == 1) {
         $userinfo = $requser->fetch();
         $_SESSION['id'] = $userinfo['id'];
         $_SESSION['pseudo'] = $userinfo['pseudo'];
         $_SESSION['email'] = $userinfo['email'];
         header("Location: profil.php?id=".$_SESSION['id']);
      } else {
         $erreur = "Mauvais mail ou mot de passe !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
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
      <h2>Connexion</h2>
      <h3>C'est simple et rapide !</h3>
      <form class="form" method="POST">
         <div class="textbox">
            <input type="text" name="mailconnect" required />
            <label>Email</label>
            <span class="material-symbols-outlined"> email </span>
         </div>
         <div class="textbox">
            <input type="password" name="mdpconnect" required />
            <label>Mot de passe</label>
            <span class="material-symbols-outlined"> key </span>
         </div>
         <p>
            Tu n'as pas de compte ?
            <a href="../back/register.php">Inscris-toi</a>
         </p>

         <button type="submit" name="formconnexion" >
            Connecte-toi
            <span class="material-symbols-outlined"> arrow_forward </span>
         </button>
      </form>
   </div>
</body>
</html>

