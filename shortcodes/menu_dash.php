<?php

/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 07/10/16
 * Time: 00:13
 * @param $attributes
 * @param $content
 * @return false|object|void
 */
function sc_wp_menu_dash($attributes, $content = null){

    extract(shortcode_atts(array(
            'backgrounds'     => '',	// the backgrounds, which are alternating
            'menu_id'         => '',	// an id for the menu (not used)
            'menu'			  => ''		// this is the menu identifier
        ),
            $attributes)
    );
    /** @var string $backgrounds */
    /** @var string $menu_id */
    /** @var string $menu */

    $backgrounds = explode('|', $backgrounds);
    $lucky_background = $backgrounds[intval( round( rand(0, count($backgrounds) - 1) ))];

    return wp_nav_menu( array(
        'menu'			  => $menu,
        'menu_id'         => $menu_id,
        'echo'            => false,
        'depth'           => 0,
        'walker'          => new rc_wmd_walker(),
        'items_wrap'      => '<div class="wmd" style="background-image:url(' . $lucky_background . ');">%3$s</div>'
    ));

};