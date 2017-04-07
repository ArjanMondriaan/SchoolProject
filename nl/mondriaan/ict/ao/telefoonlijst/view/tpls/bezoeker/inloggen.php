<?php include 'includes/header.php';
include 'includes/menu.php';?>
<form  method="post" autocomplete="off" id="inlogform">
                    <table>    
                        <tr>
                            <td>
                                <input type="text" autocomplete="off" placeholder="vul uw gebuikersnaam in" name="gn" required="required" />
                            </td>
                        </tr>
                        <tr >
                           <td>
                                <input type="password" autocomplete="off" name="ww" placeholder="vul uw wachtwoord in" required="required" />
                           </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" value="inloggen"><input type="reset" value="reset" />
                            </td>
                        </tr>
                    </table>
                </form>
<?php include 'includes/footer.php';
