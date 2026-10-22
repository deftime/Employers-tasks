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

use Tygh\Enum\YesNo;
use Tygh\Settings;

defined('BOOTSTRAP') or die('Access denied');

/**
 * @param string $new_value New value of setting
 *
 * @return void
 */
function fn_settings_actions_addons_master_products_allow_buy_default_common_product($new_value)
{
    if (YesNo::isFalse($new_value)) {
        Settings::instance()->updateValue('rating_above_price', YesNo::NO, 'vendor_rating');
    }
}
