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

namespace OstStoreStock\Listeners\Controllers\Frontend;

use Enlight_Event_EventArgs as EventArgs;
use Shopware_Controllers_Frontend_Detail as Controller;
use OstStoreStock\Services\ConfigurationServiceInterface;
use OstStoreStock\Services\StockService;
use OstStoreStock\Services\StoreService;



class Detail
{

    /**
     * ...
     *
     * @var ConfigurationServiceInterface
     */

    protected $configurationService;



    /**
	 * ...
	 *
	 * @var string
	 */

	protected $viewDir;



    /**
	 * ...
	 *
     * @param ConfigurationServiceInterface    $configurationService
	 * @param string                  $viewDir
	 */

	public function __construct( ConfigurationServiceInterface $configurationService, $viewDir )
	{


		// set params
        $this->configurationService = $configurationService;
		$this->viewDir              = $viewDir;
	}


    /**
     * ...
     *
     * @param EventArgs   $arguments
     *
     * @return void
     */

    public function onPreDispatch( EventArgs $arguments )
    {
        // get the controller
        /* @var $controller Controller */
        $controller = $arguments->get( "subject" );

        // get parameters
        $request    = $controller->Request();
        $view       = $controller->View();






        // only order action
        if ( strtolower( $request->getActionName() ) != "index" )
            // nothing to do
            return;







        // assign configuration
        $view->assign( "ostStoreStockConfiguration", $this->configurationService->get() );

        // add template dir
        $view->addTemplateDir( $this->viewDir );
    }









    /**
     * ...
     *
     * @param EventArgs   $arguments
     *
     * @return void
     */

    public function onPostDispatch( EventArgs $arguments )
    {
        // get the controller
        /* @var $controller Controller */
        $controller = $arguments->get( "subject" );

        // get parameters
        $request    = $controller->Request();
        $view       = $controller->View();




        // only order action
        if ( strtolower( $request->getActionName() ) != "index" )
            // nothing to do
            return;






        $sArticle = $view->getAssign( "sArticle" );

        $number = $sArticle['ordernumber'];






        /* @var $storeService StoreService */
        $storeService = Shopware()->Container()->get( "ost_store_stock.store_service" );

        $stores = $storeService->get();




        /* @var $stockService StockService */
        $stockService = Shopware()->Container()->get( "ost_store_stock.stock_service" );

        $article = $stockService->get(
            $number
        );





        $view->assign( "ostStoreStock", array(
            'stores'  => $stores,
            'article' => $article
        ) );



    }

}
