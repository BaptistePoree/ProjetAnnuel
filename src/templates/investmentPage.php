<?php
$dataList = array(
    'h2' => '<h2>Investir dans le projet ' . $project->getName() . '</h2>',
    'amount' => '',
    'comment' => '',
    'button' => '<button name="investing" value="add">Investir dans le projet</button>'
);

$errorsList = array(
    'amount' => '',
    'comment' => ''
);

if ($investmentBuilder != null) {
    if ($investmentBuilder->getData('id') != null) {
        $dataList['h2'] = '<h2>Modifier mon investissement dans le projet ' . $project->getName() . '</h2>';
        $dataList['button'] = '<button name="investing" value="edit">Appliquer les modifications</button>';
    }
}

if ($investmentBuilder != null) {
    if ($investmentBuilder->getData('amount') != null) {
        $dataList['amount'] = 'value="' . $investmentBuilder->getData('amount') . '"';
    }
    if ($investmentBuilder->getErrors('amount') != null) {
        $errorsList['amount'] = '<span>' . $investmentBuilder->getErrors('amount') . '</span>';
    }
    if ($investmentBuilder->getData('comment') != null) {
        $dataList['comment'] = $investmentBuilder->getData('comment');
    }
    if ($investmentBuilder->getErrors('comment') != null) {
        $errorsList['comment'] = '<span>' . $investmentBuilder->getErrors('comment') . '</span>';
    }
}


?>
<main>
    <a href="?action=home" class="backButton"><img src="img/back_button.png" alt="Retour_Logo"><span>Retour</span></a>
    <?php echo $dataList['h2'] ?>

    <form method="POST" action=".?action=investing&projectId=<?php echo $project->getId() ?>">
        <div>
            <label for="amount">Montant à investir (en €)</label>
            <input type="number" name="amount" id="amount" pattern="[0-9]*" inputmode="numeric" <?php echo $dataList['amount'] ?>>
            <?php echo $errorsList['amount'] ?>
        </div>
        <div>
            <label for="comment">Commentaire</label>
            <textarea id="comment" name="comment"><?php echo $dataList['comment'] ?></textarea>
            <?php echo $errorsList['comment'] ?>
        </div>

        <?php echo $dataList['button'] ?>
    </form>
</main>
