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

/**
 * Describes a way to describe grids
 *
 * Structure:
 *
 * 'wrappers' => [
 *      'wrapper_name' => [
 *          'name' => __('wrapper_name_langvar'),
 *          'template' => 'template_name.tpl',
 *          'allowed_locations' => [
 *              'location1',
 *              'location2',
 *              ... // list of location dispatches (ex. 'checkout' for Checkout location)
 *          ]
 *      ]
 *  ]
 */

/** @var array<string, array> $schema */
$schema = [
    'wrappers' => [
        'lite_checkout' => [
            'name' => __('block_manager.wrappers.lite_checkout'),
            'template' => 'blocks/grid_wrappers/lite_checkout.tpl',
            'allowed_locations' => [
                'checkout'
            ],
        ]
    ],
];

return $schema;
