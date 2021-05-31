<main>
    <img src="img/logo.png" alt='Logo' width="50px">
    <h1>Salon de Crowdfunding</h1>
    <?php
    if ($newUser) {
        echo "<h3 style='color: green;'>Votre compte a bien été créé</h3>";
    }
    ?>
    <h2>Veuillez vous authentifier</h2>
    <form method="POST" action=".?action=login">
        <input type="text" name="mail" placeholder="Adresse mail" id="mail">
        <input type="password" name="password" id="password" placeholder="Mot de passe">
        <?php
        if (isset($data)) {
            echo '<p>Identifiant ou mot de passe incorrect</p>';
        }
        ?>
        <button type="submit" name="login" value="login">Connexion</button>
    </form>
    <p>Pas encore de compte ? <a href="index.php?action=sign-in">S'inscrire</a></p>

    <p style="text-align: left; font-style:italic;">Démo pour test:<br>Admin: email: admin@email.fr; Mot de passe: admin@email.fr;<br>Crowdfunder 1: email: exemple1@email.fr; Mot de passe: exemple1@email.fr;<br>Crowdfunder 2: email: exemple2@email.fr; Mot de passe: exemple2@email.fr;<br></p>
</main>