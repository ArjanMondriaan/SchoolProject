<?php 
include 'includes/header.php';
include 'includes/menu.php';?>
<section >
    <form  method="post"  >   
        <table>
            <caption>Aanpassen trainingsvorm</caption>
            <tr>
                <td>naam:</td>
                <td>
                    <input type="text"  name="naam"  required="required" value="<?= $trainingsvorm->getName();?>">
                </td>
            </tr>
            <tr>
                <td>description:</td>
                <td>
                    <input type="text"  name="description" required="required" value="<?= $trainingsvorm->getDescription();?>">
                </td>
            </tr>
            <tr>
                <td>extra kosten:</td>
                <td>
                    <input type="text"  name="extracosts"  required="required" value="<?= $trainingsvorm->getExtra_costs();?>">
                </td>
            </tr>
           <tr>
                <td>tijd:</td>
                <td>
                    <input type="text"  name="duration"  required="required" value="<?= $trainingsvorm->getDuration();?>">
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

