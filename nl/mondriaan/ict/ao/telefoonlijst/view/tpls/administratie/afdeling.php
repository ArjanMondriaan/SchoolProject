<?php
include 'includes/header.php';
include 'includes/menu.php';
?>
<section id='content'>
    <form method="post" enctype="multipart/form-data" id="gebruiker_form">
        <textarea cols="50" rows="10"><?=$textarea1->getOmschrijving();?></textarea>
        <textarea cols="50" rows="10"><?=$textarea2->getOmschrijving();?></textarea>
        <div>
            <input type="submit" value="voeg toe">
            <input type="reset" value="reset"> 
        </div>        
    </form>
    
</section>