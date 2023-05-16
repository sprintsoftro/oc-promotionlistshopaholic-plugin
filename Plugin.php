<?php namespace Sprintsoft\PromotionsList;

use Event;
use Sprintsoft\PromotionsList\Classes\Event\Offer\ExtendOfferFieldsHandler;
use System\Classes\PluginBase;
use Sprintsoft\PromotionsList\Classes\Event\Offer\ExtendOfferModel;
use Sprintsoft\PromotionsList\Classes\Event\Product\ExtendProductCollection;
use Sprintsoft\PromotionsList\Classes\Event\Product\ProductModelHandler;

class Plugin extends PluginBase
{
    public function boot()
    {
        Event::subscribe(ExtendOfferModel::class);
        Event::subscribe(ExtendProductCollection::class);
        Event::subscribe(ProductModelHandler::class);
        Event::subscribe(ExtendOfferFieldsHandler::class);

        $this->productConfiguratorSubscribe();
    }

    public function productConfiguratorSubscribe()
    {
        Event::listen('backend.menu.extendItems', function ($manager) {
            // Add side menu item                
            $manager->addSideMenuItems('Lovata.Shopaholic', 'shopaholic-menu-main', [
                'shopaholic-menu-promotions' => [
                    'label' => 'Lista Promotii',
                    'url' => '/backend/sprintsoft/promotionslist/promotions',
                    'icon' => 'icon-book',
                    'order' => 300,
                ]
            ]);
        });
    }

    public function registerListColumnTypes()
    {
        return [
            'input' => function ($value, $data) {
                return '<input class="form-control" type="number" name="'.$data->columnName.'['.$value['offer_id'].']" value="'.$value['value'].'" step="any">';
            }
        ];
    }
}
