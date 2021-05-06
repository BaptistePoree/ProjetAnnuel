<main>
    <a href="?action=home" class="backButton"><img src="img/back_button.png" alt="Retour_Logo"><span>Retour</span></a>  
    <h2>Liste des projets</h2>
    <?php
    if (sizeof($listOfProject) === 0) {
        echo '<p>Aucun projet existant.</p>';
    } else {
        echo '<ul>';
        foreach ($listOfProject as $project) {
            echo '<li><a href="?action=showProject&projectId=' . $project['id'] . '">' . $project['name'] . '</a></li>
        ';
        }
        echo '</ul>';
    }
    ?>
</main>