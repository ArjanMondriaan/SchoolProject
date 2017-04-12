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
                        <td>tijd</td>
                        <td>datum</td>
                        <td>location</td>
                        <td>max personen</td>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($activiteiten as $activiteit){ ?>
                    <tr>
                        <td>
                            <?= $activiteit->getId();?></td>
                        </td>
                        <td>
                            <?= $activiteit->getTime();?>
                        </td>
                        <td>
                            <?= $activiteit->getDate();?>
                        </td>
                        <td>
                            <?= $activiteit->getLocation();?>
                        </td>
                        <td>
                            <?= $activiteit->getMaxpersons();?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            
            <br id ="breaker" />
        </section>
<?php include 'includes/footer.php';
