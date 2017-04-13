<?php 
include 'includes/header.php';
include 'includes/menu.php';?>
        <section id='content'>
            <table id="contacten">
          
                    <caption>
                        dit zijn alle instructeurs van trainingfactory
                    </caption>
                    <tr>
                   
                        <td>naam</td>
                        <td>email</td>
                        <td>postcode</td>
                        <td>straat</td>
                        <td>hiring date</td>
                        <td>salary</td>
                        <td>wijzigen</td>
                        <td>verwijderen</td>

                    </tr>
                <?php foreach($contacten as $contact):?>
                    <tr>
                        <td><?= $contact->getNaam();?></td>
                        <td>
                            <a href="mailto: <?= $contact->getEmailaddress();?>"><?= $contact->getEmailaddress();?></a>
                        </td>
                        <td><?= $contact->getPostalcode();?></td>
                        <td><?= $contact->getStreet();?></td>
                        <td><?= $contact->getHiringdate();?></td>
                        <td><?= $contact->getSalary();?></td>
                        <td><a href="?control=administratie&action=instructeurAanpassen&id=<?=$contact->getId()?>">Aanpassen</a></td>
                        <td><a href="?control=administratie&action=instructeurVerwijderen&id=<?=$contact->getId()?>">verwijderen</a></td>
                       
                    </tr>
                <?php endforeach;?>
                       <tr>
                    <td>
                        <a href='?control=Instructeur&action=addLes'>
                            <figure>
                                <img style="width:10%;" src="img/toevoegen.png" alt='voeg een activiteit toe' title='voeg een activiteit toe' />
                            </figure>
                        </a>
                    </td>
                    <td colspan='8'>Voeg een instructeur toe</td>
                </tr>
           
            </table>
            <br id ="breaker">
        </section>
<?php include 'includes/footer.php';