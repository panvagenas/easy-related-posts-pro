<?php

function validateShortcodeFloatedOptions($options) {
    $newOptions = array(
        'showTitle' => isset($options ['showTitle']) ? true : false,
        'thumbCaption' => isset($options ['thumbCaption']) ? true : false,
        'backgroundColor' => isset($options['backgroundColor']) ? wp_strip_all_tags($options['backgroundColor']) : '#ffffff',
        'borderColor' => isset($options['borderColor']) ? wp_strip_all_tags($options['borderColor']) : '#ffffff',
        'floatedAlign' => isset($options['floatedAlign']) && ($options['floatedAlign'] == 'left' || $options['floatedAlign'] == 'right') ? wp_strip_all_tags($options['floatedAlign']) : 'left',
        'borderRadius' => isset($options ['borderRadius']) && (int)$options['borderRadius'] >= 0 ? (int) $options ['borderRadius'] : 0,
        'borderWeight' => isset($options ['borderWeight']) && (int)$options['borderWeight'] >= 0 ? (int) $options ['borderWeight'] : 0,
        'floatedWidth' => (isset($options ['floatedWidth']) && (int)$options['floatedWidth'] >= 10 && (int)$options['floatedWidth'] <= 100) ? (int) $options ['floatedWidth'] : 50
    );
    return $newOptions;
}
