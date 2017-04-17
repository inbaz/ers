<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-realentity) on 2016-01-07 08:26:28.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace ErsBase\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ErsBase\Entity\Order
 *
 * @ORM\Entity()
 * @ORM\Table(name="`order`", indexes={@ORM\Index(name="fk_Order_User1_idx", columns={"`buyer_id`"}), @ORM\Index(name="fk_order_payment_type1_idx", columns={"`payment_type_id`"}), @ORM\Index(name="fk_order_status1_idx", columns={"`status_id`"}), @ORM\Index(name="fk_order_code1_idx", columns={"`code_id`"}), @ORM\Index(name="fk_order_currency1_idx", columns={"`currency_id`"})})
 * @ORM\HasLifecycleCallbacks
 */
class Order extends Base\Order
{
    
    /**
     * define length of hashkey
     * 
     * @var length
     */
    private $length = 30;
    
    /*
     * package id
     */
    protected $package_id;
    
    public function __construct()
    {
        parent::__construct();
        $this->matches = new ArrayCollection();
        $this->packages = new ArrayCollection();
        $this->orderStatus = new ArrayCollection();
        
        $this->genHash();
        $code = new Code();
        $code->genCode();
        $this->setCode($code);
    }
    
    public function logInfo() {
        error_log('=== order info ===');
        foreach($this->getPackages() as $package) {
            error_log('--- ('.$package->getId().')'.$package->getParticipant().' ---');
            foreach($package->getItems() as $item) {
                if($item->hasParentItems()) {
                    continue;
                }
                error_log(' * '.$item);
            }
        }
        error_log('==================');
    }
    
    public function __toString() {
        $output = '';
        foreach($this->getPackages() as $package) {
            $output .= $package.PHP_EOL;
        }
        return $output;
    }

    /**
     * Generate hashkey
     */
    private function genHash() {
        $alphabet = "0123456789ACDFGHKMNPRUVWXY";
        $memory = '';
        $n = '';
        #srand(time());
        srand(rand()*time());
        for ($i = 0; $i < $this->length; $i++) {
            
            while($n == '' || $memory == $alphabet[$n]) {
                $n = rand(0, strlen($alphabet)-1);
            }
            $memory = $alphabet[$n];
            $code[$i] = $alphabet[$n];
        }
        
        $this->setHashkey(implode($code).$this->genChecksum(implode($code)));
    }
    
    /**
     * generate a two digits Checksum for a Code
     * 
     * @param type $code
     * @return type
     */
    private function genChecksum($code) {
        $chars = str_split($code);
        $nums = array();
        foreach($chars as $char) {
            $nums[] = ord($char);
        }
        $cross_sum = array_sum($nums);
        $checksum = $cross_sum % 100;
        return sprintf('%02d', $checksum);
    }
    
    /**
     * Check if hashkey checksum is valid
     * 
     * @return boolean
     */
    public function checkHashkey() {
        $checksum = substr($this->getHashkey(),$this->length);
        $code = substr($this->getHashkey(),0,$this->length);
        if($this->genChecksum($code) == $checksum) {
            return true;
        } else {
            return false;
        }
    }
    
    /*
     * DEPRECATED session id is not used anymore
     */
    /*public function getSessionId($part) {
        switch($part) {
            case 'package':
                $this->package_id++;
                return $this->package_id;
                #return \count($this->getPackages())+1;
            case 'item':
                $this->item_id++;
                return $this->item_id;
                #return \count($this->getItems())+1;
        }
    }*/

    public function setBuyer($buyer = null) {
        return $this->setUser($buyer);
    }
    
    public function getBuyer() {
        return $this->getUser();
    }
    
    /**
     * Get the value of order_sum.
     *
     * @return integer
     */
    public function getOrderSum()
    {
        if($this->order_sum == 0) {
            $this->order_sum = $this->getPrice();
        }
        return $this->order_sum;
    }

