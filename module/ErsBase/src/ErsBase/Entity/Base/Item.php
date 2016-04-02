<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-mappedsuperclass) on 2016-03-19 10:02:20.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace ErsBase\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ErsBase\Entity\Base\Item
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(name="item", indexes={@ORM\Index(name="fk_Item_Product1_idx", columns={"Product_id"}), @ORM\Index(name="fk_Item_Package1_idx", columns={"Package_id"}), @ORM\Index(name="fk_item_item1_idx", columns={"transferred_item_id"}), @ORM\Index(name="fk_item_code1_idx", columns={"code_id"}), @ORM\Index(name="fk_item_status1_idx", columns={"status_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $status_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $code_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $Product_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $Package_id;

    /**
     * @ORM\Column(name="`name`", type="string", length=45, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    protected $short_description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $long_description;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $price;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $amount;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $info;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $personalized;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $agegroup;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $shipped;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $transferred_item_id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\OneToMany(targetEntity="ItemPackage", mappedBy="itemRelatedBySubitemId", cascade={"persist", "merge", "remove"})
     * @ORM\JoinColumn(name="id", referencedColumnName="Subitem_id", onDelete="CASCADE")
     */
    protected $itemPackageRelatedBySubitemIds;

    /**
     * @ORM\OneToMany(targetEntity="ItemPackage", mappedBy="itemRelatedBySuritemId", cascade={"persist", "merge", "remove"})
     * @ORM\JoinColumn(name="id", referencedColumnName="Suritem_id", onDelete="CASCADE")
     */
    protected $itemPackageRelatedBySuritemIds;

    /**
     * @ORM\OneToMany(targetEntity="ItemVariant", mappedBy="item", cascade={"persist", "merge", "remove"})
     * @ORM\JoinColumn(name="id", referencedColumnName="Item_id", onDelete="CASCADE")
     */
    protected $itemVariants;

    /**
     * @ORM\OneToMany(targetEntity="Log", mappedBy="item")
     * @ORM\JoinColumn(name="id", referencedColumnName="item_id")
     */
    protected $logs;

    /**
     * @ORM\ManyToOne(targetEntity="Status", inversedBy="items", cascade={"persist", "merge"})
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    protected $status;

    /**
     * @ORM\ManyToOne(targetEntity="Code", inversedBy="items", cascade={"persist", "merge"})
     * @ORM\JoinColumn(name="code_id", referencedColumnName="id")
     */
    protected $code;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="items")
     * @ORM\JoinColumn(name="Product_id", referencedColumnName="id", nullable=true)
     */
    protected $product;

    /**
     * @ORM\ManyToOne(targetEntity="Package", inversedBy="items", cascade={"persist", "merge"})
     * @ORM\JoinColumn(name="Package_id", referencedColumnName="id")
     */
    protected $package;

    /**
     * @ORM\OneToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="transferred_item_id", referencedColumnName="id", nullable=true)
     */
    protected $item;

    public function __construct()
    {
        $this->itemPackageRelatedBySubitemIds = new ArrayCollection();
        $this->itemPackageRelatedBySuritemIds = new ArrayCollection();
        $this->itemVariants = new ArrayCollection();
        $this->logs = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function PrePersist()
    {
        if(!isset($this->created)) {
            $this->created = new \DateTime();
        }
        $this->updated = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function PreUpdate()
    {
        $this->updated = new \DateTime();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \ErsBase\Entity\Base\Item
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of status_id.
     *
     * @param integer $status_id
     * @return \ErsBase\Entity\Base\Item
     */
    public function setStatusId($status_id)
    {
        $this->status_id = $status_id;

        return $this;
    }

    /**
     * Get the value of status_id.
     *
     * @return integer
     */
    public function getStatusId()
    {
        return $this->status_id;
    }

    /**
     * Set the value of code_id.
     *
     * @param integer $code_id
     * @return \ErsBase\Entity\Base\Item
     */
    public function setCodeId($code_id)
    {
        $this->code_id = $code_id;

        return $this;
    }

    /**
     * Get the value of code_id.
     *
     * @return integer
     */
    public function getCodeId()
    {
        return $this->code_id;
    }

    /**
     * Set the value of Product_id.
     *
     * @param integer $Product_id
     * @return \ErsBase\Entity\Base\Item
     */
    public function setProductId($Product_id)
    {
        $this->Product_id = $Product_id;

        return $this;
    }

    /**
     * Get the value of Product_id.
     *
     * @return integer
     */
    public function getProductId()
    {
        return $this->Product_id;
    }

    /**
     * Set the value of Package_id.
     *
     * @param integer $Package_id
     * @return \ErsBase\Entity\Base\Item
     */
    public function setPackageId($Package_id)
    {
        $this->Package_id = $Package_id;

        return $this;
    }

    /**
     * Get the value of Package_id.
     *
     * @return integer
     */
    public function getPackageId()
    {
        return $this->Package_id;
    }

    /**
     * Set the value of name.
     *
     * @param string $name
     * @return \ErsBase\Entity\Base\Item
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of short_description.
     *
     * @param string $short_description
     * @return \ErsBase\Entity\Base\Item
     */
    public function setShortDescription($short_description)
    {
        $this->short_description = $short_description;

        return $this;
    }

    /**
     * Get the value of short_description.
     *
     * @return string
     */
    public function getShortDescription()
    {
        return $this->short_description;
    }

    /**
     * Set the value of long_description.
     *
     * @param string $long_description
     * @return \ErsBase\Entity\Base\Item
     */
    public function setLongDescription($long_description)
    {
        $this->long_description = $long_description;

        return $this;
    }

    /**
     * Get the value of long_description.
     *
     * @return string
     */
    public function getLongDescription()
    {
        return $this->long_description;
    }

    /**
     * Set the value of price.
     *
     * @param string $price
     * @return \ErsBase\Entity\Base\Item
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of price.
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of amount.
     *
     * @param string $amount
     * @return \ErsBase\Entity\Base\Item
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of amount.
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of info.
     *
     * @param string $info
     * @return \ErsBase\Entity\Base\Item
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get the value of info.
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set the value of personalized.
     *
     * @param boolean $personalized
     * @return \ErsBase\Entity\Base\Item
     */
    public function setPersonalized($personalized)
    {
        $this->personalized = $personalized;

        return $this;
    }

    /**
     * Get the value of personalized.
     *
     * @return boolean
     */
    public function getPersonalized()
    {
        return $this->personalized;
    }

    /**
     * Set the value of agegroup.
     *
     * @param \DateTime $agegroup
     * @return \ErsBase\Entity\Base\Item
     */
    public function setAgegroup($agegroup)
    {
        $this->agegroup = $agegroup;

        return $this;
    }

    /**
     * Get the value of agegroup.
     *
     * @return \DateTime
     */
    public function getAgegroup()
    {
        return $this->agegroup;
    }

    /**
     * Set the value of shipped.
     *
     * @param string $shipped
     * @return \ErsBase\Entity\Base\Item
     */
    public function setShipped($shipped)
    {
        $this->shipped = $shipped;

        return $this;
    }

    /**
     * Get the value of shipped.
     *
     * @return string
     */
    public function getShipped()
    {
        return $this->shipped;
    }

    /**
     * Set the value of transferred_item_id.
     *
     * @param integer $transferred_item_id
     * @return \ErsBase\Entity\Base\Item
     */
    public function setTransferredItemId($transferred_item_id)
    {
        $this->transferred_item_id = $transferred_item_id;

        return $this;
    }

    /**
     * Get the value of transferred_item_id.
     *
     * @return integer
     */
    public function getTransferredItemId()
    {
        return $this->transferred_item_id;
    }

    /**
     * Set the value of updated.
     *
     * @param \DateTime $updated
     * @return \ErsBase\Entity\Base\Item
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get the value of updated.
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set the value of created.
     *
     * @param \DateTime $created
     * @return \ErsBase\Entity\Base\Item
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get the value of created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Add ItemPackage entity related by `Subitem_id` to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\ItemPackage $itemPackage
     * @return \ErsBase\Entity\Base\Item
     */
    public function addItemPackageRelatedBySubitemId(ItemPackage $itemPackage)
    {
        $this->itemPackageRelatedBySubitemIds[] = $itemPackage;

        return $this;
    }

    /**
     * Remove ItemPackage entity related by `Subitem_id` from collection (one to many).
     *
     * @param \ErsBase\Entity\Base\ItemPackage $itemPackage
     * @return \ErsBase\Entity\Base\Item
     */
    public function removeItemPackageRelatedBySubitemId(ItemPackage $itemPackage)
    {
        $this->itemPackageRelatedBySubitemIds->removeElement($itemPackage);

        return $this;
    }

    /**
     * Get ItemPackage entity related by `Subitem_id` collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItemPackageRelatedBySubitemIds()
    {
        return $this->itemPackageRelatedBySubitemIds;
    }

    /**
     * Add ItemPackage entity related by `Suritem_id` to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\ItemPackage $itemPackage
     * @return \ErsBase\Entity\Base\Item
     */
    public function addItemPackageRelatedBySuritemId(ItemPackage $itemPackage)
    {
        $this->itemPackageRelatedBySuritemIds[] = $itemPackage;

        return $this;
    }

    /**
     * Remove ItemPackage entity related by `Suritem_id` from collection (one to many).
     *
     * @param \ErsBase\Entity\Base\ItemPackage $itemPackage
     * @return \ErsBase\Entity\Base\Item
     */
    public function removeItemPackageRelatedBySuritemId(ItemPackage $itemPackage)
    {
        $this->itemPackageRelatedBySuritemIds->removeElement($itemPackage);

        return $this;
    }

    /**
     * Get ItemPackage entity related by `Suritem_id` collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItemPackageRelatedBySuritemIds()
    {
        return $this->itemPackageRelatedBySuritemIds;
    }

    /**
     * Add ItemVariant entity to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\ItemVariant $itemVariant
     * @return \ErsBase\Entity\Base\Item
     */
    public function addItemVariant(ItemVariant $itemVariant)
    {
        $this->itemVariants[] = $itemVariant;

        return $this;
    }

    /**
     * Remove ItemVariant entity from collection (one to many).
     *
     * @param \ErsBase\Entity\Base\ItemVariant $itemVariant
     * @return \ErsBase\Entity\Base\Item
     */
    public function removeItemVariant(ItemVariant $itemVariant)
    {
        $this->itemVariants->removeElement($itemVariant);

        return $this;
    }

    /**
     * Get ItemVariant entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItemVariants()
    {
        return $this->itemVariants;
    }

    /**
     * Add Log entity to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\Log $log
     * @return \ErsBase\Entity\Base\Item
     */
    public function addLog(Log $log)
    {
        $this->logs[] = $log;

        return $this;
    }

    /**
     * Remove Log entity from collection (one to many).
     *
     * @param \ErsBase\Entity\Base\Log $log
     * @return \ErsBase\Entity\Base\Item
     */
    public function removeLog(Log $log)
    {
        $this->logs->removeElement($log);

        return $this;
    }

    /**
     * Get Log entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * Set Status entity (many to one).
     *
     * @param \ErsBase\Entity\Base\Status $status
     * @return \ErsBase\Entity\Base\Item
     */
    public function setStatus(Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get Status entity (many to one).
     *
     * @return \ErsBase\Entity\Base\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set Code entity (many to one).
     *
     * @param \ErsBase\Entity\Base\Code $code
     * @return \ErsBase\Entity\Base\Item
     */
    public function setCode(Code $code = null)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get Code entity (many to one).
     *
     * @return \ErsBase\Entity\Base\Code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set Product entity (many to one).
     *
     * @param \ErsBase\Entity\Base\Product $product
     * @return \ErsBase\Entity\Base\Item
     */
    public function setProduct(Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get Product entity (many to one).
     *
     * @return \ErsBase\Entity\Base\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set Package entity (many to one).
     *
     * @param \ErsBase\Entity\Base\Package $package
     * @return \ErsBase\Entity\Base\Item
     */
    public function setPackage(Package $package = null)
    {
        $this->package = $package;

        return $this;
    }

    /**
     * Get Package entity (many to one).
     *
     * @return \ErsBase\Entity\Base\Package
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * Set Item entity (one to one).
     *
     * @param \ErsBase\Entity\Base\Item $item
     * @return \ErsBase\Entity\Base\Item
     */
    public function setItem(Item $item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get Item entity (one to one).
     *
     * @return \ErsBase\Entity\Base\Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Populate entity with the given data.
     * The set* method will be used to set the data.
     *
     * @param array $data
     * @return boolean
     */
    public function populate(array $data = array())
    {
        foreach ($data as $field => $value) {
            $setter = sprintf('set%s', ucfirst(
                str_replace(' ', '', ucwords(str_replace('_', ' ', $field)))
            ));
            if (method_exists($this, $setter)) {
                $this->{$setter}($value);
            }
        }

        return true;
    }

    /**
     * Return a array with all fields and data.
     * Default the relations will be ignored.
     * 
     * @param array $fields
     * @return array
     */
    public function getArrayCopy(array $fields = array())
    {
        $dataFields = array('id', 'status_id', 'code_id', 'Product_id', 'Package_id', 'name', 'short_description', 'long_description', 'price', 'amount', 'info', 'personalized', 'agegroup', 'shipped', 'transferred_item_id', 'updated', 'created');
        $relationFields = array('product', 'package', 'item', 'code', 'status');
        $copiedFields = array();
        foreach ($relationFields as $relationField) {
            $map = null;
            if (array_key_exists($relationField, $fields)) {
                $map = $fields[$relationField];
                $fields[] = $relationField;
                unset($fields[$relationField]);
            }
            if (!in_array($relationField, $fields)) {
                continue;
            }
            $getter = sprintf('get%s', ucfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $relationField)))));
            $relationEntity = $this->{$getter}();
            $copiedFields[$relationField] = (!is_null($map))
                ? $relationEntity->getArrayCopy($map)
                : $relationEntity->getArrayCopy();
            $fields = array_diff($fields, array($relationField));
        }
        foreach ($dataFields as $dataField) {
            if (!in_array($dataField, $fields) && !empty($fields)) {
                continue;
            }
            $getter = sprintf('get%s', ucfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $dataField)))));
            $copiedFields[$dataField] = $this->{$getter}();
        }

        return $copiedFields;
    }

    public function __sleep()
    {
        return array('id', 'status_id', 'code_id', 'Product_id', 'Package_id', 'name', 'short_description', 'long_description', 'price', 'amount', 'info', 'personalized', 'agegroup', 'shipped', 'transferred_item_id', 'updated', 'created');
    }
}