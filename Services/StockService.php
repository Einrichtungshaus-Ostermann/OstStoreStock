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

namespace OstStoreStock\Services;

class StockService implements StockServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($number)
    {
        /* @var $api \OstErpApi\Api\Api */
        $api = Shopware()->Container()->get('ost_erp_api.api');

        // find via api
        $article = $api->findOneBy(
            'article',
            ['[article.number] = ' . $number]
        );

        // return the article
        return $article;
    }
}
