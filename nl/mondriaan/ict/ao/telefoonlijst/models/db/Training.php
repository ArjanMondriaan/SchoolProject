<?php
namespace nl\mondriaan\ict\ao\telefoonlijst\models\db;

    class Training extends \ao\php\framework\models\db\Entiteit {
    protected $id;
    protected $description;
    protected $duration;
    protected $extra_costs;
    protected $name;
    
    public function __construct()
    {
        $this->id = filter_var($this->id,FILTER_VALIDATE_INT);
    }

}