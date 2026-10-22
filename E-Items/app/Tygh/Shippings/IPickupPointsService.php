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

namespace Tygh\Shippings;

/**
 * Shipping pickup services advanced interface
 */
interface IPickupPointsService
{
    /**
     * Checks if pickup points are supported by the shipping method settings.
     *
     * - Return true by default when all shipping methods provided by the service
     * support pickup points.
     * - When pickup points are not supported for specific method settings,
     * for example by tariff or delivery mode, return false.
     *
     * @param array $shipping_info Shipping method data
     *
     * @return bool
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
     */
    public function isPickupPointsSupported(array $shipping_info);

    /**
     * Gets minimal cost among available pickup points
     *
     * @return float|false
     */
    public function getPickupMinCost();

    /**
     * Gets pickup points quantity
     *
     * @return int|false
     */
    public function getPickupPointsQuantity();

    /**
     * @return \Tygh\Shippings\PickupPoints\LoaderByLocation\IPickupPointsLoaderByLocation
     */
    public function getPickupPointsLoader();
}
