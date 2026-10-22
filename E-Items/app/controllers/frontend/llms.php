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
use Tygh\Licensing\Features;

defined('BOOTSTRAP') or die('Access denied');

if ($mode === 'view') {
    $llms = new Llms();
    $storefront = Tygh::$app['storefront'];

    $content = $llms->getLlmsTxtContent();

    if (!isset($content) && fn_is_allowed(Features::LLMS)) {
        $llms_data = $llms->getLlmsDataByStorefrontId($storefront->storefront_id);
        $content = $llms_data['data'] ?? null;
    }

    if ($content === null || trim($content) === '') {
        return [CONTROLLER_STATUS_NO_PAGE];
    }

    header('Content-type: text/plain; charset=utf-8');
    echo($content);
    exit;
}
