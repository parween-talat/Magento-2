<?php
namespace Parween\SpecialDiscount\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class ApplySpecialDiscount implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        $quoteItem = $observer->getEvent()->getQuoteItem();
        $product = $quoteItem->getProduct();

        $specialDiscount = $product->getData('special_discount');
        if ($specialDiscount) {
            $price = $quoteItem->getOriginalPrice();
            $discountedPrice = $price - ($price * ($specialDiscount / 100));
            $quoteItem->setCustomPrice($discountedPrice);
            $quoteItem->setOriginalCustomPrice($discountedPrice);
        }
    }
}