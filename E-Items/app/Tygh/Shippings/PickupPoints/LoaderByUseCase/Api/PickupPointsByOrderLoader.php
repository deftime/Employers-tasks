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

namespace Tygh\Shippings\PickupPoints\LoaderByUseCase\Api;

use Tygh\Registry;
use Tygh\Shippings\PickupPoints\Dto\LookupData\PickupPointsLookupContext;
use Tygh\Shippings\PickupPoints\LoaderByLocation\ShippingMethodProvidedPickupPointsLoaderFactory;

class PickupPointsByOrderLoader implements IApiPickupPointsLoadingStrategy
{
    /**
     * @var ShippingMethodProvidedPickupPointsLoaderFactory
     */
    protected $factory;

    //phpcs:ignore
    /** @var array */
    protected $order_info;

    /**
     * @param ShippingMethodProvidedPickupPointsLoaderFactory $factory    Pickup points loader factory
     * @param array                                           $order_info Order data
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint
     */
    public function __construct(ShippingMethodProvidedPickupPointsLoaderFactory $factory, array $order_info)
    {
        $this->factory = $factory;
        $this->order_info = $order_info;
    }

    /**
     * @return array
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification
     */
    public function getPickupPoints()
    {
        $result = [];

        if (!isset($this->order_info['product_groups'])) {
            return $result;
        }

        foreach ($this->order_info['product_groups'] as $product_group) {
            if (!isset($product_group['chosen_shippings'])) {
                continue;
            }

            $shipping_id = $product_group['chosen_shippings'][0]['shipping_id'];
            if (fn_allowed_for('MULTIVENDOR')) {
                $company_id = $product_group['company_id'] ?? Registry::get('runtime.company_id');
            } else {
                $company_id = Registry::get('runtime.company_id');
            }

            if (empty($product_group['package_info'])) {
                continue;
            }

            $lookup_context = PickupPointsLookupContext::fromPackageInfo($shipping_id, $company_id, $product_group['package_info']);

            $shipping_provided_loader = $this->factory->getShippingMethodProvidedPickupPointsLoader($shipping_id);
            if ($shipping_provided_loader === null) {
                continue;
            }

            $pickup_points = array_map(
                static function ($pickup_point) {
                    $pickup_point_array = $pickup_point->toArray();
                    unset($pickup_point_array['extra_data']);
                    return $pickup_point_array;
                },
                $shipping_provided_loader->getPickupPointsByLocation($lookup_context)
            );

            $result[] = [
                'shipping_id'   => $shipping_id,
                'pickup_points' => $pickup_points,
            ];
        }

        return $result;
    }
}
