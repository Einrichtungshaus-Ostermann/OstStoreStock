<?php declare(strict_types=1);

/**
 * Einrichtungshaus Ostermann GmbH & Co. KG - Store Stock
 *
 * @package   OstStoreStock
 *
 * @author    Eike Brandt-Warneke <e.brandt-warneke@ostermann.de>
 * @copyright 2018 Einrichtungshaus Ostermann GmbH & Co. KG
 * @license   proprietary
 */

// namespace OstStoreStock\Controllers\Widgets;

use Enlight_Controller_Action;
use Shopware\Components\CSRFWhitelistAware;
use Exception;
use OstStoreStock\Services\ConfigurationServiceInterface;
use OstStoreStock\Services\StockService;
use OstStoreStock\Services\StoreService;
use OstErpApi\Struct\Store;
use OstErpApi\Struct\Article;


class Shopware_Controllers_Widgets_OstStoreStock extends Enlight_Controller_Action implements CSRFWhitelistAware
{
    /**
     * ...
     *
     * @return array
     */
    public function getWhitelistedCSRFActions()
    {
        // return all actions
        return array_values(array_filter(
            array_map(
                function ($method) { return (substr($method, -6) === 'Action') ? substr($method, 0, -6) : null; },
                get_class_methods($this)
            ),
            function ($method) { return  !in_array((string) $method, ['', 'index', 'load', 'extends'], true); }
        ));
    }


    /**
     * ...
     *
     * @throws Exception
     */
    public function preDispatch()
    {
        // ...
        $viewDir = $this->container->getParameter('ost_store_stock.view_dir');
        $this->get('template')->addTemplateDir($viewDir);
        parent::preDispatch();
    }


    /**
     * ...
     */
    public function getStockTableAction()
    {
        // article number
        $number = $this->Request()->getParam( "number" );

        // current shopware stock
        $currentStock = $this->Request()->getParam( "stock" );








        /* @var $storeService StoreService */
        $storeService = Shopware()->Container()->get( "ost_store_stock.store_service" );

        $stores = $storeService->get();





        $foundationConfiguration = Shopware()->Container()->get( "ost_foundation.configuration" );

        $company = (integer) $foundationConfiguration['company'];


        $arr = array();

        /* @var $store Store */
        foreach ( $stores as $store )
        {
            if ( $store->getCompany()->getKey() != $company )
                continue;

            if ( $store->getType() == Store::TYPE_ONLINE )
                continue;

            array_push( $arr, $store );

        }



        $stores = $arr;


        /* @var $stockService StockService */
        $stockService = Shopware()->Container()->get( "ost_store_stock.stock_service" );

        /* @var $article Article */
        $article = $stockService->get(
            $number
        );






        $liveStock = 0;


        foreach ( $stores as $store )
        {
            foreach ( $article->getAvailableStock() as $stock )
            {
                if ( ( $store->getType() == Store::TYPE_PHYSICAL ) and ( $store->getCompany()->getKey() == $company ) and ( $stock->getStore()->getKey() == $store->getKey() ))
                {
                    $liveStock += $stock->getQuantity();

                }
            }
        }




        if ( $currentStock != $liveStock )
        {
            $query = "
                UPDATE s_articles.......
            ";
        }




        $this->View()->assign( "ostStoreStock", array(
            'stores'  => $stores,
            'article' => $article
        ) );
    }
}
