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
    .closed {
        display: none;
    }

    .bg-modal {
        position: absolute;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        margin-top: -30px;
    }

    .popup-modal {
        max-width: 500px;
        max-height: 300px;
        background: white;
        border-radius: 10px;
        margin: auto auto;
        padding: 20px;
    }

    body {
        margin: 0;
    }
</style>

<script>
    function togglePopup() {
        const popup = document.querySelector(".bg-modal");
        popup.classList.toggle("closed");
    }
</script>

<body>
    <div class="bg-modal closed">
        <div class="popup-modal">
            <a href="" onclick="togglePopup()">Fermer</a>
            <p>Voulez-vous vraiment supprimer ce projet ?</p>
            <input type="button" onclick="togglePopup()" value="Annuler">
            <input type="button" value="Valider">
        </div>
    </div>