{if $smarty.capture["stripe_test_mode_notification_{$product.product_id}"]|default:""|trim}
    {$smarty.capture["stripe_test_mode_notification_{$product.product_id}"] nofilter}
{/if}
