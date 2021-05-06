<?php

$errorsList = array(
    "roleChoisi" => "",
    "nombreDeCles" => ""
);

if ($clesBuilder != null) {
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

if ($clesBuilder != null) {
    foreach ($dataList as $name => $value) {
        if ($clesBuilder->getData($name) != null) {
            $dataList[$name] = 'value="' . $clesBuilder->getData($name) . '"';
        }
    }
}

?>

<div class="AjouterCles">
    <form method="POST" action=".?action=createNewCles">
        <div> 
            <select name="roleChoisi" class="roleChoisi"> 
                <option value="0">roles</option> 
                <option value="1">admine</option> 
                <option value="2">Crowd-fondeurs</option>  
            </select> 
            <!-- <input type="number" name="nombreDeCles"  placeholder="nombreDeCles" class="nombreDeCles" min="1" max="99"> -->
            <input type="submit" name="create" value="Ajouter les cles"> </div>
    </form>
</div>