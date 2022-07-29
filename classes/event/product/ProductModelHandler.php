<?php namespace SprintSoft\PromotionsList\Classes\Event\Product;

use Lovata\Toolbox\Classes\Event\ModelHandler;
use Lovata\Shopaholic\Models\Product;
use SprintSoft\PromotionsList\Classes\Item\ProductItem;
use Lovata\Toolbox\Classes\Helper\PriceHelper;

/**
 * Class ProductModelHandler
 * @package SprintSoft\PromotionsList\Classes\Event\Product
 */
class ProductModelHandler extends ModelHandler
{
    /** @var Product */
    protected $obElement;

    public function subscribe($obEvent)
    {
        parent::subscribe($obEvent);

        $this->addNewMethods();
    }

    protected function addNewMethods()
    {
        Product::extend(function ($obProduct) {
            $obProduct->addDynamicMethod('getPriceAttribute', function () use ($obProduct) {
                /** @var Product $obProduct */
                if ($obProduct->offer->isNotEmpty()) {
                    return [
                        'offer_id' => $obProduct->offer[0]->id,
                        'value' => PriceHelper::format($obProduct->offer[0]->price_value)
                    ];
                }
                return null;
            });
            $obProduct->addDynamicMethod('getOldPriceAttribute', function () use ($obProduct) {
                /** @var Product $obProduct */
                if ($obProduct->offer->isNotEmpty()) {
                    return [
                        'offer_id' => $obProduct->offer[0]->id,
                        'value' => PriceHelper::format($obProduct->offer[0]->old_price_value)
                    ];
                }
                return null;
            });
        });
    }
    
    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass()
    {
        return Product::class;
    }

    /**
     * Get item class name
     * @return string
     */
    protected function getItemClass()
    {
        return ProductItem::class;
    }
    
}
