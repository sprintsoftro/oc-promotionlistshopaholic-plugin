<?php namespace Sprintsoft\PromotionsList\Classes\Event\Offer;

use Sprintsoft\PromotionsList\Classes\Store\OfferListStore;
use Lovata\Shopaholic\Classes\Collection\OfferCollection;

/**
 * Class ExtendOfferCollection
 * @package Sprintsoft\PromotionsList\Classes\Event\Offer
 */
class ExtendOfferCollection
{
    public function subscribe()
    {
        OfferCollection::extend(function ($obOfferList) {
            $this->addCustomMethod($obOfferList);
        });
    }

    /**
     * Add getPromotions method
     * @param OfferCollection $obOfferList
     */
    protected function addCustomMethod($obOfferList)
    {
        $obOfferList->addDynamicMethod('getPromotions', function () use ($obOfferList) {

            $arResultIDList = OfferListStore::instance()->is_promotion->get();

            return $obOfferList->intersect($arResultIDList);
        });
    }
}
