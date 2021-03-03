<?php

$to = "waloude20@gmail.com";   // Bouryt
// 2- On vérifie si la variable existe et sinon elle vaut NULL
$email = isset($_POST['email']) ? $_POST['email'] : NULL;

//$email_address = $_POST['email'];
$email_subject = "[Waloude] Demande mot de passe";
$email_body .= "Demande mot de passe. <br/>
	Email: " . $email . " <br/>
  Message: " . $message . " <br/>";

$headers = "From:<$email>\n";
$headers .= "Content-Type:text/html; charset=UTF-8";
if ($email != "") {
  mail($to, $email_subject, $email_body, $headers);
  //return true;
  header('Location: /pages/demandeMotDePasse');
  exit();
} else
  echo "Votre email n'est pas correct"

  
?>