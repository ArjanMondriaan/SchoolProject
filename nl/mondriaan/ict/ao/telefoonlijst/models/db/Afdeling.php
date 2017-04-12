<?php
namespace nl\mondriaan\ict\ao\telefoonlijst\models\db;

class Afdeling extends \ao\php\framework\models\db\Entiteit{
    protected $id;
    protected $time;
    protected $date;
    protected $location;
    protected $maxpersons;
    
    public function __construct()
    {
        $this->id = filter_var($this->id,FILTER_VALIDATE_INT);
    }
}