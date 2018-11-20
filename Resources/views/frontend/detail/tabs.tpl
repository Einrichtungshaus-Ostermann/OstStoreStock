
{* file to extend *}
{extends file="parent:frontend/detail/tabs.tpl"}

{* set namespace *}
{namespace name="frontend/ost-store-stock/detail/tabs"}



{* tab navigation *}
{block name="frontend_detail_tabs_description"}

    {* smarty parent *}
    {$smarty.block.parent}

    {* append our tab *}
    <a href="#" class="tab--link" title="Verfügbarkeit" data-tabName="ost-store-stock">Verfügbarkeit</a>

{/block}



{* tab content *}
{block name="frontend_detail_tabs_content_description"}

    {* smarty parent *}
    {$smarty.block.parent}

    {* our tab container *}
    <div class="tab--container">
        <div class="tab--header">
            <a href="#" class="tab--title" title="Verfügbarkeit">Verfügbarkeit</a>
        </div>
        <div class="tab--preview">
            Verfügbarkeit hier...
        </div>
        <div class="tab--content">
            {include file="frontend/detail/tabs/ost-store-stock.tpl"}
        </div>
    </div>

{/block}
