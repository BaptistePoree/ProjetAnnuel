<?php

$errorsList = array(
    "firstName" => "",
    "lastName" => "",
    "mail" => "",
    "password" => "",
    "cles" => ""
);

if ($userBuilder != null) {
    foreach ($errorsList as $error => $desc) {
        if ($userBuilder->getErrors($error) != null) {
            $errorsList[$error] = '<span>' . $userBuilder->getErrors($error) . '</span>';
        }
    }
}

$dataList = array(
    "firstName" => "",
    "lastName" => "",
    "mail" => "",
    "password" => "",
    "cles" => ""
);

if ($userBuilder != null) {
    foreach ($dataList as $name => $value) {
        if ($userBuilder->getData($name) != null) {
            $dataList[$name] = 'value="' . $userBuilder->getData($name) . '"';
        }
    }
}

?>

<main>
  <img src="img/logo.png" alt='Logo' width="50px">
  <h1>Salon de Crowdfunding</h1>
  <h2>Inscription</h2>
  <form method="POST" action=".?action=register">
    <input type="text" name="firstName" placeholder="Nom" id="surname">
    <input type="text" name="lastName" placeholder="Prénom" id="name">
    <input type="text" name="mail" placeholder="Adresse mail" id="mail">
    <input type="password" name="password" id="password" placeholder="Mot de passe">
    <input type="text" name="cles" placeholder="Clé (série de 15 caractères)" id="key">
    <?php if (isset($data)): ?>
      <p>Identifiant ou mot de passe incorrect</p>
    <?php endif; ?>
    <button type="submit" name="register" value="register">S'inscrire</button>
  </form>
</main>