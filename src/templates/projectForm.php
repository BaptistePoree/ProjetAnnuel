<?php
//Page utilisé pour l'ajout et la modification d'un projet


$errorsList = array(
    'name' => '',
    'description' => '',
    'projectMember' => '',
);

if ($projectBuilder != null) {
    foreach ($errorsList as $error => $desc) {
        if ($projectBuilder->getErrors($error) != null) {
            $errorsList[$error] = '<span>' . $projectBuilder->getErrors($error) . '</span>';
        }
    }
}

$dataList = array(
    'name' => '',
    'description' => '',
    'projectMember' => '',
);

if ($projectBuilder != null) {
    foreach ($dataList as $name => $value) {
        if ($projectBuilder->getData($name) != null) {
            $dataList[$name] = 'value="' . $projectBuilder->getData($name) . '"';
        }
    }
}

?>

<form method="POST" action=".?action=createNewProject<?php if ($edit) echo "&projetId=".$_GET['projetId']; ?>">

    <div>
        <label for="name">Nom du projet</label>
        <input type="text" autocomplete="off" name="name" id="name" <?php echo $dataList['name'] ?>>
        <?php echo $errorsList['name'] ?>
    </div>

    <div>
        <label for="description">Description du projet</label>
        <input type="text" autocomplete="off" name="description" id="description" <?php echo $dataList['description'] ?>>
        <?php echo $errorsList['description'] ?>
    </div>

    <?php
    if ($edit) {
        echo '<input type="submit" name="modify" value="Modifier projet">';
    } else {
        echo '<input type="submit" name="create" value="Ajouter projet">';
    }
    ?>