    /**
     * Get the value of total_sum.
     *
     * @return integer
     */
    public function getTotalSum()
    {
        if($this->total_sum == 0) {
            $this->total_sum = $this->getSum();
        }
        return $this->total_sum;
    }
    
    public function getOrderSumEur() {
        if($this->order_sum_eur == 0) {
            $this->order_sum_eur = $this->getPrice()*$this->getCurrency()->getFactor();
        }
        return $this->order_sum_eur;
    }

    public function getTotalSumEur()
    {
        if($this->total_sum_eur == 0) {
            $this->total_sum_eur = $this->getSum()*$this->getCurrency()->getFactor();
        }
        return $this->total_sum_eur;
    }
    
    /**
     * Not needed here anymore the method of the base entity is used instead
     * Add Package entity to collection (one to many).
     * 
     * This function is doing strange things. When it's removed doctrine throws 
     * a segmentation fault. Therefore this function does exactly the same as 
     * the one of the base class.
     *
     * @param \Entity\Package $package
     * @return \Entity\Order
     */
    public function addPackage(\ErsBase\Entity\Base\Package $package)
    {
        #$this->addPackage($package);
        $this->packages[] = $package;

        return $this;
    }

    /**
     * Get Package by id.
     * 
     * @return Entity\Package
     */
    
    public function getPackageByItemId($item_id) {
        foreach($this->getPackages() as $package) {
            foreach($package->getItems() as $item) {
                if($item->getId() == $item_id) {
                    return $package;
                }
            }
        }
        return false;
    }
    
    /**
     * Get Package by participant id.
     * 
     * @return Entity\Package
     */
    public function getPackageByParticipantId($id) {
        foreach($this->getPackages() as $package) {
            if($package->getParticipant()->getId() == $id) {
                return $package;
            }
        }
        return false;
    }
    
    /**
     * Get Package by participant email.
     * 
     * @return Entity\Package
     */
    public function getPackageByParticipantEmail($email) {
        foreach($this->getPackages() as $package) {
            $participant = $package->getParticipant();
            if($participant->getEmail() == $email) {
                return $package;
            }
        }
        return false;
    }
    
    /**
     * Add Item to the according package with the correct Buyer_id
     * 
     * @param \Entity\Item $item
     * @param integer $Participant_id
     * @return \Entity\Order
     */
    public function addItem(Item $item, $Participant_id)
    {
        $package = $this->getPackageByParticipantId($Participant_id);
        if($package) {
            $package->setOrder($this);
            $package->addItem($item);
        }
        
        return $this;
    }
    
    /**
     * get Item by participant_id and item_id
     * 
     * @param integer $participant_id
     * @param integer $item_id
     * 
     * @return \Entity\Item
     * @return false
     */
    public function getItem($item_id) {
        foreach($this->getPackages() as $package) {
            foreach($package->getItems() as $item) {
                if($item->getId() == $item_id) {
                    return $item;
                }
            }
        }
        return false;
    }
    
    public function findPackageByItem(Item $item) {
        foreach($this->getPackages() as $package) {
            if($package->existItem($item)) {
                return $package;
            }
        }
        return false;
    }
    
    /**
     * get Items of this order
     * 
     * @return ArrayCollection
     */
    public function getItems() {
        $items = new ArrayCollection();
        foreach($this->getPackages() as $package) {
            $items = new ArrayCollection(array_merge($items->toArray(), $package->getItems()->toArray()));
        }
        
        return $items;
    }
    
    public function getItemsByStatus($status) {
        $items = new ArrayCollection();
        foreach($this->getItems() as $item) {
            if($item->getStatus()->getValue() == $status) {
                $items[] = $item;
            }
        }
        return $items;
    }
    
    /**
     * remove Item by participant_id and item_id
     * 
     * @param integer $participant_id
     * @param integer $item_id
     * 
     * @return \Entity\Order
     */
    public function removeItemById($item_id) {
        $package = $this->getPackageByItemId($item_id);
        if($package) {
            $package->removeItemById($item_id);    
        }
        
        return $this;
    }

