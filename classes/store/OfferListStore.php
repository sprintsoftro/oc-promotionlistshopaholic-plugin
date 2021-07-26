<?php namespace Sprintsoft\PromotionsList\Classes\Store;

use Lovata\Toolbox\Classes\Store\AbstractListStore;

use Sprintsoft\PromotionsList\Classes\Store\Offer\GetCustomList;

/**
 * Class OfferListStore
 * @package Sprintsoft\PromotionsList\Classes\Store
 * @property GetCustomList $is_promotion
 */
class OfferListStore extends AbstractListStore
{
    protected static $instance;

    /**
     * Init store method
     */
    protected function init()
    {
        $this->addToStoreList('is_promotion', GetCustomList::class);
    }
}
