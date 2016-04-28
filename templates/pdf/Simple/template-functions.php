<?php
/**
 * Use this file for all your template filters and actions.
 * Requires WooCommerce PDF Invoices & Packing Slips 1.4.13 or higher
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// For each purchased item, add the item's category to the $data array
add_filter( 'wpo_wcpdf_order_item_data','x2050_add_cat', 10, 3 );

function x2050_add_cat($data) {
        $data['prod_cat'] = strip_tags(get_the_term_list( $data['product_id'], 'product_cat' ));
        return $data;
}

// Sort the array of all ordered items by product category, then sort each item alphabetically by name within each category
add_filter( 'wpo_wcpdf_order_items_data', 'x2050_sort_all', 10, 3);
function x2050_sort_all($data_list) {
        $p_cat=array();  //set up empty array
        $p_name=array(); // set up empty array
// Create two arrays: product categories and names of items purchased.  Can replace these with other fields as desired.
        foreach ($data_list as $key => $row) {
                $x2050_category[$key] = $row['prod_cat'];  //Create the array of product categories
                $x2050_name[$key] = $row['name'];          //Create the array of product names
        }
        //Now use array_multisort to sort by category, and alpabetize items within each category:
        array_multisort($x2050_category, SORT_ASC, $x2050_name, SORT_ASC, $data_list);
return $data_list;
}
