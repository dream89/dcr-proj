<?php

class Admin_AuthController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $form = new Form_Login();
        $this->view->form = $form;
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                if ($this->_process($form->getValues())) {
                    // We're authenticated! Redirect to the home page                    
                    $this->_helper->redirector('index', 'index');
                }
            }
        }              
    }

    protected function _process($values)
    {        
        $adapter = $this->_getAuthAdapter();
        $adapter->setIdentity($values['username'])
                ->setCredential($values['password']);
        var_dump($adapter);
        //$result = $adapter->authenticate();
        if ($result->isValid())
        {
      //      $auth->getStorage()->write($contents);
            return true;
        }        
        return false;
    }

    protected function _getAuthAdapter()
    {
        $doctrineContainer = Zend_Registry::get('doctrine');
        $authAdapter = new App_Auth_Doctrine_Adapter($doctrineContainer->getEntityManager());
        
        $authAdapter->setEntityName('users')
                ->setIdentityColumn('username')
                ->setCredentialColumn('password');

        return $authAdapter;
    }

    public function logoutAction()
    {       
        //clear auth and user sessions
        if($session->authenticated)
        {
            $session->authenticated = false;
            $this->_helper->redirector('index', 'login'); // back to login page
        }
    }

}


