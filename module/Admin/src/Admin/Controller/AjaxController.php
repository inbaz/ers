<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class AjaxController extends AbstractActionController {
    public function indexAction() {
        return new ViewModel();
    }
    public function matchingOrderAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        
        $viewModel = new ViewModel();
        $viewModel->setTemplate("partial/ajax/matching-order");
        
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        $order = $entityManager->getRepository('ErsBase\Entity\Order')
                #->findOneBy(array('id' => '297'));
                #->findOneBy(array('id' => '12'));
                #->findOneBy(array('id' => '54'));
                ->findOneBy(array('id' => $id));
        
        $viewModel->setVariable("order", $order);

        $viewModel->setTerminal(true);

        return $viewModel;
    }
    
    public function matchingBankstatementAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        
        $viewModel = new ViewModel();
        $viewModel->setTemplate("partial/ajax/matching-bankstatement");
        
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        $bankaccount = $entityManager->getRepository('ErsBase\Entity\PaymentType')
                ->findOneBy(array('id' => $id));
        
        $queryBuilder = $entityManager->getRepository('ErsBase\Entity\BankStatement')->createQueryBuilder('s');
        $queryBuilder->leftJoin('s.matches', 'm');
        if($bankaccount->getVirtual()) {
            $queryBuilder->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq('s.payment_type_id', '?1'),
                    $queryBuilder->expr()->neq('s.status', '?2')
                )
            );
            $queryBuilder->setParameter(1, $id);
            $queryBuilder->setParameter(2, 'disabled');
        } else {
            $queryBuilder->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq('s.payment_type_id', '?1'),
                    $queryBuilder->expr()->eq('s.status', '?2')
                    /*$queryBuilder->expr()->neq('s.status', '?2'),
                    $queryBuilder->expr()->neq('s.status', '?3'),
                    $queryBuilder->expr()->orX(
                        $queryBuilder->expr()->isNull('m.BankStatement_id'),
                        $queryBuilder->expr()->neq('m.status', '?4')
                    )*/
                )
            );
            $queryBuilder->setParameter(1, $id);
            $queryBuilder->setParameter(2, 'new');
            /*$queryBuilder->setParameter(3, 'matched');
            $queryBuilder->setParameter(4, 'disabled');*/
        }
        
        $statements = $queryBuilder->getQuery()->getResult();

        $viewModel->setVariable("statements", $statements);
        $viewModel->setTerminal(true);
        return $viewModel;
    }
    
    public function matchingStatementcolsAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        
        $viewModel = new ViewModel();
        $viewModel->setTemplate("partial/ajax/matching-statementcols");
        
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        $statement = $entityManager->getRepository('ErsBase\Entity\BankStatement')
                ->findOneBy(array('id' => $id));
        
        $viewModel->setVariable("statement", $statement);
        $viewModel->setTerminal(true);
        return $viewModel;
    }
    
    public function virtualBankaccountAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        
        $entityManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        $bankaccount = $entityManager->getRepository('ErsBase\Entity\PaymentType')
                ->findOneBy(array('id' => $id));
        
        return $bankaccount->getVirtual();
    }
    
    public function choosePaymentTypesAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
        /*if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
             && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {*/
            
            
            # get currency id
            $id = $this->params()->fromRoute("id");
            
            $entityManager = $this->getServiceLocator()
                    ->get('Doctrine\ORM\EntityManager');
            $currency = $entityManager->getRepository('ErsBase\Entity\Currency')
                    ->findOneBy(array('id' => $id));
            $paymenttypes = $entityManager->getRepository('ErsBase\Entity\PaymentType')
                    ->findBy(array(), array('position' => 'ASC'));
            
            
            error_log('found '.count($paymenttypes).' pts');
            $paymenttypeOptions = [];
            foreach($paymenttypes as $paymenttype) {
                $active = false;
                if($paymenttype->getCurrency()->getShort() == $currency->getShort()) {
                    $active = true;
                }
                $paymenttypeOptions[$paymenttype->getId()] = [
                    'name' => $paymenttype->getName(),
                    'active' => $active,
                ];
            }
            
            error_log('found '.count($paymenttypeOptions).' options');
            return new JsonModel($paymenttypeOptions);
        } else {
            // return a 404 if this action is not called via ajax
            $this->getResponse()->setStatusCode(404);
            return NULL;
        }
    }
}