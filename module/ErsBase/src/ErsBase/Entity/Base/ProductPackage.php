<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-mappedsuperclass) on 2017-02-17 06:31:38.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace ErsBase\Entity\Base;

use Doctrine\ORM\Mapping as ORM;

/**
 * ErsBase\Entity\Base\ProductPackage
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(name="`product_package`", indexes={@ORM\Index(name="fk_ProductPackage_Product1_idx", columns={"`Product_id`"}), @ORM\Index(name="fk_ProductPackage_Product2_idx", columns={"`SubProduct_id`"})})
 * @ORM\HasLifecycleCallbacks
 */
abstract class ProductPackage
{
    /**
     * @ORM\Id
     * @ORM\Column(name="`id`", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="`Product_id`", type="integer")
     */
    protected $Product_id;

    /**
     * @ORM\Column(name="`SubProduct_id`", type="integer")
     */
    protected $SubProduct_id;

    /**
     * @ORM\Column(name="`active`", type="boolean", nullable=true)
     */
    protected $active;

    /**
     * @ORM\Column(name="`amount`", type="integer", nullable=true)
     */
    protected $amount;

    /**
     * @ORM\Column(name="`updated`", type="datetime")
     */
    protected $updated;

    /**
     * @ORM\Column(name="`created`", type="datetime")
     */
    protected $created;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="productPackageRelatedByProductIds")
     * @ORM\JoinColumn(name="`Product_id`", referencedColumnName="`id`")
     */
    protected $productRelatedByProductId;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="productPackageRelatedBySubProductIds")
     * @ORM\JoinColumn(name="`SubProduct_id`", referencedColumnName="`id`")
     */
    protected $productRelatedBySubProductId;

    public function __construct()
    {
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
     * @return \ErsBase\Entity\Base\ProductPackage
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
     * Set the value of Product_id.
     *
     * @param integer $Product_id
     * @return \ErsBase\Entity\Base\ProductPackage
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
     * Set the value of SubProduct_id.
     *
     * @param integer $SubProduct_id
     * @return \ErsBase\Entity\Base\ProductPackage
     */
    public function setSubProductId($SubProduct_id)
    {
        $this->SubProduct_id = $SubProduct_id;

        return $this;
    }

    /**
     * Get the value of SubProduct_id.
     *
     * @return integer
     */
    public function getSubProductId()
    {
        return $this->SubProduct_id;
    }

    /**
     * Set the value of active.
     *
     * @param boolean $active
     * @return \ErsBase\Entity\Base\ProductPackage
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get the value of active.
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the value of amount.
     *
     * @param integer $amount
     * @return \ErsBase\Entity\Base\ProductPackage
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of amount.
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of updated.
     *
     * @param \DateTime $updated
     * @return \ErsBase\Entity\Base\ProductPackage
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
     * @return \ErsBase\Entity\Base\ProductPackage
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
     * Set Product entity related by `Product_id` (many to one).
     *
     * @param \ErsBase\Entity\Base\Product $product
     * @return \ErsBase\Entity\Base\ProductPackage
     */
    public function setProductRelatedByProductId(Product $product = null)
    {
        $this->productRelatedByProductId = $product;

        return $this;
    }

    /**
     * Get Product entity related by `Product_id` (many to one).
     *
     * @return \ErsBase\Entity\Base\Product
     */
    public function getProductRelatedByProductId()
    {
        return $this->productRelatedByProductId;
    }

    /**
     * Set Product entity related by `SubProduct_id` (many to one).
     *
     * @param \ErsBase\Entity\Base\Product $product
     * @return \ErsBase\Entity\Base\ProductPackage
     */
    public function setProductRelatedBySubProductId(Product $product = null)
    {
        $this->productRelatedBySubProductId = $product;

        return $this;
    }

    /**
     * Get Product entity related by `SubProduct_id` (many to one).
     *
     * @return \ErsBase\Entity\Base\Product
     */
    public function getProductRelatedBySubProductId()
    {
        return $this->productRelatedBySubProductId;
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
        $dataFields = array('id', 'Product_id', 'SubProduct_id', 'active', 'amount', 'updated', 'created');
        $relationFields = array('product', 'product');
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
        return array('id', 'Product_id', 'SubProduct_id', 'active', 'amount', 'updated', 'created');
    }
}