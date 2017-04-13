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

                    </tr>
                </thead>
                <tbody>
                <?php foreach($contacten as $contact):?>
                    <tr>
                        <td><?= $contact->getNaam();?></td>
                        <td>
                            <a href="mailto: <?= $contact->getEmailaddress();?>"><?= $contact->getEmailaddress();?></a>
                        </td>
                        <td><?= $contact->getPostalcode();?></td>
                        <td><?= $contact->getStreet();?></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <br id ="breaker">
        </section>
<?php include 'includes/footer.php';