<?php include 'includes/header.php';
include 'includes/menu.php';?>
        <section id='content'>
            <figure>
                <img src="img/foto1.jpg"/>
                <img src="img/foto2.jpg"/>
                <img src="img/foto3.jpg"/>
            </figure>
            <section >
        <table>
            <caption>Dit zijn alle trainingen</caption>
            <thead>
                <tr>
                    <td>Locatie</td>
                    <td>Datum</td>
                    <td>Tijd</td>
                    <td>Max personen</td>
                    <td colspan="2">acties</td>
                </tr>
            </thead>
            <tbody >
                <?php foreach($lessen as $les):?>
                <tr>
                    <td><?= $les->getLocation();?></td>
                    <td><?= $les->getDate();?></td>
                    <td><?= $les->getTime();?></td>
                    <td><?= $les->getMaxpersons();?></td>
                    
                    <td title="bewerk de gegevens van deze activiteit"><a href='?control=Instructeur&action=editLes&id=<?= $les->getId();?>'><img src="img/bewerk.png"></a></td>
                    <td title="verwijder deze activiteit is definitief"><a href='?control=Instructeur&action=deleteLes&id=<?= $les->getId();?>'><img src="img/verwijder.png"></a></td>
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
                    <td colspan='8'>Voeg een activiteit toe</td>
                </tr>
            </tbody>
        </table>
        <br />
    </section>
        </section>
<?php include 'includes/footer.php';


