<?php declare(strict_types=1);

/*
 * Einrichtungshaus Ostermann GmbH & Co. KG - Store Stock
 *
 * @package   OstStoreStock
 *
 * @author    Eike Brandt-Warneke <e.brandt-warneke@ostermann.de>
 * @copyright 2018 Einrichtungshaus Ostermann GmbH & Co. KG
 * @license   proprietary
 */

use OstErpApi\Struct\Article;
use OstErpApi\Struct\Store;
use OstStoreStock\Services\StockService;
use OstStoreStock\Services\StoreService;
use Shopware\Components\CSRFWhitelistAware;

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
        $number = $this->Request()->getParam('number');

        // current shopware stock
        $currentStock = $this->Request()->getParam('stock');

        /* @var $storeService StoreService */
        $storeService = Shopware()->Container()->get('ost_store_stock.store_service');

        // get every store
        $stores = $storeService->get();

        // get company by foundation configuration
        $company = (int) Shopware()->Container()->get('ost_foundation.configuration')['company'];

        // every store for this context
        $arr = [];

        /* @var $store Store */
        foreach ($stores as $store) {

            // not this company?
            if ($store->getCompany()->getKey() !== $company) {
                // ignore
                continue;
            }

            // online shop?!
            if ($store->getType() === Store::TYPE_ONLINE) {
                // ignore
                continue;
            }

            // add it
            array_push($arr, $store);
        }

        // every store
        $stores = $arr;

        /* @var $stockService StockService */
        $stockService = Shopware()->Container()->get('ost_store_stock.stock_service');

        /* @var $article Article */
        $article = $stockService->get(
            $number
        );

        // calculate summed up live stock
        $liveStock = 0;

        // calculate by every available stock
        foreach ($stores as $store) {
            foreach ($article->getAvailableStock() as $stock) {
                if (($store->getType() === Store::TYPE_PHYSICAL) && ($store->getCompany()->getKey() === $company) && ($stock->getStore()->getKey() === $store->getKey())) {
                    $liveStock += $stock->getQuantity();
                }
            }
        }

        // different from our showare stock?!
        if ($currentStock !== $liveStock) {
            // update shopware data
            $query = '
                UPDATE s_articles.......
            ';
        }

        // all good
        $this->View()->assign('ostStoreStock', [
            'stores'  => $stores,
            'article' => $article
        ]);
    }
}
