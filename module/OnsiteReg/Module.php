<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OnsiteReg;

#use ErsBase\Entity;
use Zend\Mvc\ModuleRouteListener;
#use Zend\Session\SessionManager;
#use Zend\Session\Container;
#use Zend\Mvc\MvcEvent;
use ErsBase\Service;

class Module
{
    public function onBootstrap($e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $eventManager->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e) {
            $controller      = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            $config          = $e->getApplication()->getServiceManager()->get('config');
            if (isset($config['module_layouts'][$moduleNamespace])) {
                $controller->layout($config['module_layouts'][$moduleNamespace]);
            }
        }, 100);
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $this->bootstrapSession($e);
        
        $application   = $e->getApplication();
        $serviceManager = $application->getServiceManager();
        $auth = $serviceManager->get('BjyAuthorize\Service\Authorize');

        if(!\Zend\Console\Console::isConsole()) {
            $acl  = $auth->getAcl();
            $role = $auth->getIdentity();
            \Zend\View\Helper\Navigation::setDefaultAcl($acl);
            \Zend\View\Helper\Navigation::setDefaultRole($role);
        }
        
        $sharedManager = $application->getEventManager()->getSharedManager();
        $sharedManager->attach('Zend\Mvc\Application', 'dispatch.error',
                function($e) use ($serviceManager) {
                    if ($e->getParam('exception')){
                        #$serviceManager->get('Logger')->crit($e->getParam('exception'));
                        
                        /*$auth = $serviceManager->get('zfcuser_auth_service');
                        if (!$auth->hasIdentity()) {
                            $url = $e->getRouter()->assemble(array(), array('name' => 'zfcuser/login'));
                            $response=$e->getResponse();
                            $response->getHeaders()->addHeaderLine('Location', $url);
                            $response->setStatusCode(302);
                            $response->sendHeaders(); 
                            
                            // When an MvcEvent Listener returns a Response object,
                            // It automatically short-circuit the Application running 
                            // -> true only for Route Event propagation see Zend\Mvc\Application::run

                            // To avoid additional processing
                            // we can attach a listener for Event Route with a high priority
                            $stopCallBack = function($event) use ($response){
                                $event->stopPropagation();
                                return $response;
                            };
                            //Attach the "break" as a listener with a high priority
                            $e->getApplication()->getEventManager()->attach(MvcEvent::EVENT_ROUTE, $stopCallBack,-10000);
                            return $response;
                        }*/
                    }
                }
            );

        /*$zfcAuthEvents = $serviceManager->get('ZfcUser\Authentication\Adapter\AdapterChain')->getEventManager();

        $zfcAuthEvents->attach( 'authenticate.success', function( $authEvent ) use( $serviceManager ){
            $loginService =  $serviceManager->get( 'PreReg\Service\LoginService' );
            $user_id = $authEvent->getIdentity();
            $loginService->setUserId($user_id);
            $loginService->onLogin();
            return true;
        });
        
        $zfcAuthEvents->attach( 'logout', function( $authEvent ) use( $serviceManager ){
            $loginService =  $serviceManager->get( 'PreReg\Service\LoginService' );
            #$user_id = $authEvent->getIdentity();
            #$loginService->setUserId($user_id);
            $loginService->onLogout();
            return true;
        });*/
    }
    
    public function bootstrapSession($e)
    {
        /*$session = $e->getApplication()
                     ->getServiceManager()
                     ->get('Zend\Session\SessionManager');
        $session->start();*/
        
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig() {
        return array(
            'factories' => array(        
                'OnsiteReg\Form\ProductView' => function ($serviceManager) {
                    $productView = new Form\ProductView();
                    $productView->setServiceLocator($serviceManager);
                    return $productView;
                },
                'OnsiteReg\Form\CreditCard' => function ($serviceManager) {
                    $form = new Form\CreditCard();
                    
                    $years = array();
                    for($i=date('Y'); $i<=(date('Y')+15); $i++) {
                        $years[] = array(
                            'value' => $i,
                            'label' => $i,
                        );
                    }
                    $form->get('cc_expdate_year')->setAttribute('options', $years);

                    $months = array();
                    for($i=1; $i<=12; $i++) {
                        $months[] = array(
                            'value' => $i,
                            'label' => sprintf('%02d', $i),
                        );
                    }
                    $form->get('cc_expdate_month')->setAttribute('options', $months);
                    
                    return $form;
                },
                'OnsiteReg\Service\AgegroupService:price' => function($serviceManager) {
                    $agegroupService = new Service\AgegroupService();
                    $entityManager = $serviceManager->get('Doctrine\ORM\EntityManager');
                    $agegroups = $entityManager->getRepository('ErsBase\Entity\Agegroup')
                                ->findBy(array('price_change' => '1'));
                    $agegroupService->setAgegroups($agegroups);
                    
                    return $agegroupService;
                },
                'OnsiteReg\Service\AgegroupService:ticket' => function($serviceManager) {
                    $agegroupService = new Service\AgegroupService();
                    $entityManager = $serviceManager->get('Doctrine\ORM\EntityManager');
                    $agegroups = $entityManager->getRepository('ErsBase\Entity\Agegroup')
                                ->findBy(array('ticket_change' => '1'));
                    $agegroupService->setAgegroups($agegroups);
                    
                    return $agegroupService;
                },
                'OnsiteReg\Service\ETicketService' => function($serviceManager) {
                    $eticketService = new Service\ETicketService();
                    $eticketService->setServiceLocator($serviceManager);
                    return $eticketService;
                },
            ),
        );
    }
    public function getViewHelperConfig()
{
    return array(
        'invokables' => array(
            'formelementerrors' => 'OnsiteReg\Form\View\Helper\FormElementErrors'
        ),
    );
}
}