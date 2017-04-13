<?php 
include 'includes/header.php';
include 'includes/menu.php';?>
        <section >
            <form  method="post" >
                
                <table>
                    <caption>Aanpassen van een bestaande training</caption>
                    <tr>
                        <td>Locatie:</td>
                        <td>
                            <input type="text" placeholder='kies verplicht een locatie' name="location" required="required" value="<?= $LesInfo->getLocation(); ?>" >
                        </td>
                    </tr>
                    <tr>
                        <td>Tijdstip:</td>
                        <td>
                            <input type="time" placeholder='kies verplicht een tijdstip' name="time" required="required" value="<?= $LesInfo->getTime(); ?>" >
                        </td>
                    </tr>
                    <tr>
                        <td>Datum:</td>
                        <td>
                            <input type="date" placeholder='kies verplicht een datum' name="date" required="required" value="<?= $LesInfo->getDate(); ?>" >
                        </td>
                    </tr>
                    <tr>
                        <td>Max aantal personen:</td>
                        <td>
                            <input type="number" placeholder='kies een mximaal aantal personen' name="maxpersons" value="<?= $LesInfo->getMaxpersons(); ?>" >
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