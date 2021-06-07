<main>
    <a href="?action=projectList" class="backButton"><img src="img/back_button.png" alt="Retour_Logo"><span>Retour</span></a>
    <?php
    if ($msg != null) {
        echo "<h3 style='color: green'>" . $msg . "</h3>";
    }
    ?>
    <h2>Projet - <?php echo $project->getName() ?></h2>
    <table>
        <tr>
            <td>Nom du projet</td>
            <td><?php echo $project->getName() ?></td>
        </tr>
        <tr>
            <td>Description du projet</td>
            <td><?php echo $project->getDescription() ?></td>
        </tr>
        <tr>
            <td>Membres du projet</td>
            <td>
                <ul>
                    <?php
                    if ($project->getProjectMember() != "") {
                        $projectMemeberArray = json_decode($project->getProjectMember());
                        foreach ($projectMemeberArray as $member) {
                            echo '<li>' . $member[0] . ' ' . $member[1] . '</li>';
                        }
                    }
                    ?>
                </ul>
            </td>

        </tr>
    </table>
    <?php
    if ($_SESSION['role'] == 2) {
        $investmentStorage = new InvestmentStorage($this);
        $investment = $investmentStorage->getInvestmentByProjectIdAndUserId($project->getId(), $_SESSION['userId']);
        if ($investment == null) {
            echo '<a href=".?action=investing&projectId=' . $project->getId() . '" class="button">Investir dans ce projet</a>';
        } else {
            echo '<a href=".?action=investing&projectId=' . $project->getId() . '" class="button">Modifier mon investissement (' . number_format($investment->getAmount(), 0, ',', ' ') . '€)</a>';
        }
    }
    ?>
    <div>
        <?php
        if ($_SESSION['role'] == 1) {
            echo "<a class='button-form' href='.?action=createNewProject&projetId=" . $project->getId() . "'>Modifier</a>
            <input type='button' onclick='togglePopup()' id='delete' name='delete' value='Supprimer'>";
        }
        ?>

    </div>
</main>