<?php
/**
 * @package   Easy_Related_Posts_Templates_Shortcode
 * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @link      http://erp.xdark.eu
 * @copyright 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
$containerClass = $uniqueID . 'Container';
$thumbClass = $uniqueID . 'Thumbnail';
$titleClass = $uniqueID . 'PostTitle';
$excClass = $uniqueID . 'Exc';

if ($options['thumbCaption'] && in_array('thumbnail', $optionsObj->getContentPositioning()) && !( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'photon' ) )){
	$showThumbCaptions = true;
} else {
	$showThumbCaptions = false;
}

$style = '';
if (isset($options['backgroundColor']) && $options['backgroundColor'] != '#ffffff') {
    $style .= ' background-color: ' . $options['backgroundColor'] . '; ';
}
if (isset($options['borderWeight']) && $options['borderWeight'] > 0) {
    $style .= ' border: ' . $options['borderWeight'] . 'px solid; ';
}
if (isset($options['borderRadius']) && $options['borderRadius'] > 0) {
    $style .= ' border-radius:  ' . $options['borderRadius'] . 'px; ';
}
if (isset($options['borderColor']) && $options['borderColor'] != '#ffffff') {
    $style .= ' border-color: ' . $options['borderColor'] . '; ';
}
if (isset($options['floatedWidth']) && (int)$options['floatedWidth'] >= 10 && (int)$options['floatedWidth'] <= 100) {
    $style .= ' width: ' . $options['floatedWidth'] . '%; ';
}
if (isset($options['floatedAlign'])) {
    $style .= ' float: ' . $options['floatedAlign'] . '; ';
    if($options['floatedAlign'] == 'left'){
        $style .= ' margin: 0.5em 0.5em 0.5em 0; ';
    } else {
        $style .= ' margin: 0.5em 0 0.5em 0.5em; ';
    }
}
$style .= ' padding: 0.5em; ';
?>
<div class="erpProContainer <?php echo $containerClass; ?>" style="<?php echo $style; ?>">
    <div class="">
        <?php
        if ($options['showTitle'] == true) {
            ?>
        <div class="" style="text-align: center;">
                <span class="erpProTitle" style="line-height: 1.4; font-size: 1.4em;"><?php if (isset($title)) echo $title; ?></span>
            </div>
            <?php
        }
        if (isset($posts[0])) {
            $v = $posts[0];
                $columnClass = 12;
                ?>
                <div class=""
                <?php
                if (current_user_can('activate_plugins')) {
                    echo 'title="Rating: ' . $v->getRating() . ' Post date: ' . $v->getTheTime() . '"';
                }
                ?>
                     >
                    <a href="<?php echo $v->getPermalink() ?>" class="erpProPostLink">
                        <?php
                        foreach ($optionsObj->getContentPositioning() as $key => $value) {
                            include plugin_dir_path(__FILE__) . 'components/' . $value . '.php';
                        }
                        ?>
                    </a>
                </div>
            <?php
        } // if (isset($posts))
        ?>
    </div>
</div>
<?php
if ($showThumbCaptions) {
    ?>
    <script type="text/javascript">
        (function($) {
            $(function() {
                $(window).load(function() {
                    $('.<?php echo $thumbClass; ?>').captionjs({
                        'class_name': 'erpProcaptionjs', // Class name assigned to each <figure>
                        'schema': false, // Use schema.org markup (i.e., itemtype, itemprop)
                        'mode': 'animated', // default | static | animated | hide
                        'debug_mode': false, // Output debug info to the JS console
                        'force_dimensions': false        // Force the dimensions in case they can't be detected (e.g., image is not yet painted to viewport)
                    });
                });
            });
        }(jQuery));

    </script>
    <?php
}