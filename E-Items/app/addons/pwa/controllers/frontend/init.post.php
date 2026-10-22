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

defined('BOOTSTRAP') or die('Access denied');

$storefront = Tygh::$app['storefront'];
$pwa_settings = fn_get_pwa_settings($storefront->storefront_id);
$manifest_version = md5(json_encode($pwa_settings));

Tygh::$app['view']->assign('pwa_is_valid', $pwa_settings['is_valid']);
Tygh::$app['view']->assign('manifest_version', $manifest_version);
