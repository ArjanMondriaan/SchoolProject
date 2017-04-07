<?php include 'includes/header.php';
include 'includes/menu.php';?>
        <section id='content'>
            <form  method="post" autocomplete="off">
                    <table>
                        <tr>
                            <td class="required" >Straat:</td>
                            <td>
                                <input type="text" autocomplete="off" name="straat" required="required" value=""/>
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
                                <input type="submit" value="inloggen"><input type="reset" value="reset" />
                            </td>
                        </tr>
                    </table>
                </form>
        </section>
<?php include 'includes/footer.php';
