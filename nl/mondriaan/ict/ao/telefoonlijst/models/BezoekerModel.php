<?php
namespace nl\mondriaan\ict\ao\telefoonlijst\models;

class BezoekerModel extends \ao\php\framework\models\AbstractModel
{
    public function __construct($control, $action)
    {   
        parent::__construct($control, $action);
    }
    public function registreren()
    {
        $gn= filter_input(INPUT_POST, 'gebruikersnaam');
        $ww= filter_input(INPUT_POST, 'password');
        $ww2= filter_input(INPUT_POST, 'password2');
        $vn=filter_input(INPUT_POST, 'voornaam');
        $tv=filter_input(INPUT_POST, 'tussenvoegsel');
        $an=filter_input(INPUT_POST, 'achternaam');
        $email=filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
        $plaats=filter_input(INPUT_POST,'stad');
        $straat=filter_input(INPUT_POST,'straat');
        $postcode=filter_input(INPUT_POST,'postcode');
        $geslacht=filter_input(INPUT_POST,'geslacht');
        $geboortedtm = filter_input(INPUT_POST,'geboortedatum');
        
        if($gn===null || $vn===null || $an===null ||$email===null ||$plaats===null|| $postcode===null || $geslacht===null || $geboortedtm===null || $straat===null)
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }
        
        if( $email===false)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        if(empty($ww))
        {
           
            $sql= "INSERT INTO `persons` (username,password,firstname,preprovision,lastname,dateofbirth,gender,emailaddress,street,postalcode,"
                    . "place,role) VALUES (:gebruikersnaam,'qwerty',:voorletters,:tussenvoegsel,:achternaam,:geboortedtm,:gender,
                :email,:street,:postcode,:plaats,'lid')";
            
            $stmnt = $this->dbh->prepare($sql);
        }
        else{
            
            $sql= "INSERT INTO `persons` (username,password,firstname,preprovision,lastname,dateofbirth,gender,emailaddress,street,postalcode,"
                    . "place,role) VALUES (:gebruikersnaam,:wachtwoord,:voorletters,:tussenvoegsel,:achternaam, :geboortedtm,:gender,
                :email,:street,:postcode,:plaats,'lid')";
            $stmnt = $this->dbh->prepare($sql);
            $stmnt->bindParam(':wachtwoord', $ww);
        }
        $stmnt->bindParam(':gebruikersnaam', $gn);
        $stmnt->bindParam(':voorletters', $vn);
        $stmnt->bindParam(':tussenvoegsel', $tv);
        $stmnt->bindParam(':achternaam', $an);
        $stmnt->bindParam(':geboortedtm', $geboortedtm);
        $stmnt->bindParam(':gender', $geslacht);
        $stmnt->bindParam(':email', $email);
        $stmnt->bindParam(':postcode', $postcode);
        $stmnt->bindParam(':plaats', $plaats);
        $stmnt->bindParam(':street', $straat);
        
        try
        {
            $stmnt->execute();
            
        }
        catch(\PDOEXception $e)
        {
            
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        if($stmnt->rowCount()===1)
        {            
            return REQUEST_SUCCESS;
        }
        return REQUEST_FAILURE_DATA_INVALID; 
    }
}