<main>
    <a href="?action=home" class="backButton"><img src="img/back_button.png" alt="Retour_Logo"><span>Retour</span></a>
    <h2>Classement des projets</h2>
    <?php
    if($projectsRankingList != null){
        if (sizeOf($projectsRankingList) != 0) {
            echo '<table><thead><tr><th>Position</th><th>Nom du projet</th><th>Montant investi</th></tr></thead><tbody>';
            $counter = 1;
            foreach ($projectsRankingList as $project) {
                echo '<tr projectid="' . $project['idProject'] . '"><td>' . $counter . '</td><td>' . $project['name'] . '</td><td>' . number_format($project['SUM(amount)'], 0, ',', ' ') . '€</td></tr>';
                $counter = $counter + 1;
            }
            echo '</table>';
        } else {
            echo '<p>Aucun participant n\'a encore investi dans un projet</p>';
        }
    }else{
        echo '<p>Aucun participant n\'a encore investi dans un projet</p>';
    }
    ?>
    <a href=".?action=exportAllInvestments">Exporter la liste de tous les investissements</a>
</main>
<script type="text/javascript">
    let projectList = document.querySelectorAll("tr");

    for (let i = 1; i < projectList.length; i = i + 1) {
        projectList[i].addEventListener("click", showProjectRankingDetails);
        projectList[i].style.cursor = 'pointer';
    }

    function showProjectRankingDetails(event) {
        window.location.href = ".?action=projectsRanking&projectId=" + event.currentTarget.getAttribute("projectid");
    }
</script>