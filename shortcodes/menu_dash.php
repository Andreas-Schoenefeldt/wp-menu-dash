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
        'backgrounds'     => '',
        'menu_id'         => '',
        ),
        $attributes)
    );


    return wp_nav_menu( array(
        'menu_id'         => $menu_id,
        'echo'            => false,
        'depth'           => 0,
        'walker'          => new rc_wmd_walker()
    ));

};