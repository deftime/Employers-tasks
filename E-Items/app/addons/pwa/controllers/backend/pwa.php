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

use Tygh\Settings;

defined('BOOTSTRAP') or die('Access denied');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($mode === 'update_manifest_status') {
        $storefront_id = isset($_REQUEST['storefront_id']) ? (int) $_REQUEST['storefront_id'] : null;

        if ($storefront_id === null) {
            return [CONTROLLER_STATUS_DENIED];
        }

        $settings_manager = Settings::instance(['storefront_id' => $storefront_id]);
        $pwa_settings = Settings::instance()->getValues('pwa', 'ADDON', false, null, $storefront_id);
        if (!is_array($pwa_settings)) {
            return;
        }
        $pwa_configuration = unserialize($pwa_settings['pwa_configuration']);
        $pwa_configuration['manifest_status'] = $_REQUEST['manifest_status'];
        $pwa_settings['pwa_configuration'] = serialize($pwa_configuration);

        foreach ($pwa_settings as $setting_name => $setting_value) {
            $settings_manager->updateValue($setting_name, (string) $setting_value, '', false, null, true, $storefront_id);
        }

        if (!empty($_REQUEST['return_url'])) {
            return [CONTROLLER_STATUS_OK, $_REQUEST['return_url']];
        }
    }
}
