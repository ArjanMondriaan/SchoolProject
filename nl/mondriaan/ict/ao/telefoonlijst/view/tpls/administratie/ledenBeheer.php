<?php 
include 'includes/header.php';
include 'includes/menu.php';?>
        <section id='content'>
            <table id="contacten">
                <thead>
                    <caption>
                        dit zijn alle leden van trainingfactory
                    </caption>
                    <tr>
                   
                        <td>naam</td>
                        <td>email</td>
                        <td>postcode</td>
                        <td>straat</td>
                        <td>wijzigen</td>
                        <td>verwijderen</td>

                    </tr>
                </thead>
               
                <?php foreach($contacten as $contact):?>
                    <tr>
                        <td><?= $contact->getNaam();?></td>
                        <td>
                            <a href="mailto: <?= $contact->getEmailaddress();?>"><?= $contact->getEmailaddress();?></a>
                        </td>
                        <td><?= $contact->getPostalcode();?></td>
                        <td><?= $contact->getStreet();?></td>
                        <td><a href="?control=administratie&action=lidAanpassen&id=<?=$contact->getId()?>">Aanpassen</a></td>
                        <td><a href="?control=administratie&action=lidVerwijderen&id=<?=$contact->getId()?>">verwijderen</a></td>
                        <td></td>
                    </tr>
                <?php endforeach;?>
                <tr><td><a href="?control=administratie&action=instructeurToevoegen">toevoegen</a></td></tr>
            </table>
            <br id ="breaker">
        </section>
<?php include 'includes/footer.php';