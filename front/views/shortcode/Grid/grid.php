<?php
/**
 * @title Grid
 * @description This is the template description
 * @options gridOptions.php
 * @settings gridSettings.php
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
$containerClass = $uniqueID . 'Container';
$thumbClass = $uniqueID . 'Thumbnail';
$titleClass = $uniqueID . 'PostTitle';
$excClass = $uniqueID . 'Exc';
?>
<div class="erpProContainer <?php echo $containerClass; ?>">
    <div class="container-fluid">
        <div class="row">
            <h2 class="erpProTitle col-md-12" style="line-height: 1.4;"><?php if (isset($title)) echo $title; ?></h2>
        </div>
        <?php
        if (isset($posts)) {
            foreach ($posts as $k => $v) {
                if ($k % $options['numOfPostsPerRow'] === 0) {
                    ?>
                    <div class="row">
                        <?php
                    }
                    ?>
                    <div class="col-md-<?php echo 12 / $options['numOfPostsPerRow']; ?>"
                    <?php
                    if (current_user_can('activate_plugins')) {
                        echo 'title="Rating: ' . $v->getRating() . ' Post date: ' . $v->getTheTime() . '"';
                    }
                    ?>
                         >
                        <a href="<?php echo $v->getPermalink() ?>" class="erpProPostLink" rel="nofollow">
                            <?php
                            foreach ($options['content'] as $key => $value) {
                                include plugin_dir_path(__FILE__) . 'components/' . $value . '.php';
                            }
                            ?>
                        </a>
                    </div>
                    <?php
                    if ($k % $options['numOfPostsPerRow'] + 1 === $options['numOfPostsPerRow'] || count($posts) === $k + 1) {
                        ?>
                    </div>
                    <div class="cf"></div>
                    <?php
                }
                ?>
                <?php
            } // foreach ($posts as $k => $v)
        } // if (isset($posts))
        ?>
    </div>
</div>
<?php
if ($options['thumbCaption']) {
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
?>