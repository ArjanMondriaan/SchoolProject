<?php 
include 'includes/header.php';
include 'includes/menu.php';?>
        <section >
            <form  method="post" >
                
                <table>
                    <caption>Aanpassen van een bestaande cursus</caption>
                    <tr>
                        <td>Locatie:</td>
                        <td>
                            <input type="text" placeholder='kies verplicht een locatie' name="location" required="required">
                        </td>
                    </tr>
                    <tr>
                        <td>Tijdstip:</td>
                        <td>
                            <input type="time" placeholder='kies verplicht een tijdstip' name="time" required="required" >
                        </td>
                    </tr>
                    <tr>
                        <td>Datum:</td>
                        <td>
                            <input type="date" placeholder='kies verplicht een datum' name="date" required="required" >
                        </td>
                    </tr>
                    <tr>
                        <td>Max aantal personen:</td>
                        <td>
                            <input type="number" placeholder='kies een mximaal aantal personen' name="maxpersons" >
                        </td>
                    </tr>
                    <tr>
                        <td>Instructeur:</td>
                        <td>
                            <select name="instructeur">
                                <?php foreach($instructeurs as $instructeur):?>
                                    <option value="<?=$instructeur->getId() ;?>"> <?=$instructeur->getNaam();?> </option>
                                <?php endforeach;?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Soorten les:</td>
                        <td>
                            <select name="training">
                                <?php foreach($trainingen as $training):?>
                                    <option value="<?=$training->getId() ;?>"> <?=$training->getName();?> </option>
                                <?php endforeach;?>
                            </select>
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
<?php include 'includes/footer.php';?>
