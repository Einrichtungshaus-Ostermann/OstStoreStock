
{* set namespace *}
{namespace name="frontend/ost-store-stock/detail/tabs/ost-store-stock"}



{* offcanvas button *}
<div class="buttons--off-canvas">
    <a href="#" title="{"{s name="OffcanvasCloseMenu" namespace="frontend/detail/description"}{/s}"|escape}" class="close--off-canvas">
        <i class="icon--arrow-left"></i>
        {s name="OffcanvasCloseMenu" namespace="frontend/detail/description"}{/s}
    </a>
</div>

{* actual content loaded via widget *}
<div class="content--description">
    {action module="widgets" controller="OstStoreStock" action="getStockTable" number="{$sArticle.ordernumber}" stock="{$sArticle.instock}"}
</div>
