<?php
    namespace nl\mondriaan\ict\ao\telefoonlijst\controls;
    use nl\mondriaan\ict\ao\telefoonlijst\models as MODELS;
    use nl\mondriaan\ict\ao\telefoonlijst\view as VIEW;

    class InstructeurController extends \ao\php\framework\controls\AbstractController
    {
        public function __construct($control,$action)
        {
            parent::__construct($control, $action);
        }
        
        protected function defaultAction()
        {
            
        }
        
        protected function lessenAction()
        {
            $lessen=$this->model->getLessen();        
            $this->view->set('lessen',$lessen);
        }
        
    }
?>
