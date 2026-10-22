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

use Tygh\Addons\StripeConnect\Webhook\StripeWebhook;
use Stripe\Webhook;

defined('BOOTSTRAP') or die('Access denied');

if (!isset($_SERVER['HTTP_STRIPE_SIGNATURE'])) {
    die('Access denied');
}

$payload = @file_get_contents('php://input');
if ($payload === false) {
    return [CONTROLLER_STATUS_NO_CONTENT];
}

$stripe_signature = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = $id = null;

if (!empty($_REQUEST['id']) && is_scalar($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
} else {
    $event_data = @json_decode($payload, true);
    if (is_array($event_data) && !empty($event_data['type'])) {
        $webhooks = fn_get_schema('stripe_connect', 'webhooks');
        if (is_array($webhooks)) {
            foreach ($webhooks as $_id => $webhook_params) {
                if (
                    isset($webhook_params['enabled_events'])
                    && is_array($webhook_params['enabled_events'])
                    && in_array($event_data['type'], $webhook_params['enabled_events'], true)
                ) {
                    $id = $_id;
                    break;
                }
            }
        }
    }
}

$webhook_secret_key = StripeWebhook::getSecretKey((string) $id);
if (!$webhook_secret_key) {
    return [CONTROLLER_STATUS_NO_CONTENT];
}

try {
    $event = Webhook::constructEvent(
        $payload,
        $stripe_signature,
        $webhook_secret_key
    );
} catch (\Exception $e) {
    return [CONTROLLER_STATUS_NO_CONTENT];
}

StripeWebhook::handle($event);

return [CONTROLLER_STATUS_NO_CONTENT];
