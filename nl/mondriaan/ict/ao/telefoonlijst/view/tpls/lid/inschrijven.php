<?php include 'includes/header.php';
include 'includes/menu.php';?>
        <section id='content'>
            <table> 
                 <caption>
                        Dit zijn alle beschikbare lessen
                 </caption>
                <thead>
                    <tr>
                        <td>id</td>
                        <td>tijd</td>
                        <td>datum</td>
                        <td>locatie</td>
                        <td>max personen</td>                       
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; ?>
                <?php foreach($lessons as $lesson){ ?>
                    <tr>
                        <td>
                            <?= $lesson->getId();?></td>
                        </td>
                        <td>
                            <?= $lesson->getTime();?>
                        </td>
                        
                        <td>
                            <?= $lesson->getDate();?>
                        </td>
                        <td>
                            <?= $lesson->getLocation();?>
                        </td>
                        <td>
                            <?= $lesson->getMaxpersons();?>
                        </td>
                <?php } ?>
                </tbody>
            </table>
            <br id ="breaker" />
        </section>
<?php include 'includes/footer.php';
