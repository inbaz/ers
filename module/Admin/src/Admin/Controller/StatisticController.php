<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class StatisticController extends AbstractActionController {
    public function indexAction() {
        return new ViewModel();
    }
    
    public function ordersAction() {
        $em = $this
            ->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');

        // old, more complex queries that do not make use of the cached fields and are no longer needed
        /*$qb = $em->createQueryBuilder();
        $order_data = $qb
                ->select('COUNT(DISTINCT o.id) ordercount', 'SUM(i.price) ordersum')
                ->from('ersEntity\Entity\Order', 'o')
                ->join('o.packages', 'p')
                ->join('p.items', 'i', 'WITH', "i.status != 'cancelled' AND i.status != 'refund'")
                ->getQuery()->getSingleResult();
        
        $qb = $em->createQueryBuilder();
        $paymentFees = $qb
                ->select('(pay.fixFee + SUM(i.price)*pay.percentageFee/100) AS fee')
                ->from('ersEntity\Entity\Order', 'o')
                ->join('o.paymentType', 'pay')
                ->join('o.packages', 'p')
                ->join('p.items', 'i', 'WITH', "i.status != 'cancelled' AND i.status != 'refund'")
                ->groupBy('o.id')
                ->getQuery()->getArrayResult();
        
        
        $order_data['paymentfees'] = array_sum(array_map(function($row){ return floatval($row['fee']); }, $paymentFees));
        
        $fastResults = $em->createQueryBuilder()
                ->select('SUM(o.total_sum) totalsum_fast', 'SUM(o.order_sum) ordersum_fast')->from('ersEntity\Entity\Order o')
                ->getQuery()->getSingleResult();
        
        $order_data['ordersum_fast'] = $fastResults['ordersum_fast'];
        $order_data['totalsum_fast'] = $fastResults['totalsum_fast'];
        $order_data['paymentfees_fast'] = $fastResults['totalsum_fast'] - $fastResults['ordersum_fast'];
        */
        
        
        
        $orderSelectFields = array('COUNT(o.id) AS ordercount', 'SUM(o.order_sum) AS ordersum, SUM(o.total_sum) AS totalsum');
        
        $paymentStatusStats = $em->createQueryBuilder()
                ->select(array_merge(array('o.payment_status AS label'), $orderSelectFields))
                ->from('ersEntity\Entity\Order', 'o')
                ->groupBy('o.payment_status')
                ->getQuery()->getResult();
        
        
        $byStatusGroups = array('active' => array(), 'inactive' => array());
        foreach($paymentStatusStats AS $status) {
            if($status["label"] === "cancelled" || $status["label"] === "refund")
                $byStatusGroups['inactive'][] = $status;
            else
                $byStatusGroups['active'][] = $status;
        }
        
        $paymentTypeStats = $em->createQueryBuilder()
                ->select(array_merge(array('pt.name AS label'), $orderSelectFields))
                ->from('ersEntity\Entity\PaymentType', 'pt')
                ->join('pt.orders', 'o', 'WITH', "o.payment_status != 'cancelled' AND o.payment_status != 'refund'")
                ->groupBy('pt.id')
                ->getQuery()->getResult();
        
        
        
        return new ViewModel(array(
            'stats_paymentStatusGroups' => $byStatusGroups,
            'stats_paymentTypes' => $paymentTypeStats
        ));
    }
    
    
    public function participantsAction() {
        $em = $this
            ->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        /*
         * === by agegroups & country ===
         */
        $qb = $em->createQueryBuilder();
        $users = $qb
                ->select('u.birthday', 'c.id country_id', 'c.name country_name', 'SUM(i.price) ordersum')
                ->from('ersEntity\Entity\User', 'u')
                ->leftJoin('u.country', 'c')
                ->join('u.packages', 'p')
                ->join('p.items', 'i', 'WITH', "i.status != 'cancelled' AND i.status != 'refund'")
                ->groupBy('u.id')
                ->getQuery()->getResult();
        
        $agegroupServicePrice = $this->getServiceLocator()
                ->get('PreReg\Service\AgegroupService:price');
        $agegroupServiceTicket = $this->getServiceLocator()
                ->get('PreReg\Service\AgegroupService:ticket');
        
        $agegroupStatsPrice = array();
        $agegroupStatsTicket = array();
        $countryStats = array();
        
        $defEntry = array('count' => 0, 'amount' => 0);
        
        // initialize all groups with 0
        $agegroupStatsPrice['adult'] = $defEntry;
        $agegroupStatsTicket['adult'] = $defEntry;
        foreach($agegroupServicePrice->getAgegroups() AS $agegroup) {
            $agegroupStatsPrice[$agegroup->getName()] = $defEntry;
        }
        foreach($agegroupServiceTicket->getAgegroups() AS $agegroup) {
            $agegroupStatsTicket[$agegroup->getName()] = $defEntry;
        }
        
        // calculate aggregate values
        foreach($users as $user) {
            $agPrice = $agegroupServicePrice->getAgegroupByDate($user['birthday']);
            $agTicket = $agegroupServiceTicket->getAgegroupByDate($user['birthday']);
            
            $aggregatePrice = &$agegroupStatsPrice[($agPrice ? $agPrice->getName() : 'adult')];
            $aggregateTicket = &$agegroupStatsTicket[($agTicket ? $agTicket->getName() : 'adult')];
            
            $aggregatePrice['count']++;
            $aggregatePrice['amount'] += $user['ordersum'];
            $aggregateTicket['count']++;
            
            $countryId = $user['country_id'] ?: 0;
            $countryName = $user['country_name'] ?: "unknown";
            if(!isset($countryStats[$countryId])) {
                $countryStats[$countryId] = array('name' => $countryName, 'count' => 0);
            }
            $countryStats[$countryId]['count']++;
        }
        
        
        /*
         * === by product type ===
         */
        $productStats = $em->createQueryBuilder()
                ->select('prod.displayName', 'COUNT(DISTINCT u.id) AS usercount', 'COUNT(i.id) itemcount')
                ->from('ersEntity\Entity\Package', 'p')
                ->join('p.participant', 'u')
                ->join('p.items', 'i', 'WITH', "i.status != 'cancelled' AND i.status != 'refund'")
                ->join('i.product', 'prod')
                ->groupBy('prod.id')
                ->getQuery()->getResult();
        
        
        /*
         * === by product variant ===
         */
        $variants = $em->getRepository("ersEntity\Entity\ProductVariant")
                ->findBy(array('type' => 'select'));
        
        $variantStats = array();
        /* @var $variant \ersEntity\Entity\ProductVariant */
        foreach($variants as $variant) {
            $variantStats[$variant->getName()] = array();
            foreach($variant->getProductVariantValues() as $value) {
                $qb = $em->createQueryBuilder()
                        ->select('count(DISTINCT i.id)')
                        ->from('ersEntity\Entity\ItemVariant', 'ivar')
                        ->join('ivar.item', 'i', 'WITH', "i.status != 'cancelled' AND i.status != 'refund'")
                        ->where('ivar.ProductVariantValue_id = :value_id')
                        ->setParameter('value_id', $value->getId());
                
                $count = $qb->getQuery()->getSingleScalarResult();
                $variantStats[$variant->getName()][$value->getValue()] = $count;
            }
        }
        
        
        // postprocess countries: sort descending by count and move "unknown" to the front
        uasort($countryStats, function($a, $b){ return $b['count'] - $a['count']; });
        if(isset($countryStats[0])) {
            $unknownData = $countryStats[0];
            unset($countryStats[0]);
            array_unshift($countryStats, $unknownData);
        }
        
        return new ViewModel(array(
           'stats_agegroupPrice' => $agegroupStatsPrice,
           'stats_agegroupTicket' => $agegroupStatsTicket,
           'stats_productType' => $productStats,
           'stats_variant' => $variantStats,
           'stats_country' => $countryStats,
        ));
    }
    
    public function bankaccountsAction() {
        $em = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        $activeStats = array();
        $matchingStats = array();
        
        $bankaccounts = $em->getRepository("ersEntity\Entity\BankAccount")
                ->findAll();
        
        /* @var $bankaccount \ersEntity\Entity\BankAccount */
        foreach($bankaccounts as $bankaccount) {
            $statementFormat = json_decode($bankaccount->getStatementFormat());
            
            $qb = $em->createQueryBuilder()
                    ->select('COUNT(s.id) AS stmtcount', 'SUM(col.value) AS amount, MAX(s.created) AS latestentry')
                    ->from('ersEntity\Entity\BankAccount', 'acc')
                    ->join('acc.bankStatements', 's', 'WITH', "s.status != 'disabled'")
                    ->join('s.bankStatementCols', 'col', 'WITH', 'col.column = :colNum')
                    ->where('acc.id = :accountId')
                    
                    ->setParameter('accountId', $bankaccount->getId())
                    ->setParameter('colNum', $statementFormat->amount);
            
            $activeStats[$bankaccount->getName()] = $qb
                    ->getQuery()->getSingleResult();
            
            // extend the query to only include matched statements
            $matchingStats[$bankaccount->getName()] = $qb
                    ->andWhere("s.status = 'matched'")
                    ->getQuery()->getSingleResult();
        }
        
        
        
        return new ViewModel(array(
            'activeStats' => $activeStats,
            'matchingStats' => $matchingStats,
        ));
    }
}