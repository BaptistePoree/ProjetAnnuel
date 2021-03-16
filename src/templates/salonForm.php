<?php
//Page utilisé pour l'ajout et la modification d'un salon


$errorsList = array(
    'name' => '',
    'description' => '',
);

if ($salonBuilder != null) {
    foreach ($errorsList as $error => $desc) {
        if ($salonBuilder->getErrors($error) != null) {
            $errorsList[$error] = '<span>' . $salonBuilder->getErrors($error) . '</span>';
        }
    }
}

$dataList = array(
    'name' => '',
    'description' => '',
);

if ($salonBuilder != null) {
    foreach ($dataList as $name => $value) {
        if ($salonBuilder->getData($name) != null) {
            $dataList[$name] = 'value="' . $salonBuilder->getData($name) . '"';
        }
    }
}

?>

<div>
    <label for="name">Nom du salon</label>
    <input type="text" autocomplete="off" name="name" id="name" <?php echo $dataList['name'] ?>>
    <?php echo $errorsList['name'] ?>
</div>

<div>
    <label for="description">Description du salon</label>
    <input type="text" autocomplete="off" name="description" id="description" <?php echo $dataList['description'] ?>>
    <?php echo $errorsList['description'] ?>
</div>