{if !$product.company_id && $product.best_product_offer_id}
    {hook name="products:add_to_cart"}
        {* Based on addons/product_variations/hooks/products/add_to_cart.override.tpl *}
        {$show_select_variations_button=$show_select_variations_button|default:true}
        {if !$details_page && $product.has_child_variations && $show_select_variations_button}

            {include file="addons/product_variations/components/products_add_to_cart_pre.tpl"}

            {$show_select_variation = $show_select_variation|default:true}
            {$select_variation_but_text = $select_variation_but_text|default:__("product_variations.select_variation")}

            {if $show_select_variation}
                {include file="buttons/button.tpl"
                    but_id="button_cart_`$obj_prefix``$obj_id`"
                    but_text=$select_variation_but_text
                    but_name=""
                    but_href="{"products.view?product_id=`$product.product_id`"|fn_url}"
                    but_role=$opt_but_role
                    but_meta="ty-btn__primary ty-btn__big"
                    but_icon=$select_variation_but_icon
                }
            {/if}
        {elseif $product.has_options && !$show_product_options && !$details_page}
            {if $show_quick_view_for_options}
                {include file="views/products/components/quick_view_for_options_link.tpl"
                    quick_nav_ids=false
                    quick_view_icon=$add_to_cart_icon
                    quick_view_text=$add_to_cart_text
                    quick_view_for_options_link_class=$quick_view_for_options_link_class
                    add_to_cart_stepper_type="quick_view_for_options_link"
                }
            {else}
                {if $but_role == "text"}
                    {$opt_but_role="text"}
                {else}
                    {$opt_but_role="action"}
                {/if}

                {include file="buttons/button.tpl" but_id="button_cart_`$obj_prefix``$obj_id`" but_text=$select_options_text but_href="products.view?product_id=`$product.product_id`" but_role=$opt_but_role but_name="" but_meta="ty-btn__primary ty-btn__big" but_icon=$add_to_cart_icon}
            {/if}
        {else}
            {hook name="products:add_to_cart_but_id"}
                {$_but_id="button_cart_`$obj_prefix``$obj_id`"}
            {/hook}

            {if $extra_button}{$extra_button nofilter}&nbsp;{/if}

            {include file="buttons/add_to_cart.tpl" but_id=$_but_id but_name="dispatch[checkout.add..`$obj_id`]" but_role=$add_to_cart_role block_width=$block_width obj_id=$obj_id product=$product but_meta=$add_to_cart_meta but_text=$add_to_cart_text but_icon=$add_to_cart_icon}

            {capture name="add_to_cart_button_secondary_temp_`$obj_id`" assign="add_to_cart_button_secondary_temp_`$obj_id`"}
                <div class="cm-reload-{$obj_prefix}{$obj_id}" id="add_to_cart_update_secondary_{$obj_prefix}{$obj_id}">
                    {include file="buttons/add_to_cart.tpl"
                        but_id="`$_but_id`_secondary"
                        but_name="dispatch[checkout.add..`$obj_id`]"
                        but_role=$but_role
                        block_width=$block_width
                        obj_id=$obj_id
                        product=$product
                        add_to_cart_meta="`$add_to_cart_meta` ty-btn__add-to-cart--secondary"
                        but_text=__("add_to_cart_short")
                    }
                <!--add_to_cart_update_secondary_{$obj_prefix}{$obj_id}--></div>
            {/capture}
            {* Unset temp capture *}
            {capture name="add_to_cart_button_secondary_temp_`$obj_id`"}{/capture}

            {* Export *}
            {$add_to_cart_button_secondary_temp_override_{$obj_id} = $add_to_cart_button_secondary_temp_{$obj_id} scope=parent}
            {$obj_id_override = $obj_id scope=parent}
            {* /Export *}

            {assign var="cart_button_exists" value=true}
        {/if}

        {if $product.best_product_offer_id}
            <input type="hidden" name="product_data[{$product.product_id}][product_id]" value="{$product.best_product_offer_id}" />
        {/if}
    {/hook}
{/if}