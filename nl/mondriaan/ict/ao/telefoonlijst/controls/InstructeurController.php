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
            $lessen=$this->model->getSoortenLessen();        
            $this->view->set('lessen',$lessen);
        }
        
        protected function editLesAction()
        {
            if($this->model->isPostLeeg())
            {
               $this->view->set("boodschap","Wijzig hier de cursus gegevens");
            }
            else
            {
                $result = $this->model->wijzigLes();
                switch($result)
                {
                    case REQUEST_SUCCESS:
                        $this->view->set('boodschap','wijziging gelukt');
                        header("location: ?control=Instructeur&action=lessen");
                        break;
                    case REQUEST_FAILURE_DATA_INCOMPLETE:
                        $this->view->set("boodschap","De gegevens waren incompleet. Vul compleet in!");
                        break;
                    case REQUEST_NOTHING_CHANGED:
                        $this->view->set("boodschap","Er was niets te wijzigen");
                        break;
                    case REQUEST_FAILURE_DATA_INVALID:
                        $this->view->set("boodschap","Vul een correcte datum/tijd in.");
                        break;
                }
            }
            $LesInfo = $this->model->editLes();
            $this->view->set('LesInfo',$LesInfo);
        }
        
        protected function addLesAction()
        {
            $instructeurs = $this->model->getInstructeurs();
            $this->view->set('instructeurs',$instructeurs);
            
            $trainingen = $this->model->getTrainingen();
            $this->view->set('trainingen',$trainingen);
            
            if($this->model->isPostLeeg())
            {
               $this->view->set("boodschap","Vul gegevens in van de nieuwe cursus");          
            }
            else
            {   
                $result=$this->model->AddLes();
                switch($result)
                {
                    case REQUEST_FAILURE_DATA_INCOMPLETE:
                        $this->view->set("boodschap", "activiteit is niet toegevoegd. Niet alle vereiste data ingevuld.");  
                        header("location: ?control=Instructeur&action=lessons");
                        break;
                    case REQUEST_FAILURE_DATA_INVALID:
                        $this->view->set("boodschap", "activiteit is niet toegevoegd. Er is foutieve data ingestuurd.");  
                        break;
                    case REQUEST_SUCCESS:
                        $this->view->set("boodschap", "activiteit is toegevoegd."); 
                        break;  
                }  
            }
        }
        protected function deleteLesAction()
        {
            $result = $this->model->DeleteLes();
            switch($result)
            {
                case REQUEST_FAILURE_DATA_INCOMPLETE:
                    $this->view->set('boodschap','geen te verwijderen cursus gegeven, dus niets verwijderd');
                    break;
                case REQUEST_FAILURE_DATA_INVALID:
                    $this->view->set('boodschap','te verwijderen cursus bestaat niet');
                    break;
                case REQUEST_NOTHING_CHANGED:
                     $this->view->set('boodschap','te verwijderen cursus bestaat niet.');
                    break;
                case REQUEST_SUCCESS:
                    $this->view->set('boodschap','Cursus verwijderd.');
                    break;
            }
            header("location: ?control=Instructeur&action=lessen");
        }
    }
?>
