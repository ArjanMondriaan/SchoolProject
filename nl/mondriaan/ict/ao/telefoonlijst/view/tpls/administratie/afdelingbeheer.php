<?php include 'includes/header.php';
include 'includes/menu.php';
?>

    <section id='content'>
        <form  method="post" enctype="multipart/form-data" id="gebruiker_form"> 
            <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                <?php foreach ($afdelingen as $data):?>
                    <table>
                        <caption>Afdelings tekst bewerken: <?php echo $data->getAfkorting(); ?></caption>
                        <tr>
                            <td>Omschrijving:</td>
                            <td><textarea rows="10" cols="65" name="<?= "id".$data->getid(); ?>"><?= $data->getOmschrijving();?> </textarea></td>
                        </tr>
                    </table>
                    <br>
            <?php endforeach; ?>
                <div>-
                  <input type="submit" value="voeg toe">
                </div>        
            </form> 
        <br id ="breaker">
    </section>

<?php include 'includes/footer.php';

