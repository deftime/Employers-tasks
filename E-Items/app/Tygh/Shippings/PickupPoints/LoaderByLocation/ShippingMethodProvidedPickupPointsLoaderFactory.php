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

namespace Tygh\Shippings\PickupPoints\LoaderByLocation;

use Tygh;
use Tygh\Shippings\IPickupPointsService;

class ShippingMethodProvidedPickupPointsLoaderFactory
{
    /**
     * @param int $shipping_id Shipping identifier
     *
     * @return IPickupPointsLoaderByLocation|null
     */
    public function getShippingMethodProvidedPickupPointsLoader($shipping_id)
    {
        /** @var \Tygh\Shippings\PickupPoints\Repository $pickup_points_repository */
        $pickup_points_repository = Tygh::$app['pickup_point.repository'];
        $shipping_info = $pickup_points_repository->getShippingInfoForPickupPoints($shipping_id);

        $module = db_get_field(
            'SELECT module FROM ?:shipping_services WHERE service_id = ?i',
            $shipping_info['service_id']
        );

        $module_camelized = fn_camelize($module);
        $shipping_service_class = 'Tygh\\Shippings\\Services\\' . $module_camelized;

        if (!class_exists($shipping_service_class)) {
            return null;
        }

        /** @var \Tygh\Shippings\IPickupPointsService $shipping_service Shipping service */
        $shipping_service = new $shipping_service_class();
        if ($shipping_service instanceof IPickupPointsService) {
            return $shipping_service->getPickupPointsLoader();
        }

        return null;
    }
}
