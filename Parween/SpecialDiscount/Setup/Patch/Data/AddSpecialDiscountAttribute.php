<?php
namespace Parween\SpecialDiscount\Setup\Patch\Data;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Catalog\Api\ProductAttributeRepositoryInterface;
use Magento\Catalog\Model\Product\Attribute\Repository as ProductAttributeRepository;
use Magento\Eav\Setup\EavSetupFactory;

class AddSpecialDiscountAttribute implements DataPatchInterface
{
    private $eavSetupFactory;
    private $attributeRepository;

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        ProductAttributeRepositoryInterface $attributeRepository
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeRepository = $attributeRepository;
    }

    public function apply()
    {
        $eavSetup = $this->eavSetupFactory->create();

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'special_discount',
            [
                'type' => 'decimal',
                'backend' => '',
                'frontend' => '',
                'label' => 'Special Discount (%)',
                'input' => 'text',
                'class' => '',
                'source' => '',
                'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => '0',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'apply_to' => ''
            ]
        );
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}