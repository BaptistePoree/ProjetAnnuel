<main>
<a href="?action=home" class="backButton"><img src="img/back_button.png" alt="Retour_Logo"><span>Retour</span></a>  
    <h2>Liste de mes investissements</h2>
    <h3>Vous avez investi <?php echo number_format($totalAmountInvested[0]['SUM(amount)'], 0, ',', ' ') ?>€ sur <?php echo number_format($maximumInvestment, 0, ',', ' ') ?>€</h3>
    <?php 
        if($investmentList != null){
            if(sizeof($investmentList)!= 0){
                $projectStorage = new ProjectStorage($this);
                echo '<table><thead><tr><th>Nom du projet</th><th>Montant investi</th></tr></thead><tbody>';
                foreach($investmentList as $investment){
                    $project = $projectStorage->getProject($investment['idProject']);
                    echo '<tr><td>' . $project->getName() . '</td><td>' . number_format($investment['amount'], 0, ',', ' ') . '€</td></tr>';
                }
                echo '</tbody></table>';
            }else{
                echo '<p>Vous n\'avez pas encore investi dans un projet</p>';
            }
        }else{
            echo '<p>Vous n\'avez pas encore investi dans un projet</p>';
        }
    ?>
    <a href="?action=validateInvestmentList">Valider la liste de mes investissements (Attention vous ne pourrez plus modifier vos investissements ou investir)</a>
</main>