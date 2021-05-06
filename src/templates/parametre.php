<main>
    <a href="?action=home" class="backButton"><img src="img/back_button.png" alt="Retour_Logo"><span>Retour</span></a>  
    <h2> Parametre Du Salon </h2>

        <ul>
    <?php
        if($_SESSION['role'] == 1){
            // echo '
            // <li><a href=".?action=parametreControle">Paneau de Controle</a></li>';
            echo '
            <li><a href=".?action=parametreCle">Génération de Cles</a></li>';
            // echo '
            // <li><a href=".?action=parametreRole">Gestion des Roles</a></li>';
            
        }
    ?>
        </ul>
</main>