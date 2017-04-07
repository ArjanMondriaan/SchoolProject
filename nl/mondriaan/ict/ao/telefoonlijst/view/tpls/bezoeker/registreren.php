<?php 
include 'includes/header.php';
include 'includes/menu.php';?>
        <section id='content'>
            <fieldset>
                <legend>
                    Registreren
                </legend>
                <form  method="post" autocomplete="off">
                    <table>    
                        <tr>
                            <td class="required" >Voornaam:</td>
                            <td>
                                <input type="text" autocomplete="off" name="voornaam" required="required" />
                            </td>
                        </tr>
                        <tr >
                           <td>  Tussenvoegsel:</td>
                           <td>
                                <input type="text" autocomplete="off" name="tussenvoegsel"/>
                           </td>
                        </tr>
                        <tr>
                            <td class="required" >Achternaam:</td>
                            <td>
                                <input type="text" autocomplete="off" name="achternaam" required="required" />
                            </td>
                        </tr>
                        <tr>
                            <td class="required" >Geboortedatum:</td>
                            <td>
                                <input type="date" autocomplete="off" name="geboortedatum" required="required" />
                            </td>
                        </tr>
                        <tr>
                            <td class="required" >Gebruikersnaam:</td>
                            <td>
                                <input type="text" autocomplete="off" name="gebruikersnaam" required="required" />
                            </td>
                        </tr>
                        <tr>
                            <td class="required" >Wachtwoord:</td>
                            <td>
                                <input type="password" autocomplete="off" name="password"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="required" >Herhaling wachtwoord:</td>
                            <td>
                                <input type="password" autocomplete="off" name="password2" />
                            </td>
                        </tr>
                        <tr>
                            <td class="required">Geslacht:</td>
                            <td>
                                <input type="radio" name="geslacht" value="male" checked> Man<br>
                                <input type="radio" name="geslacht" value="female" checked> Vrouw<br>
                            </td>
                        </tr>
                        <tr>
                            <td class="required" >Straat:</td>
                            <td>
                                <input type="text" autocomplete="off" name="straat" required="required" />
                            </td>
                        </tr>
                        <tr>
                            <td class="required" >Postcode:</td>
                            <td>
                                <input type="text" autocomplete="off" name="postcode" required="required" />
                            </td>
                        </tr>
                        <tr>
                            <td class="required" >Stad:</td>
                            <td>
                                <input type="text" autocomplete="off" name="stad" required="required" />
                            </td>
                        </tr>
                        <tr>
                            <td class="required" >Email: </td>
                            <td>
                                <input type="email" autocomplete="off" name="email" required="required" />
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" value="registreren"><input type="reset" value="reset" />
                            </td>
                        </tr>
                    </table>
                </form>
           </fieldset>
        </section>
<?php include 'includes/footer.php';