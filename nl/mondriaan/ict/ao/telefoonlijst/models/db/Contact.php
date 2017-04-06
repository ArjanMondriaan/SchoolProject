<?php
namespace nl\mondriaan\ict\ao\telefoonlijst\models\db;
class Contact extends \ao\php\framework\models\db\Entiteit
{
    protected $id;
    protected $gebruikersnaam;
    protected $wachtwoord;
    protected $voorletter;
    protected $tussenvoegsel;
    protected $achternaam;
    protected $intern;
    protected $extern;
    protected $email;
    protected $recht;
    protected $foto;
    protected $afdelings_id;
    protected $afdelings_naam;
    protected $afdelings_afkorting;
    
    
    public function __construct()
    {
        $this->id = filter_var($this->id,FILTER_VALIDATE_INT);
        $this->afdelings_id = filter_var($this->afdelings_id,FILTER_VALIDATE_INT);
    }
    public function getNaam()
    {
        return "$this->voorletter. $this->tussenvoegsel $this->achternaam";
    }
}
