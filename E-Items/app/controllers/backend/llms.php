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

use Tygh\Common\Llms;
use Tygh\Enum\NotificationSeverity;
use Tygh\Tygh;

defined('BOOTSTRAP') or die('Access denied');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $redirect_params = [];
    $llms = new Llms();

    if ($mode === 'update') {
        if (!empty($_REQUEST['llms_data']) && isset($_REQUEST['llms_data']['content'])) {
            if (fn_allowed_for('ULTIMATE') && isset($_REQUEST['llms_data']['update_content'])) {
                /** @var \Tygh\Storefront\repository $repository */
                $repository = Tygh::$app['storefront.repository'];
                list($all_storefronts,) = $repository->find();
                foreach ($all_storefronts as $storefront) {
                    $llms->setLlmsDataForStorefrontId($storefront->storefront_id, $_REQUEST['llms_data']['content']);
                }
            } else {
                /** @var \Tygh\Storefront\Storefront $storefront */
                $storefront = Tygh::$app['storefront'];
                $storefront_id = $storefront->storefront_id;

                $llms->setLlmsDataForStorefrontId($storefront_id, $_REQUEST['llms_data']['content']);
            }
        }
    }

    return [CONTROLLER_STATUS_OK, 'llms.manage?' . http_build_query($redirect_params)];
}

if ($mode === 'manage') {
    $storefront = Tygh::$app['storefront'];
    $storefront_id = $storefront->storefront_id;

    $llms = new Llms();
    $llms_data = $llms->getLlmsDataByStorefrontId($storefront_id);

    $content = $llms_data['data'] ?? '';

    $llms_file_content = $llms->getLlmsTxtContent();
    if ($llms_file_content !== null) {
        fn_set_notification(NotificationSeverity::WARNING, __('notice'), __('information_file_llms'));
    }

    Tygh::$app['view']->assign('llms', $content);
}
