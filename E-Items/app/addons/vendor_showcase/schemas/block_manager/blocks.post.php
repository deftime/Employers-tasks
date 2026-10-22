<?php

/**
 * Starter block for the frontend test task.
 *
 * The schema registers a new block type in Design -> Layouts.
 * The storefront data is provided by fn_vendor_showcase_get_vendor_card().
 */

defined('BOOTSTRAP') or die('Access denied');

$schema['vendor_showcase'] = array(
    'content' => array(
        'vendor_card' => array(
            'type' => 'function',
            'function' => array('fn_vendor_showcase_get_vendor_card'),
        ),
    ),
    'settings' => array(
        'panel_mode' => array(
            'type' => 'selectbox',
            'option_name' => 'vendor_showcase.panel_mode',
            'values' => array(
                'popup' => 'vendor_showcase.panel_mode.popup',
                'modal' => 'vendor_showcase.panel_mode.modal',
            ),
            'default_value' => 'popup',
        ),
    ),
    'templates' => array(
        'addons/vendor_showcase/blocks/vendor_card.tpl' => array(),
    ),
    'wrappers' => 'blocks/wrappers',
);

return $schema;
