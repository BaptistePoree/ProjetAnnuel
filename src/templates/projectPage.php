<main>
    <a href="?action=projectList" class="backButton"><img src="img/back_button.png" alt="Retour_Logo"><span>Retour</span></a>  
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
                    $projectMemeberArray = json_decode($project->getProjectMember());
                    foreach($projectMemeberArray as $member){
                        echo '<li>' . $member[0] . ' ' . $member[1] . '</li>';
                    }
                ?>
            </ul>
            </td>

        </tr>

    </table>
</main>