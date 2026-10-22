{strip}
{$cart_direct_payments = ""|fn_direct_payments_get_mini_cart}
{$cart_products_for_add_to_cart_stepper = $cart_direct_payments.products}

{* Export *}
{$cart_products_for_add_to_cart_stepper = $cart_products_for_add_to_cart_stepper scope=parent}
{/strip}