<?php

/**
 * Minimal server-side data provider for the Vendor showcase block.
 *
 * The candidate is not expected to implement CS-Cart backend logic for the
 * test task. This function resolves the vendor of the current product and
 * exposes a small, frontend-friendly data structure to the block template.
 */

defined('BOOTSTRAP') or die('Access denied');

/**
 * Returns the vendor card data for the current product page.
 *
 * @return array<string, mixed>
 */
function fn_vendor_showcase_get_vendor_card()
{
    $product_id = !empty($_REQUEST['product_id']) ? (int) $_REQUEST['product_id'] : 0;

    if (!$product_id) {
        return array();
    }

    $company_id = (int) db_get_field(
        'SELECT company_id FROM ?:products WHERE product_id = ?i',
        $product_id
    );

    if (!$company_id) {
        return array();
    }

    $company_data = fn_get_company_data(
        $company_id,
        CART_LANGUAGE,
        array(
            'skip_company_condition' => true,
            'use_i18n_fields' => true,
        )
    );

    if (empty($company_data) || empty($company_data['company'])) {
        return array();
    }

    $name = (string) $company_data['company'];
    $description = !empty($company_data['company_description'])
        ? fn_vendor_showcase_normalize_description($company_data['company_description'])
        : '';

    return array(
        'company_id' => $company_id,
        'name' => $name,
        'url' => fn_url('companies.view?company_id=' . $company_id, 'C'),
        'logo' => fn_vendor_showcase_get_company_logo($company_id),
        'initials' => fn_vendor_showcase_get_initials($name),
        'description' => $description,
    );
}

/**
 * Returns a normalized vendor logo or null.
 *
 * @param int $company_id Vendor ID.
 *
 * @return array<string, mixed>|null
 */
function fn_vendor_showcase_get_company_logo($company_id)
{
    $logos = fn_get_logos((int) $company_id);

    if (empty($logos['theme']['image']['image_path'])) {
        return null;
    }

    $image = $logos['theme']['image'];

    return array(
        'src' => (string) $image['image_path'],
        'width' => isset($image['image_x']) ? (int) $image['image_x'] : null,
        'height' => isset($image['image_y']) ? (int) $image['image_y'] : null,
    );
}

/**
 * Converts the company description to plain text and limits it to 300 chars.
 *
 * @param string $description Company description.
 *
 * @return string
 */
function fn_vendor_showcase_normalize_description($description)
{
    $description = html_entity_decode(
        strip_tags((string) $description),
        ENT_QUOTES,
        'UTF-8'
    );
    $description = preg_replace('/\\s+/u', ' ', $description);
    $description = trim((string) $description);

    if (function_exists('mb_substr')) {
        return mb_substr($description, 0, 300, 'UTF-8');
    }

    return substr($description, 0, 300);
}

/**
 * Builds one or two initials for the avatar fallback.
 *
 * @param string $name Vendor name.
 *
 * @return string
 */
function fn_vendor_showcase_get_initials($name)
{
    $parts = preg_split('/\\s+/u', trim((string) $name), -1, PREG_SPLIT_NO_EMPTY);

    if (empty($parts)) {
        return '';
    }

    $initials = '';

    foreach (array_slice($parts, 0, 2) as $part) {
        if (function_exists('mb_substr')) {
            $initials .= mb_substr($part, 0, 1, 'UTF-8');
        } else {
            $initials .= substr($part, 0, 1);
        }
    }

    if (function_exists('mb_strtoupper')) {
        return mb_strtoupper($initials, 'UTF-8');
    }

    return strtoupper($initials);
}
