<?php 
include 'includes/header.php';
include 'includes/menu.php';?>
        <section >
            <form  method="post" >
                
                <table>
                    <caption>Aanpassen van een bestaande training</caption>
                    <tr>
                        <td>Naam:</td>
                        <td>
                            <input type="text" placeholder='kies verplicht een naam' name="naam" required="required" value="<?= $TrainingInfo->getName(); ?>" >
                        </td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td>
                            <textarea name='description' cols='100' rows='10'   ><?= $TrainingInfo->getDescription();?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Tijdsduur:</td>
                        <td>
                            <input type="time" placeholder='kies verplicht een tijdsduur' name="duration" required="required" value="<?= $TrainingInfo->getDuration(); ?>" >
                        </td>
                    </tr>
                    <tr>
                        <td>Extra kosten:</td>
                        <td>
                            <input type="number" placeholder='kies verplicht een extra coste' name="extra_costs" value="<?= $TrainingInfo->getExtra_costs(); ?>" >
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" value="verander">
                            <input type="reset" value="reset"> 
                        </td>
                    </tr>
                   
                </table>
                
            </form>  
        <br >
        </section>
<?php include 'includes/footer.php';