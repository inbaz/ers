<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ErsBase\Service;

use Zend\Session\Container;
use ErsBase\Entity;

/**
 * order service
 */
class ServiceLocatorAwareService
{
    protected $_sl;
    
    public function __construct($serviceLocator = null) {
        if($serviceLocator != null) {
            $this->setServiceLocator($serviceLocator);
        }
    }
    
    /**
     * set ServiceLocator
     * 
     * @param ServiceLocator $serviceLocator
     */
    public function setServiceLocator($serviceLocator) {
        $this->_sl = $serviceLocator;
    }
    
    /**
     * get ServiceLocator
     * 
     * @return ServiceLocator
     */
    protected function getServiceLocator() {
        return $this->_sl;
    }
    
}
