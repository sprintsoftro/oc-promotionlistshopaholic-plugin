<?php namespace Sprintsoft\PromotionsList\Classes\Event\Offer;

use Lovata\Toolbox\Classes\Event\ModelHandler;

use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Classes\Item\OfferItem;
use Sprintsoft\PromotionsList\Classes\Store\OfferListStore;
use Lovata\Shopaholic\Models\Price;

/**
 * Class ExtendOfferModel
 * @package Sprintsoft\PromotionsList\Classes\Event\Offer
 */
class ExtendOfferModel extends ModelHandler
{
    /** @var Offer */
     protected $obElement;

     /**
      * @param $obEvent
      */
     public function subscribe($obEvent)
     {
        parent::subscribe($obEvent);

        Offer::extend(function ($obOffer) {
            /** @var Offer $obOffer */
            $obOffer->fillable[] = 'is_promotion';

            $obOffer->addCachedField(['is_promotion']);



            $this->beforeSaveEvent($obOffer);
        });
    }

    /**
     * After save event handler
     */
    protected function afterSave()
    {
        $this->checkFieldChanges('is_promotion', OfferListStore::instance()->is_promotion);
    }

    protected function beforeSaveEvent($model)
    {
        $model->bindEvent('model.beforeSave', function () use ($model) {
            $obMainPrice  = $model->main_price;

            if(empty($obMainPrice)) {
                return;
            }
            $oldPrice = $obMainPrice->old_price_value;
            $price = $obMainPrice->price_value;

            if($oldPrice > $price){
                $model->is_promotion = true;
            } else {
                $model->is_promotion = false;
            }
        });
      }

    /**
     * After delete event handler
     */
    protected function afterDelete()
    {
        if ($this->obElement->is_promotion) {
            OfferListStore::instance()->is_promotion->clear();
        }
    }

    /**
     * Get model class
     * @return string
     */
    protected function getModelClass()
    {
        return Offer::class;
    }

    /**
     * Get item class
     * @return string
     */
    protected function getItemClass()
    {
        return OfferItem::class;
    }
}
