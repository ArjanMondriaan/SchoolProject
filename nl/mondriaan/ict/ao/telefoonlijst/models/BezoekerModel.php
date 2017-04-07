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
             $sql = 'SELECT * FROM `persons` WHERE `username` = :gn AND `password` = :ww';
             $sth = $this->dbh->prepare($sql);
             $sth->bindParam(':gn',$gn);
             $sth->bindParam(':ww',$ww);
             $sth->execute();
             
             $result = $sth->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Contact');
             
             if(count($result) === 1)
             {   
                 $this->startSessie();   
                 $_SESSION['gebruiker']=$result[0];
                 return REQUEST_SUCCESS;
             }
             return REQUEST_FAILURE_DATA_INVALID;
        } catch (ErrorException $e){
             return REQUEST_FAILURE_DATA_INVALID;
        }
    }
    
    public function controleerInloggen()
    {
        $gn=  filter_input(INPUT_POST, 'gn');
        $ww=  filter_input(INPUT_POST, 'ww');
        
        if ( ($gn!==null) && ($ww!==null) )
        {
             $sql = 'SELECT * FROM `persons` WHERE `username` = :gn AND `password` = :ww';
             $sth = $this->dbh->prepare($sql);
             $sth->bindParam(':gn',$gn);
             $sth->bindParam(':ww',$ww);
             $sth->execute();
             
             $result = $sth->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Contact');
             
             if(count($result) === 1)
             {   
                 $this->startSessie();   
                 $_SESSION['gebruiker']=$result[0];
                 return REQUEST_SUCCESS;
             }
             return REQUEST_FAILURE_DATA_INVALID;
        }
        return REQUEST_FAILURE_DATA_INCOMPLETE;
    }
}
