<?php
/**
 *
 * Custom Walker
 *
 * @access      public
 * @since       1.0
 * @return      void
 */
class rc_wmd_walker extends Walker_Nav_Menu {
    /**
     * Starts the list before the elements are added.
     * Because the dash is just a set of tiles, we have no levels what so ever
     *
     * @since 3.0.0
     *
     * @see Walker::start_lvl()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of wp_nav_menu() arguments.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= "";
    }

    /**
     * Ends the list of after the elements are added.
     * No levels for the dash
     *
     * @since 3.0.0
     *
     * @see Walker::end_lvl()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of wp_nav_menu() arguments.
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= "";
    }


    function start_el(&$output, $item, $depth, $args) {

        if ($this->qualifies_for_rendering($item)) {

            $attributes  = ! empty( $item->attr_title )     ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )         ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )            ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
            $attributes .= ! empty( $item->url )            ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
            $attributes .= ! empty( $item->wmd_background ) ? ' style="background-image: url(' .esc_attr( $item->wmd_background ) . ');"' : '';

            $output .= '<div class="wmd__tile" data-url="' . esc_attr( $item->url ) . '">';
            $output .= '  <h2 class="wmd__headline">' . apply_filters( 'the_title', $item->title, $item->ID ) .  '</h2>';
            $output .= '  <a class="wmd__tile-inner" ' . $attributes . '>';
            if ($item->wmd_subtitle) $output .= '<span class="wmd__mask">' . $item->wmd_subtitle . '</span>';
            $output .= '  </a>';
        }


        /*

        echo '<pre>';
        print_r($item);
        echo '</pre>';


        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        $class_names = ' class="'. esc_attr( $class_names ) . '"';

        $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        $prepend = '<strong>';
        $append = '</strong>';
        $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

        if($depth != 0)
        {
            $description = $append = $prepend = "";
        }

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
        $item_output .= $description.$args->link_after;
        $item_output .= ' '.$item->subtitle.'</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

        */
    }

    /**
     * Ends the element output, if needed.
     *
     * @since 3.0.0
     *
     * @see Walker::end_el()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Page data object. Not used.
     * @param int    $depth  Depth of page. Not Used.
     * @param array  $args   An array of wp_nav_menu() arguments.
     */
    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
        if ($this->qualifies_for_rendering($item)) {
            $output .= "</div>\n";
        }
    }


    private function qualifies_for_rendering($item){
        return $item->wmd_subtitle || $item->wmd_background ? true : false;
    }
}