    /**
     * DEPRECATED: OrderStatus is not used anymore
     * get the last set OrderStatus
     * 
     * @return Entity\OrderStatus
     */
    /*public function getLastOrderStatus() {
        return array_pop($this->orderStatus);
    }*/
    
    /**
     * DEPRECATED: OrderStatus is not used anymore
     * find a status for this order
     * 
     * @param type $value
     * @return OrderStatus
     */
    /*public function findOrderStatus($value) {
        foreach($this->getOrderStatuses() as $status) {
            if($status->getValue() == $value) {
                return $status;
            }
        }
        return new OrderStatus();
    }*/
    
    /**
     * DEPRECATED: OrderStatus is not used anymore
     * check whether this order has this status or not
     * 
     * @param type $value
     * @return boolean
     */
    /*public function hasOrderStatus($value) {
        foreach($this->getOrderStatus() as $status) {
            if($status->getValue() == $value) {
                return true;
            }
        }
        return false;
    }*/

    /**
     * Get Participants of Packages
     * 
     * @return array
     */
    public function getParticipants() {
        $participants = array();
        if($this->getPackages()) {
            foreach($this->getPackages() as $package) {
                if($package->getParticipant()->getFirstname() != '' && $package->getParticipant()->getSurname() != '') {
                    $participants[] = $package->getParticipant();
                }
            }
        }
        
        
        return $participants;
    }
    
    /**
     * Get Participant by email
     * 
     * @return Entity\User
     * @return false
     */
    public function getParticipantByEmail($email) {
        foreach($this->getParticipants() as $participant) {
            if($participant->getEmail() == $email) {
                return $participant;
            }
        }
        return false;
    }
    
    /**
     * Get Participant by id
     * 
     * @return Entity\User
     * @return false
     */
    public function getParticipantById($id) {
        foreach($this->getParticipants() as $participant) {
            if($participant->getId() == $id) {
                return $participant;
            }
        }
        return false;
    }
    
    /**
     * Get Participant by item_id
     * 
     * @param type $item_id
     * @return boolean
     */
    public function getParticipantByItemId($item_id) {
        foreach($this->getPackages() as $package) {
            foreach($package->getItems() as $item) {
                if($item->getId() == $item_id) {
                    return $package->getParticipant();
                }
            }
        }
        return false;
    }
    
    /**
     * Get price of the complete order (excluding price fees)
     * 
     * @return float
     */
    public function getPrice($status=null) {
        $price = 0;
        foreach($this->getPackages() as $package) {
            foreach($package->getItems() as $item) {
                if($status == null) {
                    if($item->getStatus()->getValue() != 'cancelled' && $item->getStatus()->getValue() != 'transferred') {
                        $price += $item->getPrice();
                    }
                } else {
                    if($item->getStatus()->getValue() != $status) {
                        $price += $item->getPrice();
                    }
                }
            }
        }
        
        return $price;
    }
    
    /**
     * Get total sum of the order (including price fees)
     * 
     * @return float
     */
    public function getSum() {
        $sum = $this->getPrice();
        if($this->getPaymentType()) {
            $sum += $this->getPaymentType()->calcFee($sum);
        }
        return $sum;
    }
    
    public function getStatementAmount() {
        $statement_amount = 0;
        foreach($this->getMatches() as $match) {
            $statement = $match->getBankStatement();
            $statement_amount += $statement->getAmountValue();
        }
        return $statement_amount;
    }
    
    /**
     * get payment fees for this order
     * 
     * @return float
     */
    public function getPaymentFees($paymenttype=null) {
        if(!$paymenttype) {
            return $this->getPaymentType()->calcFee($this->getPrice());
        } else {
            return $paymenttype->calcFee($this->getPrice());
        }
        
    }
}
