<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-realentity) on 2016-01-07 08:26:28.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace ErsBase\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ErsBase\Entity\ItemVariant
 *
 * @ORM\Entity()
 * @ORM\Table(name="item_variant", indexes={@ORM\Index(name="fk_ItemVariant_Item1_idx", columns={"Item_id"}), @ORM\Index(name="fk_item_variant_product_variant1_idx", columns={"product_variant_id"}), @ORM\Index(name="fk_item_variant_product_variant_value1_idx", columns={"product_variant_value_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class ItemVariant extends Base\ItemVariant
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * populate entity from base entities
     * 
     * @param \ErsBase\Entity\ProductVariant $variant
     * @param \ErsBase\Entity\ProductVariantValue $value
     * @return \ErsBase\Entity\ItemVariant
     */
    public function populateFromEntity(ProductVariant $variant, ProductVariantValue $value) {
        $this->setName($variant->getName());
        $this->setProductVariantId($variant->getId());
        
        $this->setValue($value->getValue());
        $this->setProductVariantValueId($value->getId());
        
        return $this;
    }
}
