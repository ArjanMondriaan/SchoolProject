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
                    <td>Naam</td>
                    <td>Uitleg</td>
                    <td>Tijdsduur</td>
                    <td>Extra Costen</td>
                    <td colspan="2">acties</td>
                </tr>
            </thead>
            <tbody >
                <?php foreach($trainingen as $training):?>
                <tr>
                    <td><?= $training->getName();?></td>
                    <td><?= $training->getDescription();?></td>
                    <td><?= $training->getDuration();?></td>
                    <td><?= $training->getExtra_costs();?></td>
                    
                    <td title="bewerk de gegevens van deze activiteit"><a href='?control=Instructeur&action=editTraining&id=<?= $training->getId();?>'><img src="img/bewerk.png"></a></td>
                    <td title="verwijder deze activiteit is definitief"><a href='?control=Instructeur&action=deleteTraining&id=<?= $training->getId();?>'><img src="img/verwijder.png"></a></td>
                </tr>
                <?php endforeach;?>
                <tr>
                    <td>
                        <a href='?control=Instructeur&action=addTraining'>
                            <figure>
                                <img style="width:100%;" src="img/toevoegen.png" alt='voeg een activiteit toe' title='voeg een activiteit toe' />
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


