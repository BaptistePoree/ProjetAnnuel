<?php

$errorsList = array(
    "roleChoisi" => "",
    "nombreDeCles" => ""
);

if ($ParametreBuilder != null) {
    foreach ($errorsList as $error => $desc) {
        if ($clesBuilder->getErrors($error) != null) {
            $errorsList[$error] = '<span>' . $clesBuilder->getErrors($error) . '</span>';
        }
    }
}

$dataList = array(
    "roleChoisi" => "",
    "nombreDeCles" => ""
);

if ($ParametreBuilder != null) {
    foreach ($dataList as $name => $value) {
        if ($clesBuilder->getData($name) != null) {
            $dataList[$name] = 'value="' . $clesBuilder->getData($name) . '"';
        }
    }
}

?>

<!-- <script type="text/javascript">
    // fonction qui permet d'afficher et de cacher le bouton supprision en haut de la page
    function actionSalon() 
    {
        var etat = document.getElementById('1').checked;
        if (etat)
        { 
            document.getElementById('inscription').className = 'on'; 
            this.actionInscription();
        } 
        else 
        { 
            document.getElementById('inscription').className = 'off'; 
            document.getElementById('plafon').className = 'off'; 
            document.getElementById('cleanInvestissement').className = 'off'; 
            document.getElementById('investissement').className = 'off'; 
        }
    }

    function actionInscription()
    {
        var etat = document.getElementById('2').checked;
        if (etat) 
        {
            document.getElementById('plafon').className = 'on'; 
            document.getElementById('cleanInvestissement').className = 'on'; 
            document.getElementById('investissement').className = 'off';
        }
        else
        { 
            this.actionInvestisement();
            document.getElementById('investissement').className = 'on';
        }
    }

    function actionInvestisement()
    {
        var etat = document.getElementById('5').checked;
        if (etat) 
        {
            document.getElementById('plafon').className = 'off'; 
            document.getElementById('cleanInvestissement').className = 'off'; 
        }
        else
        { 
            document.getElementById('plafon').className = 'on'; 
            document.getElementById('cleanInvestissement').className = 'on';
        }
    }

</script> -->

<main>
    <a href="?action=parametrePageGeneral" class="backButton"><img src="img/back_button.png" alt="Retour_Logo"><span>Retour</span></a>  
    <h2> Parametre De Controle du Salon </h2>



    <!-- <h1>Things to do today</h1> -->
    <ol class="switches">
        <li id="salon" class="on">
            <input type="checkbox" id="1"> <!-- onChange="actionSalon();" -->
            <label for="1">
            <span class="label"> Salon Fermer/ouvert </span>
            <span class="buton"></span>
            </label>
        </li>
        <li id="inscription" class="on">
            <input type="checkbox" id="2"> <!-- onChange="actionSalon();" -->
            <label for="2">
            <span class="label"> Inscription Fermer/ouvert </span>
            <span class="buton"></span>
            </label>
        </li>
        <li id="plafon" class="on">
            <label for="3">
            <span class="label"> Plafon du salon </span>
            <span class="chantChiffre"> <input type="text" id="3"></span>
            </label>
        </li>
        <li id="cleanInvestissement" class="on">
            <label>
            <a href=".?action=clean">
            <span class="label"> Clean les investissement </span>
            <span class="butonUnique"> 
                <input type="submit" name="Clean" value="Clean" id="butonUnique"> 
            </span>
            </a>
            </label>
        </li>
        <li id="investissement" class="on">
            <input type="checkbox" id="5"> <!-- onChange="actionSalon();" -->
            <label for="5">
            <span class="label"> Investissement Fermer/ouvert </span>
            <span class="buton"></span>
            </label>
        </li>
    </ol>

    


</main>