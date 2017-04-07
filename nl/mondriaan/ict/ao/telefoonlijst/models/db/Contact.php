<?php
namespace nl\mondriaan\ict\ao\telefoonlijst\models\db;
class Contact extends \ao\php\framework\models\db\Entiteit
{
    protected $id;
    protected $username;
    protected $password;
    protected $firstname;
    protected $prepovision;
    protected $lastname;
    protected $dateofbirth;
    protected $gender;
    protected $emailaddress;
    protected $hiringdate;
    protected $salary;
    protected $street;
    protected $postalcode;
    protected $place; 
    protected $role;




    public function __construct()
    {
        $this->id = filter_var($this->id,FILTER_VALIDATE_INT);
    }
    public function getNaam()
    {
        return "$this->firstname. $this->prepovision $this->lastname";
    }
}
