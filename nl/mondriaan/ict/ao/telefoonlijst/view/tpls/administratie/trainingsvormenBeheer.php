<?php 
include 'includes/header.php';
include 'includes/menu.php';?>
        <section id='content'>
            <table id="contacten">
                <thead>
                    <caption>
                        dit zijn alle trainingsvormen
                    </caption>
                    <tr>
                   
                        <td>naam</td>
                        <td>description</td>
                        <td>extra kosten</td>
                        <td>tijd</td>
                        <td>wijzigen</td>
                        <td>verwijderen</td>

                    </tr>
                </thead>
               
                <?php foreach($trainingsvormen as $trainingsvorm):?>
                    <tr>
                        <td><?= $trainingsvorm->getName();?></td>
                        <td><?= $trainingsvorm->getDescription();?></td>
                        <td><?= $trainingsvorm->getExtra_costs();?></td>
                        <td><?= $trainingsvorm->getDuration();?></td>
                        <td><a href="?control=administratie&action=trainingsvormAanpassen&id=<?=$trainingsvorm->getId()?>">Aanpassen</a></td>
                        <td><a href="?control=administratie&action=trainingsvormVerwijderen&id=<?=$trainingsvorm->getId()?>">verwijderen</a></td>
                        <td></td>
                    </tr>
                <?php endforeach;?>
                    <tr><td><a href="?control=administratie&action=trainingsvormToevoegen">toevoegen</a></td></tr>
            </table>
            <br id ="breaker">
        </section>
<?php include 'includes/footer.php';