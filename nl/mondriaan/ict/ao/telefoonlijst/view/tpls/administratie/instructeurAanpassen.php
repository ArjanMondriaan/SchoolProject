<?php 
include 'includes/header.php';
include 'includes/menu.php';?>
<section >
    <form  method="post"  >   
        <table>
            <caption>Aanpassen lid</caption>
            <tr>
                <td>Voornaam:</td>
                <td>
                    <input type="text"  name="vn"  required="required" value="<?= $lid->getFirstname();?>">
                </td>
            </tr>
            <tr>
                <td>tussenvoegsel:</td>
                <td>
                    <input type="text"  name="tv"   value="<?= $lid->getPrepovision();?>">
                </td>
            </tr>
            <tr>
                <td>achternaam:</td>
                <td>
                    <input type="text"  name="an"  required="required" value="<?= $lid->getLastname();?>">
                </td>
            </tr>
            <tr>
                <td>straat:</td>
                <td>
                    <input type="text"  name="straat"  required="required" value="<?= $lid->getStreet();?>">
                </td>
            </tr>
            <tr >
                <td>postcode:</td>
                <td>
                     <input type="text"  name="postcode"  required="required" value="<?= $lid->getPostalcode();?>">
                </td>
            </tr>
            <tr> 
                <td>woonplaats:</td>
                <td>
                  <input type="text"  name="woonplaats"  required="required" value="<?= $lid->getPlace();?>">  
                </td>
            </tr>
            <tr> 
                <td>email:</td>
                <td>
                  <input type="email"  name="email"  required="required" value="<?= $lid->getEmailaddress();?>">  
                </td>
            </tr>
            <tr> 
                <td>salaris:</td>
                <td>
                  <input type="number"  name="salaris" maxlength="7"  required="required" value="<?= $lid->getSalary();?>">  
                </td>
            </tr>
            <tr> 
                <td>aanneem datum:</td>
                <td>
                  <input type="text"  name="hiringdate"   required="required" value="<?= $lid->getHiringdate();?>">  
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" value="voeg toe">
                    <input type="reset" value="reset"> 
                </td>
            </tr>

        </table>

    </form> 
    <br >
</section>
<?php include 'includes/footer.php';

