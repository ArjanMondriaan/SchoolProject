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
                    <td>Deelnemers</td>
                </tr>
            </thead>
            <tbody >
                <?php foreach($trainingen as $training):?>
                <tr>
                    <td><?= $training->getName();?></td>
                    <td><?= $training->getDescription();?></td>
                    <td><?= $training->getDuration();?></td>
                    <td><?= $training->getExtra_costs();?></td>
                    
                    <td title="Voor overzicht deelnemers"><a href='?control=Instructeur&action=deelnemers&id=<?= $training->getId();?>'><input type="button" value="Overzicht"></td>
                </tr>
                <?php endforeach;?>
                
            </tbody>
        </table>
        <br />
    </section>
<?php include 'includes/footer.php';
