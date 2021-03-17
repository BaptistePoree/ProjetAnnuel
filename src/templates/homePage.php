<main>
    <img alt="crowdfunding logo" src="img/logo.png" width="100px">
    <h1>Salon de Crowd-funding</h1>
    <nav>
        <ul>
            <li><a href="index.php"><img src="img/home.png"><span>Accueil</span></a></li>
            <li><a href=".?action=projectList"><img src="img/list.png"><span>Liste des projets</span></a></li>
            <li><a href=".?action=investmentList"><img src="img/investments.png"><span>Mes investissements</span></a></li>
            <li><a href="index.php?action=rankings"><img src="img/rank.png"><span>Classement</span></a></li>
            <li><a href="index.php?action=management"><img src="img/logout.png"><span>Gestion</span></a></li>
            <li><a href=".?action=createNewProject"><img src="img/logout.png"><span>Ajouter projet</span></a></li>
            <li><a href="index.php?action=home"><img src="img/logout.png"><span>Déconnexion</span></a></li>
        </ul>
    </nav>
    <?php
        echo '<a href=".?action=createNewSalon"><span>Nouveau salon</span></a>';
        if (sizeof($listOfSalon) === 0) {
            echo '<p>Aucun salon existant.</p>';
        } else {
            foreach ($listOfSalon as $salon) {
                echo '<h2>Projet - <?php echo $salon->getName() ?></h2>';
                echo '<p><?php echo $salon->getDescription() ?></p>';
            }
        }
    ?>
</main>