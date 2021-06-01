<div>
<?php if ($listeClesRole != null):?>
    <?php if (sizeof($listeClesRole) != 0):?>
        <?php $bdListeCles = new ClesStorage($this); ?>
        <form method="POST" action=".?action=suppresionCles">
            <input type="submit" name="suprimer" value="suprimerCles">
            <table class="listeClesRole">
                <thead>
                    <tr><th>type de roles</th> <th>Cles Generais</th> <th>Supprimer Cles</th> </tr>
                </thead>
                <tbody> 
                    <?php foreach ($listeClesRole as $item):?>
                    <tr> 
                        <?php ($item['isValider'] != null)? $color = "green" : $color = "red" ; ?>

                        <td class="roles"> <?= $item['nomRole'] ?> </td>
                        <!-- <td class="cles" > <?php //echo $item['cles'] ?> </td>  -->
                        <td class="cles" style="color:<?= $color ?>;"> <?= $item['cles'] ?> </td>
                        <!-- <td class="checkbox"> <?php //($item['isValider'] != null)? echo'<img src="img/checkbox/checkbox-30-16.png">' : echo'<img src="img/checkbox/checkbox-6-16.png">' ; ?> </td>  -->
                                
                        <td class="supresion"> 
                            <?php if ($item['isValider'] === null): ?>
                                <input type='checkbox' name='delete[]' value="<?= $item['id'] ?>">
                            <?php endif; ?>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    <?php else: ?>
        <p> <?php echo "Vous n'avez pas encre de cles generais" ?> </p>            
    <?php endif; ?>
<?php else: ?>
    <p> <?php echo "Vous n'avez pas encre de cles generais" ?> </p>            
<?php endif; ?>
</div>
