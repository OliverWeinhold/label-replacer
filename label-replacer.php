<?php
/*
Plugin Name: Label Replacer
Plugin URI: https://oliverweinhold.de/
Description: A simple plugin to replace specific text labels on the website automatically.
Version: 1.1
Author: Oliver Weinhold
Author URI: https://oliverweinhold.de/
License: GPL v3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

/*
Label Replacer WordPress Plugin
Copyright (C) 2024 Oliver Weinhold

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see https://www.gnu.org/licenses/gpl-3.0.html.
*/

// Include Settings page
include 'settings.php';

function replace_labels($content) {
    // Regex to find label definitions.
    $label_def_regex = '/\{\{label:(.*?)=(.*?)\}\}/';

    // Find all label definitions in the content.
    preg_match_all($label_def_regex, $content, $matches, PREG_SET_ORDER);

    // Check if matches were found before proceeding.
    if (empty($matches)) {
        return $content;  // No changes if no matches were found.
    }

    // Create an associative array from the found label definitions.
    $labels = array();
    foreach ($matches as $match) {
        // Check if the necessary data is present.
        if (isset($match[1]) && isset($match[2])) {
            $label = esc_html($match[1]);  // Data cleaning
            if (get_option('labelReplacer_allowHTML')) { //get Setting allowHTML
                $replacement = $match[2];  // No Data validation if allowHTML is enabled
            } else {
                $replacement = sanitize_text_field($match[2]);  // Data validation  
            }
            $labels['{{label:' . preg_quote($label, '/') . '}}'] = $replacement;

            // Remove the label definition from the content.
            $content = str_replace($match[0], '', $content);
        }
    }

    // Loop through each label and replace it in the content.
    foreach ($labels as $label => $replacement) {
        $content = str_replace($label, $replacement, $content);
    }

    // Return the modified content.
    return $content;
}
add_filter('the_content', 'replace_labels');