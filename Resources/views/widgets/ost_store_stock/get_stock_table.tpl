

{* set namespace *}
{namespace name="widgets/ost-store-stock/get-stock-table"}






    <style>

        table {
            width: 100%;
        }

        table tr td {
            width: 50%;
        }

        table tr td:nth-child(2), table tr td:nth-child(3) {
            width: 25%;
        }

        table tbody tr td:nth-child(1) {
            text-align: left;
        }

        table tbody tr td:nth-child(2), table tbody tr td:nth-child(3) {
            text-align: center;
        }

    </style>

    <table>
        <thead>
        <tr>
            <td>Filiale</td>
            <td>Bestand</td>
            <td>Ausstellung</td>
        </tr>
        </thead>
        <tbody>






    {foreach $ostStoreStock.stores as $store}
    <tr>

        <td>

            {*
        {$store->getName()} ({$store->getCity()})
*}

            {$store->getName()}

        </td>








        {$inStock = 0}


        {foreach $ostStoreStock.article->getAvailableStock() as $stock}

            {if $stock->getStore()->getKey() == $store->getKey()}

                {$inStock = $stock->getQuantity()}

            {/if}


        {/foreach}
        <td>
            {$inStock}
        </td>







        {$inStore = false}


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



