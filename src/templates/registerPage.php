<!-- ajouter ?action=sign-in  -->

<main>
  <img src="img/logo.png" alt='Logo' width="50px">
  <h1>Salon de Crowdfunding</h1>
  <h2>Inscription</h2>
  <form method="POST" action=".?action=register">
    <input type="text" name="surname" placeholder="Nom" id="surname">
    <input type="text" name="name" placeholder="Prénom" id="name">
    <input type="text" name="mail" placeholder="Adresse mail" id="mail">
    <input type="password" name="password" id="password" placeholder="Mot de passe">
    <input type="text" name="key" placeholder="Clé (série de 15 caractères)" id="key">
    <?php
    if (isset($data)) {
      echo '<p>Identifiant ou mot de passe incorrect</p>';
    }
    ?>
    <button type="submit" name="register" value="register">S'inscrire</button>
  </form>
</main>