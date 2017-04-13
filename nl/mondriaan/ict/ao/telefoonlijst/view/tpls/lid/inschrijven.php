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
                        <td>inschrijven</td>
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
                        <td>
                            <a href='?control=lid&action=addDeelname&id=<?= $les->getId()?>' >+</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <br>
            <table> 
                 <caption>
                        Ingeschreven voor
                 </caption>
                <thead>
                    <tr>
                        <td>id</td>
                        <td>datum</td>
                        <td>tijd</td>
                        <td>description</td>
                        <td>kosten</td>
                        <td>uitschrijven</td>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($ingeschrevenLessen as $les){ ?>
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
                        <td>
                            <a href='?control=lid&action=deleteDeelname&id=<?= $les->getId()?>' >-</a>
                        </td>
                <?php } ?>
                </tbody>
            </table>
            
            <?php $totaal=0;
                foreach($ingeschrevenLessen as $activiteit)
                {
                  $totaal+=$activiteit->getExtra_costs();
                }
                echo "<hr>&nbsp;Totaal: &euro;".number_format($totaal,2,',','.');

          ?>
            
            <br id ="breaker" />
        </section>
<?php include 'includes/footer.php';
