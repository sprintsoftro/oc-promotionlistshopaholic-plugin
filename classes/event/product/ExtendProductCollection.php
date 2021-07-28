<?php namespace Sprintsoft\PromotionsList\Classes\Event\Product;

use DB;
use Lovata\Shopaholic\Models\Product;
use Sprintsoft\PromotionsList\Classes\Store\OfferListStore;
use Lovata\Shopaholic\Classes\Collection\ProductCollection;

/**
 * Class ExtendProductCollection
 * @package Sprintsoft\PromotionsList\Classes\Event\Product
 */
class ExtendProductCollection
{
    public function subscribe()
    {
        ProductCollection::extend(function ($obProductList) {
            $this->isOnPromotion($obProductList);
        });
    }

    /**
     * Add myCustomMethod method
     * @param ProductCollection $obProductList
     */
    protected function isOnPromotion($obList)
    {

        $obList->addDynamicMethod('isOnPromotion', function () use ($obList) {

            $arResultIDList = OfferListStore::instance()->is_promotion->get();

            return $obList->intersect($arResultIDList);
        });
    }
}
