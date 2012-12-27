<?php

class EntryController extends Zend_Controller_Action
{
    protected $_doctrineContainer;
    protected $_timelimit;
    
    
    public function init()
    {
       $this->_doctrineContainer = Zend_Registry::get("doctrine");
       $this->view->entityName = ucfirst('entry');
       $this->_timelimit = "20:00:00";
    }

    public function indexAction()
    {
        $em = $this->_doctrineContainer->getEntityManager();

        $entries = $em->createQuery("SELECT u FROM App\Entity\Entry u")->execute();
        //var_dump($entries);exit;
        $this->view->entries = $entries;
    }

    public function addAction()
    {
            $temp_form = new Form_Entry();
            $temp_form->submit->setLabel("Add");
            if(time() < strtotime($this->_timelimit)) // new entry mode
            {
               $form = $this->_initNewEntry($temp_form);
               $this->view->form = $form;
            }            

            // POST for submitting form
            if($this->getRequest()->isPost())
            {
                $formData = $this->getRequest()->getPost();

                $cat_id = $formData["category"];
                $area_id = $formData["area"];
                $city_id = $formData["city"];
      
                if($form->isValid($formData) && ($cat_id > 0) && ($area_id > 0) && ($city_id > 0))
                {
                    $em = $this->_doctrineContainer->getEntityManager();

                    // get category name from database table
                    $query = $em->createQuery("SELECT c FROM App\Entity\Category c WHERE c.id = :id");
                    $query->setParameter("id", $cat_id);
                    $cats = $query->getResult();
                    
                    // get area name from database table
                    $query = $em->createQuery("SELECT a FROM App\Entity\Area a WHERE a.id = :id");
                    $query->setParameter("id", $area_id);
                    $areas = $query->getResult();
                    
                    // get city name from database table
                    $query = $em->createQuery("SELECT c FROM App\Entity\City c WHERE c.id = :id");
                    $query->setParameter("id", $city_id);
                    $cities = $query->getResult();

                    $user = Model_Users::getLoggedInUser(); // current user object

                    $entry = new \App\Entity\Entry();
                    $entry->dwpno = date("dmY").($user->id+100);
                    $entry->cat = $cats[0]->name;
                    $entry->customerInfo = $formData["customerInfo"];
                    $entry->visitTime = $formData["visitTime"];
                    $entry->area = $areas[0]->name;
                    $entry->city = $cities[0]->name;
                    $entry->activity = $formData["activity"];
                    $entry->user_id = $user->id;
                                        
                    $em->persist($entry);
                    //var_dump($entry);exit;                                     
                    $em->flush();
                    
                    $this->_helper->redirector("index");
                }
                else $form->populate($formData);
            }            
    }


    public function updateAction()
    {
        $temp_form = new Form_Entry();
        $temp_form->submit->setLabel('Save');
        $form = $temp_form;
        
        if(time() >= strtotime($this->_timelimit)) // update result mode
        {
            $form = $this->_initUpdateResult($temp_form);
            $this->view->form = $form;
        }

        if($this->getRequest()->isPost() && $this->_getParam('id'))
        {
            $formData = $this->getRequest()->getPost();

            if($formData['result'] === null)
                $formData['result'] = "incomplete";
            if($formData['remarks'] === null)
                $formData['remarks'] = "---";

            if($form->isValid($formData))
            {
                $form->update($formData); // update with new data
                $this->_helper->redirector('index'); // redirect to index
            }
            else $form->populate($formData);
            
        }
        else {
            $id = $this->getRequest()->getParam('id',0);
            if($id > 0)
            {
                $em = $this->_doctrineContainer->getEntityManager();
                $query = $em->createQuery("SELECT u FROM App\Entity\Entry u WHERE u.id = :id");
                $query->setParameter("id", $id);
                $result = $query->getResult();

                $form->populate($result[0]->toArray());
            }
        }
        
    }

    public function deleteAction()
    {
        $this->_perform();
    }

    private function _perform()
    {
        $actionName = $this->getRequest()->getActionName();
        $controllerName = $this->getRequest()->getControllerName();
        $result = $this->_helper->entities->$actionName($controllerName);
        if($result === true)
        {
            $this->_helper->redirector("index");
        }
    }
    
    private function _initNewEntry($form)
    {
        $form->populateCategoryList()
             ->populateAreaList();

        // disable result list
        $result = $form->getElement('result');
        $result->setAttrib("disabled", true);

        // disable remarks box
        $remarks = $form->getElement('remarks');
        $remarks->setAttrib("disabled", true);
        
        return $form;
    }

    private function _initUpdateResult($form)
    {   
        // enable result list
        $result = $form->getElement('result');
        $result->setAttrib("disabled", false);

        // enable remarks box
        $remarks = $form->getElement('remarks');
        $remarks->setAttrib("disabled", false);

        // get other form elements
        $elements = array(
            $form->getElement('category'),
            $form->getElement('customerInfo'),
            $form->getElement('visitTime'),
            $form->getElement('area'),
            $form->getElement('city'),
            $form->getElement('activity'),
        );
        foreach($elements as $element)// disable other form elements
        {
            $element->setAttrib("disabled", true)
                    ->setRequired(false);
        }
        return $form;
    }

 
    

}

