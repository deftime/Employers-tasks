<?php
/***************************************************************************
*                                                                          *
*   (c) 2004 Vladimir V. Kalynyak, Alexey V. Vinokurov, Ilya M. Shalnev    *
*                                                                          *
* This  is  commercial  software,  only  users  who have purchased a valid *
* license  and  accept  to the terms of the  License Agreement can install *
* and use this program.                                                    *
*                                                                          *
****************************************************************************
* PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
* "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
****************************************************************************/

use Tygh\Enum\Addons\VendorDebtPayout\ProductTypes;
use Tygh\Registry;

defined('BOOTSTRAP') or die('Access denied');

/** @var string $mode */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    return [CONTROLLER_STATUS_OK];
}

if ($mode === 'update') {
    /** @var \Tygh\SmartyEngine\Core $view */
    $view = Tygh::$app['view'];
    /** @var array<string, string> $product_data */
    $product_data = $view->getTemplateVars('product_data');
    if (
        empty($product_data['product_id'])
        || (int) $product_data['product_id'] !== fn_vendor_debt_payout_get_payout_product()
        || ($product_data['product_type'] ?? '') !== ProductTypes::DEBT_PAYOUT
    ) {
        return [CONTROLLER_STATUS_OK];
    }

    $view->assign(
        'vendor_debt_payout_fee_taxes',
        array_values(fn_get_taxes(DESCR_SL))
    );

    $tabs = Registry::get('navigation.tabs');
    foreach ($tabs as $id => &$tab) {
        $tab['hidden'] = $id !== 'detailed';
    }
    unset($tab);
    Registry::set('navigation.tabs', $tabs);

    Tygh::$app['view']->assign('force_zero_company_id', true);
}

return [CONTROLLER_STATUS_OK];
