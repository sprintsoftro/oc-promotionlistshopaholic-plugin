<?php namespace Sprintsoft\PromotionsList\Classes\Store\Offer;

use Lovata\Shopaholic\Models\Offer;
use Lovata\Toolbox\Classes\Store\AbstractStoreWithoutParam;

/**
 * Class GetCustomList
 * @package Sprintsoft\PromotionsList\Classes\Store\Offer
 */
class GetCustomList extends AbstractStoreWithoutParam
{
    protected static $instance;

    /**
     * Get ID list from database
     * @return array
     */
    protected function getIDListFromDB() : array
    {
        $arElementIDList = (array) Offer::where('is_promotion', true)->lists('product_id');

        return $arElementIDList;
    }
}
