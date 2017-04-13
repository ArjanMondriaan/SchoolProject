<?php
namespace nl\mondriaan\ict\ao\telefoonlijst\models;

use nl\mondriaan\ict\ao\telefoonlijst\utils\Foto as FOTO;

class AdministratieModel extends \ao\php\framework\models\AbstractModel
{
    
    public function __construct($control, $action)
    {  
        parent::__construct($control, $action);
    }
    
    public function getContacten()
    {
       $sql = 'SELECT * FROM persons WHERE role = "lid" ';
       $stmnt = $this->dbh->prepare($sql);
       $stmnt->execute();
       $contacten = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Contact');    
       return $contacten;
    }
    
    public function getInstructeurs(){
       $sql = 'SELECT * FROM persons WHERE role = "instructeur" ';
       $stmnt = $this->dbh->prepare($sql);
       $stmnt->execute();
       $contacten = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Contact');    
       return $contacten;
    }
    
    public function getMedewerker()
    {
        $id= filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
        if($id===null)
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }
        if($id===false)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        $sql = "SELECT * from `contacten` WHERE `contacten`.`id`=:id";
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':id', $id);
        $stmnt->execute();
        $contact = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Contact');
        if(count($contact)===0)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        return $contact[0];
    }
    public function GetMedewerkergegevens()
    {
            $id= filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
            $voorletter=filter_input(INPUT_POST, 'vl');
            $tussenvoegsel=filter_input(INPUT_POST, 'tv');
            $achternaam=filter_input(INPUT_POST, 'an');
            $intern=filter_input(INPUT_POST,'int');
            $extern=filter_input(INPUT_POST,'ext');
            $email=filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);

            
                $sql="UPDATE `contacten` SET voorletter=:voorletter"
            . ",tussenvoegsel=:tussenvoegsel,achternaam=:achternaam,"
             . "extern=:extern,intern=:intern,email=:email where `contacten`.`id`= :id ";
            
            $stmnt = $this->dbh->prepare($sql);
            $stmnt->bindParam(':id', $id);
            $stmnt->bindParam(':voorletter', $voorletter);
            $stmnt->bindParam(':tussenvoegsel', $tussenvoegsel);
            $stmnt->bindParam(':achternaam', $achternaam);
            $stmnt->bindParam(':extern', $extern);
            $stmnt->bindParam(':intern', $intern);
            $stmnt->bindParam(':email', $email);
            
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
    
    public function deleteContact()
    {
        $id= filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
       
        if($id===null)
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }
        if($id===false)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }   
       
        $sql = "SELECT * FROM `contacten` WHERE `contacten`.`id`=:id";
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':id', $id); 
        $stmnt->execute();
        $contacten = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Contact');
        if(count($contacten)===0)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        $fotoNaam = $contacten[0]->getFoto();
        $sql = "DELETE FROM `contacten` WHERE `contacten`.`id`=:id";
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':id', $id); 
        $stmnt->execute();
        if($stmnt->rowCount()===1){
            if($fotoNaam!=IMAGE_DEFAULT)
            {
                FOTO::verwijderAfbeelding($fotoNaam);
            }
            return REQUEST_SUCCESS;
        }
        return REQUEST_NOTHING_CHANGED;
    }
    
    public function addContact()
    {
        $gebruikersnaam= filter_input(INPUT_POST, 'gn');
        $wachtwoord= filter_input(INPUT_POST, 'ww');
        $voorletter=filter_input(INPUT_POST, 'vl');
        $tussenvoegsel=filter_input(INPUT_POST, 'tv');
        $achternaam=filter_input(INPUT_POST, 'an');
        $afdeling=filter_input(INPUT_POST,'afd',FILTER_VALIDATE_INT);
        $email=filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
        $intern=filter_input(INPUT_POST,'int');
        $extern=filter_input(INPUT_POST,'ext');
        
        if($gebruikersnaam===null || $voorletter===null || $achternaam===null || $afdeling===null ||$email===null)
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }
        
        if($afdeling===false || $email===false)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        if(empty($wachtwoord))
        {
            $wachtwoord='qwerty';
        }
        
        $result = FOTO::isAfbeeldingGestuurd();
        if($result===IMAGE_FAILURE_TYPE || $result===IMAGE_FAILURE_SIZE_EXCEEDED)
        {
            return $result;
        }
        
        if($result===IMAGE_NOTHING_UPLOADED)
        {
            $foto=IMAGE_DEFAULT;
        }
        else 
        {
            $foto = FOTO::getAfbeeldingNaam();
        }
        
        $sql="INSERT IGNORE INTO `contacten`  (gebruikersnaam,wachtwoord,voorletter,tussenvoegsel,achternaam,"
        . "extern,intern,email,foto,recht,afdelings_id)VALUES (:gebruikersnaam,:wachtwoord,:voorletter,:tussenvoegsel,:achternaam,"
        . ":extern,:intern,:email,:foto,'medewerker',:afdeling) ";

        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':gebruikersnaam', $gebruikersnaam);
        $stmnt->bindParam(':wachtwoord', $wachtwoord);
        $stmnt->bindParam(':voorletter', $voorletter);
        $stmnt->bindParam(':tussenvoegsel', $tussenvoegsel);
        $stmnt->bindParam(':achternaam', $achternaam);
        $stmnt->bindParam(':extern', $extern);
        $stmnt->bindParam(':intern', $intern);
        $stmnt->bindParam(':email', $email);
        $stmnt->bindParam(':foto', $foto);
        $stmnt->bindParam(':afdeling', $afdeling);
        
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
            if(!empty($foto))
            {
                FOTO::slaAfbeeldingOp($foto);
            }
            return REQUEST_SUCCESS;
        }
        return REQUEST_FAILURE_DATA_INVALID; 
    }
    
    function isPostLeeg()
    {
       return empty($_POST);
    }
    
    public function isGerechtigd()
    {
        //controleer of er ingelogd is. Ja, kijk of de gebruiker de deze controller mag gebruiken 
        if(isset($_SESSION['gebruiker'])&&!empty($_SESSION['gebruiker']))
        {
            $gebruiker=$_SESSION['gebruiker'];
            return $gebruiker->getRecht() === $this->control;
        }
        return false;
   }
   
