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

/**
 * Manual JSON-LD fields in admin (Website → SEO → JSON-LD).
 *
 * Sections and fields must stay aligned with fn_seo_get_schema_org_organization_markup()
 * and backend form names (json_ld[section][field]).
 *
 * Per-field optional keys:
 * - default: string used when the key is absent from stored data (explicit empty string in DB still clears the value).
 */
return [
    'organization' => [
        'fields' => [
            'description' => [
                'default' => '',
            ],
            'telephone' => [
                'default' => '',
            ],
            'email' => [
                'default' => '',
            ],
            'same_as' => [
                'default' => '',
            ],
        ],
    ],
];
