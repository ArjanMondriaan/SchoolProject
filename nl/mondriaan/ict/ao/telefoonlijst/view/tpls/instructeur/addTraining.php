<?php 
include 'includes/header.php';
include 'includes/menu.php';?>
        <section >
            <form  method="post" >
                
                <table>
                    <caption>Aanpassen van een bestaande cursus</caption>
                    <tr>
                        <td>Naam:</td>
                        <td>
                            <input type="text" placeholder='kies verplicht een naam' name="naam" required="required">
                        </td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td>
                            <textarea name='description' cols='100' rows='10' required="Vul een beschrijving in"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Tijdsduur:</td>
                        <td>
                            <input type="time" placeholder='kies verplicht een tijdsduur' name="duration" required="required" value="00:00">
                        </td>
                    </tr>
                    <tr>
                        <td>Extra kosten:</td>
                        <td>
                            <input type="number" name="extra_costs" value="0">
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
