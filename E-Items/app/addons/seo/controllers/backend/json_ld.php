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

use Tygh\Tygh;

defined('BOOTSTRAP') or die('Access denied');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($mode === 'update') {
        /** @var \Tygh\Storefront\Storefront $storefront */
        $storefront = Tygh::$app['storefront'];
        $payload = isset($_REQUEST['json_ld']) && is_array($_REQUEST['json_ld'])
            ? $_REQUEST['json_ld']
            : [];

        fn_seo_save_json_ld_data($storefront->storefront_id, $payload);
    }

    return [CONTROLLER_STATUS_OK, 'json_ld.manage'];
}

if ($mode === 'manage') {
    /** @var \Tygh\Storefront\Storefront $storefront */
    $storefront = Tygh::$app['storefront'];

    Tygh::$app['view']->assign('json_ld', fn_seo_get_json_ld_data($storefront->storefront_id));
}
