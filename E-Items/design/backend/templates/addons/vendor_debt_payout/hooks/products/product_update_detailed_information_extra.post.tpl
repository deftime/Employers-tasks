{if $product_data.product_type === "Addons\\VendorDebtPayout\\ProductTypes::DEBT_PAYOUT"|enum}
    <div class="control-group">
        <label class="control-label">{__("vendor_debt_payout.vendor_taxes")}:</label>
        <div class="controls">
            <input type="hidden" name="product_data[tax_ids]" value="" />
            {include file="common/adaptive_object_selection.tpl"
                input_name="product_data[tax_ids]"
                input_id="elm_taxes"
                item_ids=$product_data.tax_ids
                items=$vendor_debt_payout_fee_taxes
                id_field="tax_id"
                name_field="tax"
                type="taxes"
                class_prefix="taxes"
                close_on_select="false"
                list_mode=false
            }
        </div>
    </div>
{/if}
