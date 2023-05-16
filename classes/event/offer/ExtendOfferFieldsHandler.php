<?php namespace Sprintsoft\PromotionsList\Classes\Event\Offer;

use Lovata\Toolbox\Classes\Event\AbstractBackendFieldHandler;

use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Controllers\Offers;

/**
 * Class ExtendOfferFieldsHandler
 * @package Sprintsoft\PromotionsList\Classes\Event\Offer
 */
class ExtendOfferFieldsHandler extends AbstractBackendFieldHandler
{
    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        parent::subscribe($obEvent);

        Offers::extend(function($obController) use ($obEvent) {
            /** @var Offers $obController */
            $this->extendImportColumns($obController);
        });
    }

    /**
     * Extend field
     * @param \Backend\Widgets\Form $obWidget
     */
    protected function extendFields($obWidget)
    {
        $arAdditionFields = [
            'is_promotion' => [
                'label'   => 'Promotie',
                'tab'     => 'lovata.shopaholic::lang.tab.price',
                'type'    => 'switch',
                'comment' => 'Afiseaza ca si promotie si in lista de promotii'
            ]
        ];

        $obWidget->addTabFields($arAdditionFields);
    }

        /**
     * Extends Shopaholic Offers import config_import_export.yaml
     */
    protected function extendImportColumns($obController)
    {
        if (is_array($obController->importExportConfig)) {
            $arConfig = $obController->importExportConfig;
        } else {
            $arConfig = (array)$obController->makeConfig('$/lovata/shopaholic/controllers/offers/' . $obController->importExportConfig);
        }

        $newConfig['is_promotion'] = ['label' => 'Is Promotion'];

        $arFiledList = (array) array_get($arConfig, 'import.list.columns');
        $arFiledList = array_merge($arFiledList, $newConfig);

        array_set($arConfig, 'import.list.columns', $arFiledList);
        $obController->importExportConfig = $arConfig;
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass() : string
    {
        return Offer::class;
    }

    /**
     * Get controller class name
     * @return string
     */
    protected function getControllerClass() : string
    {
        return Offers::class;
    }
}