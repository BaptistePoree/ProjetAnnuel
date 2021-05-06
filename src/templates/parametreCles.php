<div>
<?php if ($listeClesRole != null):?>
    <?php if (sizeof($listeClesRole) != 0):?>
        <?php $bdListeCles = new ClesStorage($this); ?>
        <table class="listeClesRole">
            <thead>
                <tr><th>type de roles</th> <th>Cles Generais</th> <th>Validations de la Cles</th> </tr>
            </thead>
            <tbody> 
                <?php foreach ($listeClesRole as $item):?>
                <tr> <td class="roles"> <?= $item['nomRole'] ?> </td> <td class="cles" > <?= $item['cles'] ?> </td> <td class="checkbox"> <?= ($item['isValider'] != null)? '<img src="img/checkbox/checkbox-30-16.png">' : '<img src="img/checkbox/checkbox-6-16.png">' ; ?> </td> </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p> <?php echo "Vous n'avez pas encre de cles generais" ?> </p>            
    <?php endif; ?>
<?php else: ?>
    <p> <?php echo "Vous n'avez pas encre de cles generais" ?> </p>            
<?php endif; ?>
</div>
