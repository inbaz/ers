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
 * ErsBase\Entity\Item
 *
 * @ORM\Entity()
 * @ORM\Table(name="item", indexes={@ORM\Index(name="fk_Item_Product1_idx", columns={"Product_id"}), @ORM\Index(name="fk_Item_Package1_idx", columns={"Package_id"}), @ORM\Index(name="fk_item_item1_idx", columns={"transferred_item_id"}), @ORM\Index(name="fk_item_code1_idx", columns={"code_id"}), @ORM\Index(name="fk_item_status1_idx", columns={"status_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class Item extends Base\Item
{
    /**
     *
     * @var int
     * variable to keep an id which is only used while this entity is hold in 
     * a session container.
     */
    protected $session_id;
    
    public function __construct()
    {
        parent::__construct();
        $code = new Code();
        $code->genCode();
        $this->setCode($code);
        $this->setShipped(false);
    }

    /**
     * Set id of this object to null if it's cloned
     */
    public function __clone() {
        $this->id = null;
        
        $this->session_id = null;
        $this->itemPackageRelatedBySurItemIds = new ArrayCollection();
        $this->itemPackageRelatedBySubItemIds = new ArrayCollection();
        #$this->itemVariants = new ArrayCollection();
        
        $code = new Code();
        $code->genCode();
        $this->setCode($code);
        
        $this->setPackage(null);
        
        $itemVariants = new ArrayCollection();
        foreach($this->getItemVariants() as $variant) {
            $newVariant = clone $variant;
            $newVariant->setItem($this);
            $itemVariants[] = $newVariant;
        }
        $this->itemVariants = $itemVariants;
        
        /*$itemPackages = $this->getItemPackageRelatedBySurItemIds();
        $this->itemPackageRelatedBySubItemIds = new ArrayCollection();
        foreach($itemPackages as $package) {
            $newPackage = clone $package;
            $newPackage->setSurItem($this);
            #$itemPackageRelatedBySubItemIds[] = $newPackage;
            $this->addItemPackageRelatedBySurItemId($newPackage);
        }*/
        
        $this->created = null;
    }
    
    public function __toString() {
        $variants = '';
        foreach($this->getItemVariants() as $variant) {
            $variants .= $variant->getName().': '.$variant->getValue().'; ';
        }
        /* foreach($this->getChildItems() as $cItem) {
            error_log('  * '.$cItem);
        }*/
        return '('.$this->getId().')'.$this->getName().'('.$variants.')';
    }
    
    /**
     * Set the value of Package_id.
     *
     * @param integer $Package_id
     * @return \Entity\Item
     */
    public function setPackageId($Package_id)
    {
        $this->Package_id = $Package_id;
        foreach($this->getChildItems() as $cItem) {
            $cItem->setPackageId($Package_id);
        }

        return $this;
    }

    /**
     * Set the value of status.
     *
     * @param string $status
     * @return \Entity\Item
     */
    public function setStatus($status)
    {
        $this->status = $status;
        foreach($this->getChildItems() as $cItem) {
            $cItem->setStatus($status);
        }

        return $this;
    }
    
    /**
     * get SubItems
     * 
     * @return type
     */
    public function getSubItems() {
        $items = new ArrayCollection();
        foreach($this->getItemPackageRelatedBySurItemIds() as $itemPackage) {
            $items[] = $itemPackage->getSubItem();
        }
        return $items;
    }
    public function getChildItems() {
        return $this->getSubItems();
    }
    public function hasChildItems() {
        if(count($this->getSubItems()) > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * get SubItems
     * 
     * @return type
     */
    public function getSurItems() {
        $items = new ArrayCollection();
        foreach($this->getItemPackageRelatedBySubItemIds() as $itemPackage) {
            $items[] = $itemPackage->getSurItem();
        }
        return $items;
    }
    public function getParentItems() {
        return $this->getSurItems();
    }
    public function hasParentItems() {
        if(count($this->getSurItems()) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set Package entity (many to one).
     *
     * @param \Entity\Package $package
     * @return \Entity\Item
     */
    public function setPackage(Package $package = null)
    {
        $this->package = $package;
        foreach($this->getChildItems() as $cItem) {
            $cItem->setPackage($package);
            if($package) {
                $cItem->setPackageId($package->getId());
            } else {
                $cItem->setPackageId(null);
            }
        }

        return $this;
    }
    
    /**
     * Get Order in which this item is saved.
     * 
     */
    public function getOrder() {
        return $this->getPackage()->getOrder();
    }
    
    /**
     * extension to getItem
     */
    public function getTransferredItem() {
        return $this->getItem();
    }
    public function setTransferredItem($item) {
        $this->setItem($item);
        
        return $this;
    }
    
    public function getItemVariantByName($name) {
        foreach($this->getItemVariants() as $variant) {
            if($variant->getName() == $name) {
                return $variant;
            }
        }
        return false;
    }
    
    static public function variantCmp($a, $b) {
        if ($a->getProductVariant()->getPosition() == $b->getProductVariant()->getPosition()) {
            return 0;
        }
        return ($a->getProductVariant()->getPosition() < $b->getProductVariant()->getPosition()) ? -1 : 1;
    }
}
