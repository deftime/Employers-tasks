{if $addons.master_products.allow_buy_default_common_product === "YesNo::YES"|enum
    && $product.master_product_id === "0"
    && $product.master_product_offers_count
    && !$product.company_id
    && $product.best_product_offer_id
}{strip}
    {if !isset($add_to_cart_stepper_cart_product_ids)}
        {$add_to_cart_stepper_cart_product_ids = []}
    {/if}
    {foreach $product.variation_features_variants as $product_variation_features_variants_item}
        {if
            $product_variation_features_variants_item.purpose === ("\Tygh\Addons\ProductVariations\Product\FeaturePurposes::CREATE_VARIATION_OF_CATALOG_ITEM"|constant)
            && isset($product_variation_features_variants_item.variants)
        }
            {foreach $product_variation_features_variants_item.variants as $variant_item}
                {if $variant_item.product_id}
                    {foreach $product.vendor_product_ids[($variant_item.product_id|intval)] as $vendor_product_id}
                        {$add_to_cart_stepper_cart_product_ids[$vendor_product_id] = $vendor_product_id}
                    {/foreach}
                {/if}
            {/foreach}
        {/if}
    {/foreach}

    {foreach $cart_products_for_add_to_cart_stepper as $key => $cart_product_inner}
        {if $cart_product_inner.product_id === $product.best_product_offer_id}
            {$add_to_cart_stepper_cart_product_ids[$product.best_product_offer_id] = $product.best_product_offer_id}
        {/if}
    {/foreach}

    {if $add_to_cart_stepper_cart_product_ids|@count > 0}
        {$add_to_cart_stepper_cart_aggregate = true}
    {/if}

    {* Export *}
    {$add_to_cart_stepper_cart_product_ids = $add_to_cart_stepper_cart_product_ids scope=parent}
    {if $add_to_cart_stepper_cart_product_ids|@count > 0}
        {$add_to_cart_stepper_cart_aggregate = $add_to_cart_stepper_cart_aggregate scope=parent}
    {/if}
{/strip}{/if}