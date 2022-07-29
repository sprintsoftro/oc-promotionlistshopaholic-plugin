<?php

namespace Sprintsoft\PromotionsList\Controllers;

use Request;
use BackendMenu;
use Backend\Classes\Controller;
use Backend\Classes\BackendController;
use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Classes\Helper\CurrencyHelper;
use Lovata\Shopaholic\Models\Offer;

/**
 * Class Promotions
 * @package Lovata\Shopaholic\Controllers
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class Promotions extends Controller
{
    public $implement = [
        'Backend.Behaviors.ListController',
    ];

    public $listConfig = 'config_list.yaml';

    /**
     * Promotions constructor.
     */
    public function __construct()
    {
        CurrencyHelper::instance()->disableActiveCurrency();

        if (BackendController::$action == 'import') {
            Product::extend(function ($obModel) {
                $obModel->rules['external_id'] = 'required';
            });
        }

        parent::__construct();
        BackendMenu::setContext('Lovata.Shopaholic', 'shopaholic-menu-main', 'shopaholic-menu-promotions');
    }

    public function listExtendQuery($query, $definition = null)
    {
        $query->whereHas('offer', function($query) {
            $query->where('is_promotion', true);
        });        
    }

    public function onUpdate() 
    {
        $request = Request::all();

        if(!empty($request)) {
            $inputKey = key($request);
            $offer = Offer::find(key($request[$inputKey]));
            if($offer) 
            {
                $mainPrice = $offer->main_price;
                $mainPrice->$inputKey = reset($request[$inputKey]);
                $mainPrice->save();
                $offer->save();
            }
        }
    }
}
