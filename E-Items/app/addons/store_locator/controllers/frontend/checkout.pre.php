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

use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($mode == 'update_steps' || $mode == 'shipping_estimation') {

    if (!empty($_REQUEST['select_pickup_point']) && is_array($_REQUEST['select_pickup_point'])) {
        $calculate_shipping = false;
        foreach ($_REQUEST['select_pickup_point'] as $g_id => $select) {
            if (!is_array($select)) {
                continue;
            }

            foreach ($select as $s_id => $o_id) {
                Tygh::$app['session']['cart']['select_pickup_point'][$g_id][$s_id] = $o_id;
                $selected_shipping = isset($_REQUEST['shipping_ids']) ? reset($_REQUEST['shipping_ids']) : false;
                $calculate_shipping = (int) $selected_shipping === $s_id;
            }
        }
        Tygh::$app['session']['cart']['calculate_shipping'] = $calculate_shipping;
    }

    if (!empty(Tygh::$app['session']['cart']['select_pickup_point'])) {
        Tygh::$app['view']->assign('select_pickup_point', Tygh::$app['session']['cart']['select_pickup_point']);
    }
}

if ($mode == 'checkout' || $mode == 'cart') {
    if (!empty($_REQUEST['select_pickup_point']) && is_array($_REQUEST['select_pickup_point'])) {
        $calculate_shipping = false;
        foreach ($_REQUEST['select_pickup_point'] as $g_id => $select) {
            if (!is_array($select)) {
                continue;
            }

            foreach ($select as $s_id => $o_id) {
                Tygh::$app['session']['cart']['select_pickup_point'][$g_id][$s_id] = $o_id;
                $selected_shipping = isset($_REQUEST['shipping_ids']) ? reset($_REQUEST['shipping_ids']) : false;
                $calculate_shipping = (int) $selected_shipping === $s_id;
            }
        }
        Tygh::$app['session']['cart']['calculate_shipping'] = $calculate_shipping;
    }

}
