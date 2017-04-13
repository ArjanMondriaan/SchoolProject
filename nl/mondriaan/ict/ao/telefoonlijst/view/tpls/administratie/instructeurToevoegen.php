<?php 
include 'includes/header.php';
include 'includes/menu.php';?>
<section >
    <form  method="post"  >   
        <table>
            <caption>toevoegen instructeur</caption>
            <tr>
                <td>gebruikersnaam:</td>
                <td>
                    <input type="text"  name="gn"  required="required" value="<?=!empty($form_data['gn'])?$form_data['gn']:'';?>">
                </td>
            </tr>
            <tr>
                <td>wachtwoord:</td>
                <td>
                    <input type="password"  name="ww1" value="<?=!empty($form_data['ww1'])?$form_data['ww1']:'';?>">
                </td>
            </tr>
            <tr>
                <td>wachtwoord:</td>
                <td>
                    <input type="password"  name="ww2" value="<?=!empty($form_data['ww2'])?$form_data['ww2']:'';?>">
                </td>
            </tr>
            <tr>
                <td>Voornaam:</td>
                <td>
                    <input type="text"  name="vn"  required="required" value="<?=!empty($form_data['vn'])?$form_data['vn']:'';?>">
                </td>
            </tr>
            <tr>
                <td>tussenvoegsel:</td>
                <td>
                    <input type="text"  name="tv"   value="<?=!empty($form_data['tv'])?$form_data['tv']:'';?>">
                </td>
            </tr>
            <tr>
                <td>achternaam:</td>
                <td>
                    <input type="text"  name="an"  required="required" value="<?=!empty($form_data['an'])?$form_data['an']:'';?>">
                </td>
            </tr>
            <tr>
                <td>straat:</td>
                <td>
                    <input type="text"  name="straat"  required="required" value="<?=!empty($form_data['straat'])?$form_data['straat']:'';?>">
                </td>
            </tr>
            <tr >
                <td>postcode:</td>
                <td>
                     <input type="text"  name="postcode"  required="required" value="<?=!empty($form_data['postcode'])?$form_data['postcode']:'';?>">
                </td>
            </tr>
            <tr> 
                <td>woonplaats:</td>
                <td>
                  <input type="text"  name="woonplaats"  required="required" value="<?=!empty($form_data['woonplaats'])?$form_data['woonplaats']:'';?>">  
                </td>
            </tr>
            <tr> 
                <td>email:</td>
                <td>
                  <input type="email"  name="email"  required="required" value="<?=!empty($form_data['email'])?$form_data['email']:'';?>">  
                </td>
            </tr>
            <tr> 
                <td>salaris:</td>
                <td>
                  <input type="number"  name="salaris" maxlength="7"  required="required" value="<?=!empty($form_data['salaris'])?$form_data['salaris']:'';?>">  
                </td>
            </tr>
            <tr> 
                <td>geboortedatum:</td>
                <td>
                  <input type="text"  name="geboortedatum"   required="required" value="<?=!empty($form_data['gebooretedatum'])?$form_data['geboortedatum']:'';?>">  
                </td>
            </tr>
            <tr> 
                <td>aanneem datum:</td>
                <td>
                  <input type="text"  name="hiringdate"   required="required" value="<?=!empty($form_data['hiringdate'])?$form_data['hiringdate']:'';?>">  
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

