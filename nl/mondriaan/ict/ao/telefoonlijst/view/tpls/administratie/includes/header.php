<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Telefoonlijst</title>
        <link rel="STYLESHEET" href="css/telefoonlijst.css" type="text/css">
        <link rel="STYLESHEET" href="css/secretaresse.css" type="text/css">
    </head>
    <body>
        <header>
            <figure>
                <img src="img/mondriaan.jpg" alt="ons schoolgebouw aan de tinwerf 10 denhaag">
            </figure>
            <div>
                <p>Dit is de beheers applicatie voor de school voor ICT.</p>
                <p>Momenteel is ingelogd: <em><?=$gebruiker->getNaam();?></em></p> 
            
                <?=isset($boodschap)?"<p id = 'boodschap'><em>$boodschap</em></p>":""?>
            </div>
            
        </header>
        <section>
    
