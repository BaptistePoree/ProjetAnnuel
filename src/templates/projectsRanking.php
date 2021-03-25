<main>
    <a href="?action=home" class="backButton"><img src="img/back_button.png" alt="Retour_Logo"><span>Retour</span></a>
    <h2>Classement des projets</h2>
    <?php
    if (sizeOf($projectsRankingList) != 0) {
        echo '<table><thead><tr><th>Position</th><th>Nom du projet</th><th>Montant investi</th></tr></thead><tbody>';
        $counter = 1;
        foreach ($projectsRankingList as $project) {
            echo '<tr><td>' . $counter . '</td><td>' . $project['name'] . '</td><td>' . $project['SUM(amount)'] . '€</td></tr>';
            $counter = $counter + 1;
        }
        echo '</table>';
    } else {
        echo '<p>Aucun participant n\'a encore investi dans un projet</p>';
    }
    ?>
</main>