<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0" />
    <title><?php echo $this->title; ?></title>
    <?php
    if ($this->styleSheetList != null) {
        foreach ($this->styleSheetList as $styleSheet) {
            echo '<link rel="stylesheet" media="screen" href="css/' . $styleSheet . '.css"/>';
        }
    }
    ?>

</head>

<body>