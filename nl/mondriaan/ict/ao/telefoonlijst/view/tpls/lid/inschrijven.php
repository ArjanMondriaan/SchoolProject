<?php include 'includes/header.php';
include 'includes/menu.php';?>
        <section id='content'>
            <table> 
                 <caption>
                        Dit zijn alle beschikbare activiteiten
                 </caption>
                <thead>
                    <tr>
                        <td>id</td>
                        <td>datum</td>
                        <td>tijd</td>
                        <td>description</td>
                        <td>kosten</td>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($beschikbareLessen as $les){ ?>
                    <tr>
                        <td>
                            <?= $les->getId();?></td>
                        </td>
                        <td>
                            <?= $les->getDate();?>
                        </td>
                        <td>
                            <?= $les->getTime();?>
                        </td>
                        <td>
                            <?= $les->getDescription();?>
                        </td>
                        <td>
                            €<?= $les->getExtra_costs();?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            
            <br id ="breaker" />
        </section>
<?php include 'includes/footer.php';
