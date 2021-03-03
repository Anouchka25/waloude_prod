<?php

$to = "waloude20@gmail.com";   // Bouryt
// 2- On vérifie si la variable existe et sinon elle vaut NULL
$nom_prenom = isset($_POST['nom_prenom']) ? $_POST['nom_prenom'] : NULL;
$email = isset($_POST['email']) ? $_POST['email'] : NULL;
$message = isset($_POST['message']) ? $_POST['message'] : NULL;

//$email_address = $_POST['email'];
$email_subject = "[Waloude]Formulaire soumis sur le site waloude.org";
$email_body .= "Vous avez reçu un nouveau prospect. <br/>
  Nom & Prénom: " . $nom_prenom . " <br/>
	Email: " . $email . " <br/>
  Message: " . $message . " <br/>
	Vous pouvez maintenant appeler ce prospect intéressé(e) par vos services.";

$headers = "From:<$email>\n";
$headers .= "Content-Type:text/html; charset=UTF-8";
if ($email != "") {
  mail($to, $email_subject, $email_body, $headers);
  //return true;
  header('Location: /pages/etrerappele');
  exit();
} else
  echo "Votre email n'est pas correct"

  
?>