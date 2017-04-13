<?php
namespace nl\mondriaan\ict\ao\telefoonlijst\models\db;

class Afdeling extends \ao\php\framework\models\db\Entiteit{
    protected $id;
    protected $omschrijving;
    protected $foto;
    protected $afkorting;
    protected $naam;
    protected $time;
    protected $date;
    protected $location;
    protected $maxpersons;
    protected $personid;
    protected $trainingid;
    protected $description;
    protected $extra_costs;


    public function __construct()
    {
        $this->id = filter_var($this->id,FILTER_VALIDATE_INT);
    }
    
}