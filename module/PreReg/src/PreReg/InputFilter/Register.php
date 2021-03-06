<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PreReg\InputFilter;

use Zend\InputFilter\Factory as InputFactory; 
use Zend\InputFilter\InputFilter; 
use Zend\InputFilter\InputFilterAwareInterface; 
use Zend\InputFilter\InputFilterInterface; 
use Zend\Session\Container;

class Register implements InputFilterAwareInterface 
{ 
    protected $inputFilter; 
    protected $entityManager;
    protected $serviceManager;
    protected $loginEmail;
    protected $email;
    
    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager) {
        $this->em = $entityManager;
    }
    public function getEntityManager() {
        return $this->em;
    }
    
    public function setServiceLocator($serviceManager) {
        $this->sm = $serviceManager;
    }
    public function getServiceLocator() {
        return $this->sm;
    }
    
    public function setLoginEmail($loginEmail) {
        $this->loginEmail = $loginEmail;
    }
    public function getLoginEmail() {
        return $this->loginEmail;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }
    public function getEmail() {
        return $this->email;
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter) 
    { 
        throw new \Exception("Not used"); 
    } 
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) 
        { 
            $inputFilter = new InputFilter(); 
            $factory = new InputFactory();             
            
            $inputFilter->add($factory->createInput([ 
                'name' => 'buyer_id', 
                'required' => true, 
                'filters' => array( 
                    array('name' => 'Int'), 
                ),
                'validators' => array(
                    array(
                        'name' => 'Callback',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\Callback::INVALID_VALUE => 'Please select a buyer.',
                            ),
                            'callback' => function($value, $context=array()) {
                                /*
                                 * If the buyer_id is not 0 the user adds an 
                                 * already existing participant as buyer.
                                 */
                                if($context['buyer_id'] != 0) {
                                    return true;
                                }
                                
                                return false;
                            },
                            
                        ),
                    ),
                    array(
                        'name' => 'Callback',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\Callback::INVALID_VALUE => 'The email of this buyer already exists. Please login with this account to continue.',
                            ),
                            'callback' => function($value, $context=array()) {
                                #$cartContainer = new Container('ers');
                                $orderService = $this->getServiceLocator()
                                        ->get('ErsBase\Service\OrderService');
                                $order = $orderService->getOrder();
                                $participant = $order->getParticipantById($value);
                                
                                if(!$participant) {
                                    throw new \Exception('Unable to find participant with id '.$value);
                                }
                                
                                $auth = $this->getServiceLocator()
                                        ->get('zfcuser_auth_service');
                                if ($auth->hasIdentity()) {
                                    if($auth->getIdentity()->getEmail() == $participant->getEmail()) {
                                        return true;
                                    }
                                }
                                
                                $entityManager = $this->getServiceLocator()
                                    ->get('Doctrine\ORM\EntityManager');
                                
                                $user = $entityManager->getRepository('ErsBase\Entity\User')->findOneBy(array(
                                    'email' => $participant->getEmail(),
                                    'active' => true,
                                    ));
                                if($user == null) {
                                    return true;
                                }
                                return false;
                            },
                            
                        ),
                    ),
                ),
            ]));
            
            $this->inputFilter = $inputFilter; 
        } 
        
        return $this->inputFilter; 
    } 
} 