<?php
    namespace nl\mondriaan\ict\ao\telefoonlijst\controls;
    use nl\mondriaan\ict\ao\telefoonlijst\models as MODELS;
    use nl\mondriaan\ict\ao\telefoonlijst\view as VIEW;

    class DirecteurController extends \ao\php\framework\controls\AbstractController
    {
        public function __construct($control,$action)
        {
            parent::__construct($control, $action);
        }
        
        

        protected function defaultAction()
        {
             $gebruiker=$this->model->getGebruiker();
             $this->view->set('gebruiker',$gebruiker);
             $contacten = $this->model->getContacten();
             if($contacten !==REQUEST_FAILURE_DATA_INVALID)
             {
                 $this->view->set('contacten',$contacten);
             }
             $afdelingen = $this->model->getAfdelingen();
             if($afdelingen !== REQUEST_FAILURE_DATA_INVALID)
             {
                 $this->view->set('afdelingen',$afdelingen);
             }
        }
        
    }
?>