//   public function getGebruiker()
//   {
//       return $_SESSION['gebruiker'];
//   }
   
   public function uitloggen()
   {
       $_SESSION = array();
       session_destroy();
   }
   
    public function wijzigAnw()
    {
        $gebruikersnaam= filter_input(INPUT_POST, 'gn');
        $voorletter=filter_input(INPUT_POST, 'vl');
        $tussenvoegsel=filter_input(INPUT_POST, 'tv');
        $achternaam=filter_input(INPUT_POST, 'an');
        $email=filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
        $intern=filter_input(INPUT_POST,'int');
        $extern=filter_input(INPUT_POST,'ext');
        
        if(empty($voorletter)||empty($achternaam)||empty($email)||empty($gebruikersnaam))
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE; 
        }
        
        if($email===false)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        $gebruiker_id = $this->getGebruiker()->getId();
        
        $sql="UPDATE `contacten` SET gebruikersnaam=:gebruikersnaam,voorletter=:voorletter"
                . ",tussenvoegsel=:tussenvoegsel,achternaam=:achternaam,"
                 . "extern=:extern,intern=:intern,email=:email where `contacten`.`id`= :gebruiker_id; ";
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':gebruikersnaam', $gebruikersnaam);        
        $stmnt->bindParam(':voorletter', $voorletter);
        $stmnt->bindParam(':tussenvoegsel', $tussenvoegsel);
        $stmnt->bindParam(':achternaam', $achternaam);
        $stmnt->bindParam(':extern', $extern);
        $stmnt->bindParam(':intern', $intern);
        $stmnt->bindParam(':email', $email);     
        $stmnt->bindParam(':gebruiker_id', $gebruiker_id);
        
        try
        {
            $stmnt->execute();
        }
        catch(\PDOEXception $e)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        $aantalGewijzigd = $stmnt->rowCount();
        if($aantalGewijzigd===1)
        {
            $this->updateGebruiker();
            return REQUEST_SUCCESS;
        }
        return REQUEST_NOTHING_CHANGED;
    }
    
    private function updateGebruiker() 
    {
        
       $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
       $sql = "SELECT * FROM `persons` WHERE `persons`.`id`=:gebruiker_id";
       $stmnt = $this->dbh->prepare($sql);
       $stmnt->bindParam(':gebruiker_id', $id);
       $stmnt->setFetchMode(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Contact');   
       $stmnt->execute();
       $_SESSION['gebruiker']= $stmnt->fetch(\PDO::FETCH_CLASS);
    }
    
    public function GetDirecteur() 
    {
       $sql = "SELECT * FROM `telefoonlijst`.`contacten` WHERE `contacten`.`recht`= 'directeur'";
       $stmnt = $this->dbh->prepare($sql);
       $stmnt->execute();
       $contacten = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Contact');    
       return $contacten[0];
    }
    public function wijzigDirecteur()
    {
        $gebruikersnaam= filter_input(INPUT_POST, 'gn');
        $voorletter=filter_input(INPUT_POST, 'vl');
        $tussenvoegsel=filter_input(INPUT_POST, 'tv');
        $achternaam=filter_input(INPUT_POST, 'an');
        $email=filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
        $intern=filter_input(INPUT_POST,'int');
        $extern=filter_input(INPUT_POST,'ext');
        
        if(empty($voorletter)||empty($achternaam)||empty($email)||empty($gebruikersnaam))
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE; 
        }
        
        if($email===false)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        $gebruiker_id = $this->GetDirecteur()->getId();
        
        $sql="UPDATE `contacten` SET gebruikersnaam=:gebruikersnaam,voorletter=:voorletter"
                . ",tussenvoegsel=:tussenvoegsel,achternaam=:achternaam,"
                 . "extern=:extern,intern=:intern,email=:email where `contacten`.`id`= :gebruiker_id; ";
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':gebruikersnaam', $gebruikersnaam);        
        $stmnt->bindParam(':voorletter', $voorletter);
        $stmnt->bindParam(':tussenvoegsel', $tussenvoegsel);
        $stmnt->bindParam(':achternaam', $achternaam);
        $stmnt->bindParam(':extern', $extern);
        $stmnt->bindParam(':intern', $intern);
        $stmnt->bindParam(':email', $email);     
        $stmnt->bindParam(':gebruiker_id', $gebruiker_id);
        
        try
        {
            $stmnt->execute();
        }
        catch(\PDOEXception $e)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        $aantalGewijzigd = $stmnt->rowCount();
        if($aantalGewijzigd===1)
        {
            $this->updateGebruiker();
            return REQUEST_SUCCESS;
        }
        return REQUEST_NOTHING_CHANGED;
    }
    
    public function resetWw() {
        //TODO
        $id= filter_input(INPUT_GET,'id');
        
        if($id === null)
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }
        else if ($id === false){
            return REQUEST_FAILURE_DATA_INVALID;
        }
        $sql = "UPDATE `telefoonlijst`.`contacten` SET `wachtwoord` = 'qwerty' WHERE `telefoonlijst`.`contacten`.`id`=:id";
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':id', $id);
        $stmnt->execute();
        
        $rowschanged= $stmnt->rowCount();
        
        if($rowschanged === 1)
        {
            return REQUEST_SUCCESS;
        }
        else{
        return REQUEST_NOTHING_CHANGED;    
        }
        
    }
    
    public function wijzigWw() 
    {
        $ww= filter_input(INPUT_POST,'ww');
        $nww1= filter_input(INPUT_POST,'nww1');
        $nww2= filter_input(INPUT_POST,'nww2');
         
        if($ww===null || $nww1===null || $nww2===null)
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }
        
        if(empty($nww1)||empty($nww2)||empty($ww))
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE;
        }
        
        if($_POST['nww1']!==$_POST['nww2'])
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        $hww = $this->getGebruiker()->getWachtwoord();
        
        if($hww!== $ww)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        if($nww1===$ww)
        {
            return REQUEST_NOTHING_CHANGED;
        }
        
        $id = $this->getGebruiker()->getId();
        $sql = "UPDATE `contacten` SET `contacten`.`wachtwoord` = :nww WHERE `contacten`.`id`= :id";
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':id', $id);
        $stmnt->bindParam(':nww', $nww1);
        $stmnt->execute();
        $aantalGewijzigd = $stmnt->rowCount();
        
        if($aantalGewijzigd === 1)
        {
            $this->updateGebruiker();
            return REQUEST_SUCCESS;
        }
        return REQUEST_NOTHING_CHANGED;
    }

    
    
    public function wijzigFoto() 
    {    
        $fotoNaam = FOTO::getAfbeeldingNaam();//bedenk een naam voor de foto.
        
        $result = FOTO::slaAfbeeldingOp($fotoNaam);//sla foto op
        if($result === false)
        {
            return IMAGE_FAILURE_SAVE_FAILED;
        }
        $id = $this->getGebruiker()->getId();
        //binding onnodig alle gegevens zijn serverside en niet clientside :-)
        $sql = "UPDATE `contacten` SET `contacten`.`foto`= '$fotoNaam' WHERE `contacten`.`id`= :id";
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':id', $id);
        $stmnt->execute();
        $aantalGewijzigd = $stmnt->rowCount();
        if($aantalGewijzigd === 1)
        {
            $oudeFoto = $this->getGebruiker()->getFoto();
            $this->updateGebruiker();
            FOTO::verwijderAfbeelding($oudeFoto);
            return REQUEST_SUCCESS;
        }
        return REQUEST_NOTHING_CHANGED;
    }
    
    public function getAfdelingen() 
    {
       $sql = 'SELECT * FROM `afdelingen` ORDER BY afkorting ASC';
       $stmnt = $this->dbh->prepare($sql);
       $stmnt->execute();
       $afdelingen = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Afdeling');    
       return $afdelingen;
    }
    
    public function getAfdeling()
    {       
       $sql = 'SELECT * FROM `afdelingen`';
       $stmnt = $this->dbh->prepare($sql);                      
       $stmnt->execute();
       $afdelingen = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Afdeling'); 
       if(empty($afdelingen))
       {
            return REQUEST_FAILURE_DATA_INVALID;
       }
       return $afdelingen;
    }
    
    public function  getPersoon(){
        
        $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
        $sql = 'select * FROM persons WHERE id =:id';
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':id', $id); 
        $stmnt->execute();
        $contact = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Contact');
        return $contact[0];
    }
    
    public function wijzigLid(){
        $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
        $voornaam=filter_input(INPUT_POST, 'vn');
        $tussenvoegsel=filter_input(INPUT_POST, 'tv');
        $achternaam=filter_input(INPUT_POST, 'an');
        $email=filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
        $postcode=filter_input(INPUT_POST,'postcode');
        $straat=filter_input(INPUT_POST,'straat');
        $woonplaats=filter_input(INPUT_POST,'woonplaats');
        
        if(empty($voornaam)||empty($achternaam)||empty($email))
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE; 
        }
        
        if($email===false)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        
        $sql="UPDATE `persons` SET firstname=:voornaam"
                . ",preprovision=:tussenvoegsel,lastname=:achternaam,"
                 . "emailaddress=:email,postalcode=:postcode,street=:straat, place=:woonplaats where `persons`.`id`= :gebruiker_id; ";
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':voornaam', $voornaam);        
        $stmnt->bindParam(':tussenvoegsel', $tussenvoegsel);
        $stmnt->bindParam(':achternaam', $achternaam);
        $stmnt->bindParam(':email', $email);
        $stmnt->bindParam(':postcode', $postcode);
        $stmnt->bindParam(':straat', $straat);
        $stmnt->bindParam(':woonplaats', $woonplaats);     
        $stmnt->bindParam(':gebruiker_id', $id);
        
        try
        {
            $stmnt->execute();
        }
        catch(\PDOEXception $e)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        $aantalGewijzigd = $stmnt->rowCount();
        if($aantalGewijzigd===1)
        {
          
            return REQUEST_SUCCESS;
        }
        return REQUEST_NOTHING_CHANGED;
        
    }
    
    
     public function wijzigInstructeur(){
        $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
        $voornaam=filter_input(INPUT_POST, 'vn');
        $tussenvoegsel=filter_input(INPUT_POST, 'tv');
        $achternaam=filter_input(INPUT_POST, 'an');
        $email=filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
        $postcode=filter_input(INPUT_POST,'postcode');
        $straat=filter_input(INPUT_POST,'straat');
        $woonplaats=filter_input(INPUT_POST,'woonplaats');
        $salaris=filter_input(INPUT_POST,'salaris');
        $datum=filter_input(INPUT_POST,'hiringdate');
        
        if(empty($voornaam)||empty($achternaam)||empty($email) || empty($salaris) || empty($datum))
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE; 
        }
        
        if($email===false)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        
        $sql="UPDATE `persons` SET firstname=:voornaam"
                . ",preprovision=:tussenvoegsel,lastname=:achternaam,"
                 . "emailaddress=:email,postalcode=:postcode,street=:straat, place=:woonplaats, hiringdate=:hiringdate, salary=:salaris  where `persons`.`id`= :gebruiker_id; ";
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':voornaam', $voornaam);        
        $stmnt->bindParam(':tussenvoegsel', $tussenvoegsel);
        $stmnt->bindParam(':achternaam', $achternaam);
        $stmnt->bindParam(':email', $email);
        $stmnt->bindParam(':postcode', $postcode);
        $stmnt->bindParam(':straat', $straat);
        $stmnt->bindParam(':woonplaats', $woonplaats);     
        $stmnt->bindParam(':gebruiker_id', $id);
        $stmnt->bindParam(':salaris', $salaris);     
        $stmnt->bindParam(':hiringdate', $datum);
        
        try
        {
            $stmnt->execute();
        }
        catch(\PDOEXception $e)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        $aantalGewijzigd = $stmnt->rowCount();
        if($aantalGewijzigd===1)
        {
          
            return REQUEST_SUCCESS;
        }
        return REQUEST_NOTHING_CHANGED;
        
    }
    
    public function toevoegenInstructeur(){
        $gn = filter_input(INPUT_POST, 'gn');
        $ww1 = filter_input(INPUT_POST, 'ww1');
        $ww2 = filter_input(INPUT_POST, 'ww2');
        $voornaam = filter_input(INPUT_POST, 'vn');
        $tussenvoegsel = filter_input(INPUT_POST, 'tv');
        $achternaam = filter_input(INPUT_POST, 'an');
        $email = filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
        $postcode = filter_input(INPUT_POST,'postcode');
        $straat = filter_input(INPUT_POST,'straat');
        $woonplaats = filter_input(INPUT_POST,'woonplaats');
        $salaris = filter_input(INPUT_POST,'salaris');
        $datum = filter_input(INPUT_POST,'hiringdate');
        $geboortedatum = filter_input(INPUT_POST,'geboortedatum') ;
        
        if(empty($voornaam)||empty($achternaam)||empty($email) || empty($salaris) || empty($datum))
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE; 
        }
        
        if(empty($ww1) && empty($ww2))
        {
            $ww = "qwerty";
        }
        if( $ww1 == $ww2){
            $ww = $ww1;
        } else {
            return REQUEST_FAILURE_DATA_INCOMPLETE;  
        }
        
        if($email===false)
        {  
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        $sql = "INSERT INTO persons (username,password,firstname,preprovision,lastname,emailaddress,postalcode,street,place,salary,hiringdate,dateofbirth)"
                . " VALUES (:gn,:ww,:voornaam,:tussenvoegsel,:achternaam,:email,:postcode,:straat,:woonplaats,:salaris,:hiringdate,:geboortedatum)";
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':gn', $gn);
        $stmnt->bindParam(':ww', $ww);        
        $stmnt->bindParam(':voornaam', $voornaam);        
        $stmnt->bindParam(':tussenvoegsel', $tussenvoegsel);
        $stmnt->bindParam(':achternaam', $achternaam);
        $stmnt->bindParam(':email', $email);
        $stmnt->bindParam(':postcode', $postcode);
        $stmnt->bindParam(':straat', $straat);
        $stmnt->bindParam(':woonplaats', $woonplaats);     
        $stmnt->bindParam(':salaris', $salaris);     
        $stmnt->bindParam(':hiringdate', $datum);
        $stmnt->bindParam(':geboortedatum', $geboortedatum);
        
        try
        {
            $stmnt->execute();
        }
        catch(\PDOEXception $e)
        {   
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        $aantalGewijzigd = $stmnt->rowCount();
        if($aantalGewijzigd===1)
        {
          
            return REQUEST_SUCCESS;
        }
        return REQUEST_NOTHING_CHANGED;
        
    }
    
    public function verwijderPersoon(){
        $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
        $sql = 'DELETE FROM persons WHERE id =:id';
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':id', $id); 
        $stmnt->execute();
        if($stmnt->rowCount()===1)
        {
            return REQUEST_SUCCESS;
        }
        return REQUEST_NOTHING_CHANGED;
    }
    
    public function getTrainingsvormen(){
       $sql = 'SELECT * FROM training ';
       $stmnt = $this->dbh->prepare($sql);
       $stmnt->execute();
       $contacten = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Training');    
       return $contacten;
    }
    
    public function  getTrainingsvorm(){
        
        $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
        $sql = 'select * FROM training WHERE id =:id';
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':id', $id); 
        $stmnt->execute();
        $trainingsvorm = $stmnt->fetchAll(\PDO::FETCH_CLASS,__NAMESPACE__.'\db\Training');
        return $trainingsvorm[0];
    }
    
     public function wijzigTrainingsvorm(){
        $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
        $beschrijving=filter_input(INPUT_POST, 'description');
        $extracosts=filter_input(INPUT_POST, 'extracosts');
        $naam=filter_input(INPUT_POST, 'naam');
        $duration = filter_input(INPUT_POST,'duration');
    
        if(empty($naam)||empty($beschrijving)|| empty($duration))
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE; 
        }

        
        
        $sql="UPDATE `training` SET description=:description, extra_costs=:extracost, name=:naam, duration=:duration   where `training`.`id`= :training_id; ";
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':description', $beschrijving);        
        $stmnt->bindParam(':extracost', $extracosts);
        $stmnt->bindParam(':naam', $naam);  
        $stmnt->bindParam(':training_id', $id);
        $stmnt->bindParam(':duration', $duration);     
        
        try
        {
            $stmnt->execute();
        }
        catch(\PDOEXception $e)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        $aantalGewijzigd = $stmnt->rowCount();
        if($aantalGewijzigd===1)
        {
          
            return REQUEST_SUCCESS;
        }
        return REQUEST_NOTHING_CHANGED;
        
    }
    
    public function verwijderTrainingsvorm(){
        $id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
        $sql = 'DELETE FROM training WHERE id =:id';
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':id', $id); 
        $stmnt->execute();
        if($stmnt->rowCount()===1)
        {
            return REQUEST_SUCCESS;
        }
        return REQUEST_NOTHING_CHANGED;
    }
    
    public function toevoegenTrainingsvorm(){
       
        $beschrijving=filter_input(INPUT_POST, 'description');
        $extracosts=filter_input(INPUT_POST, 'extracosts');
        $naam=filter_input(INPUT_POST, 'naam');
        $duration = filter_input(INPUT_POST,'duration');
    
        if(empty($naam)||empty($beschrijving)|| empty($duration))
        {
            return REQUEST_FAILURE_DATA_INCOMPLETE; 
        }

        $sql = "INSERT INTO training (description,extra_costs,name,duration)"
                . " VALUES (:description,:extracost,:naam,:duration)";
        $stmnt = $this->dbh->prepare($sql);
        $stmnt->bindParam(':description', $beschrijving);        
        $stmnt->bindParam(':extracost', $extracosts);
        $stmnt->bindParam(':naam', $naam);  
        $stmnt->bindParam(':duration', $duration);     
        
        try
        {
            $stmnt->execute();
        }
        catch(\PDOEXception $e)
        {
            return REQUEST_FAILURE_DATA_INVALID;
        }
        
        $aantalGewijzigd = $stmnt->rowCount();
        if($aantalGewijzigd===1)
        {
          
            return REQUEST_SUCCESS;
        }
        return REQUEST_NOTHING_CHANGED;
        
    }

    

}