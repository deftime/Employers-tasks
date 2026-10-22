{if !$product.company_id && $product.best_product_offer_id}{strip}
    {$image_panel_call_requests_product_id = $product.best_product_offer_id}

    {* Export *}
    {$image_panel_call_requests_product_id = $image_panel_call_requests_product_id scope=parent}
{/strip}{/if}