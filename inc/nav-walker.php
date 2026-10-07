<?php
/**
 * Tailwind CSS Custom Nav Walker for ENIGMA 14
 * Supports multi-level dropdown menus for Categories & Services.
 */

if (!defined('ABSPATH')) {
    exit;
}

class Enigma_Tailwind_Nav_Walker extends Walker_Nav_Menu {

    /**
     * Starts the list before the elements are added.
     */
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n{$indent}<ul class=\"sub-menu absolute top-[calc(100%-2px)] left-0 min-w-[260px] bg-surface-container-low border border-surface-container-highest shadow-[0_16px_36px_rgba(0,0,0,0.85)] py-2 rounded-b-lg hidden group-hover:flex flex-col z-50 transition-all duration-200 backdrop-blur-md\">\n";
    }

    /**
     * Ends the list of after the elements are added.
     */
    public function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "{$indent}</ul>\n";
    }

    /**
     * Starts the element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $is_current = in_array('current-menu-item', $classes) || in_array('current-menu-ancestor', $classes);
        $has_children = in_array('menu-item-has-children', $classes);

        // Attributes
        $attributes  = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target    ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn       ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url       ) .'"' : '';

        if ($depth === 0) {
            // Top-level item
            $li_classes = 'h-full flex items-center';
            if ($has_children) {
                $li_classes .= ' relative group';
            }
            $output .= "{$indent}<li class=\"" . esc_attr($li_classes) . "\">";

            $a_classes = 'h-full flex items-center px-space-2xs uppercase tracking-wider transition-colors duration-150 text-[12px] whitespace-nowrap shrink-0 ';
            if ($is_current) {
                $a_classes .= 'text-primary-container font-bold border-b-2 border-primary-container';
            } else {
                $a_classes .= 'text-on-surface-variant hover:text-on-surface group-hover:text-primary-container font-semibold';
            }
            $attributes .= ' class="' . esc_attr($a_classes) . '"';

            $item_output = isset($args->before) ? $args->before : '';
            $item_output .= '<a' . $attributes . '>';
            $item_output .= (isset($args->link_before) ? $args->link_before : '');
            $item_output .= apply_filters('the_title', $item->title, $item->ID);
            $item_output .= (isset($args->link_after) ? $args->link_after : '');

            // Submenu indicator arrow
            if ($has_children) {
                $item_output .= '<span class="material-symbols-outlined text-[16px] ml-1 text-on-surface-variant group-hover:text-primary-container group-hover:rotate-180 transition-transform duration-200">expand_more</span>';
            }

            $item_output .= '</a>';
            $item_output .= isset($args->after) ? $args->after : '';

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        } else {
            // Dropdown sub-menu item (depth > 0)
            $output .= "{$indent}<li class=\"w-full border-b border-surface-container-highest/20 last:border-b-0\">";

            $a_classes = 'flex items-center px-4 py-2.5 text-[11px] uppercase tracking-wider transition-colors duration-150 whitespace-nowrap ';
            if ($is_current) {
                $a_classes .= 'text-primary-container font-bold bg-surface-container/50';
            } else {
                $a_classes .= 'text-on-surface-variant hover:text-primary-container hover:bg-surface-container/70 font-semibold';
            }
            $attributes .= ' class="' . esc_attr($a_classes) . '"';

            $item_output = isset($args->before) ? $args->before : '';
            $item_output .= '<a' . $attributes . '>';
            $item_output .= '<span class="inline-block w-1.5 h-1.5 rounded-full bg-primary-container/60 mr-2"></span>';
            $item_output .= (isset($args->link_before) ? $args->link_before : '');
            $item_output .= apply_filters('the_title', $item->title, $item->ID);
            $item_output .= (isset($args->link_after) ? $args->link_after : '');
            $item_output .= '</a>';
            $item_output .= isset($args->after) ? $args->after : '';

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }
    }

    /**
     * Ends the element output.
     */
    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}

/**
 * Tailwind CSS Footer Nav Walker for ENIGMA 14 (Categorii & Linkuri Utile)
 */
class Enigma_Footer_Nav_Walker extends Walker_Nav_Menu {
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= "\n<ul class=\"pl-3 mt-1 flex flex-col gap-1.5\">\n";
    }

    public function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= "</ul>\n";
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $is_current = in_array('current-menu-item', $classes) || in_array('current-menu-ancestor', $classes);

        $output .= '<li class="w-full">';

        $attributes  = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target    ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn       ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url       ) .'"' : '';

        $a_classes = 'inline-flex items-center gap-2 group transition-colors text-body-md ';
        if ($is_current) {
            $a_classes .= 'text-primary-container font-semibold';
        } else {
            $a_classes .= 'text-on-surface-variant hover:text-primary-container';
        }
        $attributes .= ' class="' . esc_attr($a_classes) . '"';

        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= '<span class="w-1.5 h-1.5 rounded-full bg-primary-container/60 group-hover:bg-primary-container group-hover:scale-125 transition-all"></span>';
        $item_output .= (isset($args->link_before) ? $args->link_before : '');
        $item_output .= '<span>' . apply_filters('the_title', $item->title, $item->ID) . '</span>';
        $item_output .= (isset($args->link_after) ? $args->link_after : '');
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}

/**
 * Tailwind CSS Mobile Nav Walker for ENIGMA 14 (Vertical accordion drawer)
 */
class Enigma_Tailwind_Mobile_Nav_Walker extends Walker_Nav_Menu {
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n{$indent}<ul class=\"sub-menu pl-4 border-l-2 border-surface-container-highest flex flex-col gap-1 py-1 my-1\">\n";
    }

    public function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "{$indent}</ul>\n";
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $is_current = in_array('current-menu-item', $classes) || in_array('current-menu-ancestor', $classes);
        $has_children = in_array('menu-item-has-children', $classes);

        $attributes  = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target    ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn       ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url       ) .'"' : '';

        $li_classes = 'w-full py-0.5';
        $output .= "{$indent}<li class=\"" . esc_attr($li_classes) . "\">";

        $a_classes = 'flex items-center justify-between py-2 px-3 rounded-lg uppercase tracking-wider text-[13px] font-bold transition-colors ';
        if ($is_current) {
            $a_classes .= 'bg-surface-container-high text-primary-container border-l-2 border-primary-container';
        } else {
            $a_classes .= 'text-on-surface hover:text-primary-container hover:bg-surface-container';
        }
        $attributes .= ' class="' . esc_attr($a_classes) . '"';

        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= (isset($args->link_before) ? $args->link_before : '');
        $item_output .= '<span>' . apply_filters('the_title', $item->title, $item->ID) . '</span>';
        $item_output .= (isset($args->link_after) ? $args->link_after : '');

        if ($has_children) {
            $item_output .= '<span class="material-symbols-outlined text-[18px] text-outline">chevron_right</span>';
        }

        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}


