<?php
namespace nl\mondriaan\ict\ao\telefoonlijst\models\db;

    class Lessons extends \ao\php\framework\models\db\Entiteit
{
    protected $time;
    protected $date;
    protected $location;
    protected $maxpersons;
    protected $personid;
    protected $trainingid;
    
    public function __construct()
    {
        $this->id = filter_var($this->id,FILTER_VALIDATE_INT);
    }

}