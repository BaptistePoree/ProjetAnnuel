<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8" />
    <link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
    <link rel="manifest" href="favicons/site.webmanifest">
    <link rel="mask-icon" href="favicons/safari-pinned-tab.svg" color="#ffffff">
    <link rel="shortcut icon" href="favicons/favicon.ico">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-config" content="favicons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0" />
    <title><?php echo $this->title; ?></title>

    <?php
    if ($this->styleSheetList != null) {
        foreach ($this->styleSheetList as $styleSheet) {
            echo '<link rel="stylesheet" media="screen" href="css/' . $styleSheet . '.css"/>';
            echo '
    ';
        }
    }
    ?>
</head>

<style>
    .bg-modal {
        display: none;
        position: absolute;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
    }

    body {
        margin: 0;
    }
</style>

<body>
    <div class="bg-modal"></div>