
{* set namespace *}
{namespace name="widgets/ost-store-stock/get-stock-table"}



{* our table *}
<table class="ost-store-stock--detail-tab--table">
    <thead>
    <tr>
        <td>Filiale</td>
        <td>Bestand</td>
        <td>Ausstellung</td>
    </tr>
    </thead>
    <tbody>

    {* every store *}
    {foreach $ostStoreStock.stores as $store}
        <tr>

            <td>
                {$store->getName()}
            </td>



            {* summed up stock *}
            {$inStock = 0}

            {* sum up *}
            {foreach $ostStoreStock.article->getAvailableStock() as $stock}
                {if $stock->getStore()->getKey() == $store->getKey()}
                    {$inStock = $stock->getQuantity()}
                {/if}
            {/foreach}

            <td>
                {$inStock}
            </td>



            {* in store? *}
            {$inStore = false}

            {* check every stock *}
            {foreach $ostStoreStock.article->getExhibits() as $exhibit}
                {if $exhibit->getKey() == $store->getKey()}
                    {$inStore = true}
                {/if}
            {/foreach}

            <td>
                {if $inStore == true}
                    <li class="icon--cd" style="color: #339900;"></li>
                {else}
                    <li class="icon--cd" style="color: #a12726;"></li>
                {/if}
            </td>

        </tr>
    {/foreach}

    </tbody>
</table>
