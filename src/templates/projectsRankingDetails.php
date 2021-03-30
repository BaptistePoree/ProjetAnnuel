<main>
    <a href="?action=projectsRanking" class="backButton"><img src="img/back_button.png" alt="Retour_Logo"><span>Retour</span></a>
    <h2>Détails des investissements du projet <?php echo $project->getName() ?></h2>
    <?php
    if (sizeOf($allInvestmentOfProject) != 0) {
        echo '<table><thead><tr><th>Nom</th><th>Prénom</th><th>Montant investi</th><th>Commentaire</th></tr></thead><tbody>';
        foreach ($allInvestmentOfProject as $investment) {
            echo '<tr><td>' . $investment['lastName'] . '</td><td>' . $investment['firstName']  . '</td><td>' . number_format($investment['amount'], 0, ',', ' ') . '€</td><td>' . $investment['comment'] . '</td></tr>';
        }
        echo '</table>';
    } else {
        echo '<p>Aucun participant n\'a encore investi dans un projet</p>';
    }
    ?>
</main>