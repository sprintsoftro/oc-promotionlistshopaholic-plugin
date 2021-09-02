<?php namespace Sprintsoft\PromotionsList;

use Event;
use System\Classes\PluginBase;
use Sprintsoft\PromotionsList\Classes\Event\Offer\ExtendOfferModel;
use Sprintsoft\PromotionsList\Classes\Event\Product\ExtendProductCollection;

class Plugin extends PluginBase
{
    public function boot()
    {
        Event::subscribe(ExtendOfferModel::class);
        Event::subscribe(ExtendProductCollection::class);
    }
}
