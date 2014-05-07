<?php

/**
 * Easy related posts PRO.
 *
 * @package   Easy_Related_Posts_Core_display
 * @author    Panagiotis Vagenas <pan.vagenas@gmail.com>
 * @link      http://erp.xdark.eu
 * @copyright 2014 Panagiotis Vagenas <pan.vagenas@gmail.com>
 */

/**
 * Post data class of plugin templates
 *
 * @package Easy_Related_Posts_Core_display
 * @author    Panagiotis Vagenas <pan.vagenas@gmail.com>
 */
class erpPROPostData {

    /**
     * WP_Post var
     *
     * @since 1.0.0
     * @var WP_Post
     */
    private $post;

    /**
     * Post id
     *
     * @since 1.0.0
     * @var int
     */
    private $ID;

    /**
     * Post title
     *
     * @since 1.0.0
     * @var string
     */
    private $title;

    /**
     * Post excerpt
     *
     * @since 1.0.0
     * @var string
     */
    private $excerpt;

    /**
     * Rating
     *
     * @since 1.0.0
     * @var float
     */
    private $rating;

    /**
     * Post thumbnail url
     *
     * @since 1.0.0
     * @var string
     */
    private $thumbnail;

    /**
     * Post permalink
     *
     * @since 1.0.0
     * @var string
     */
    private $permalink;

    /**
     * Post date
     *
     * @since 1.0.0
     * @var string
     */
    private $postDate;

    /**
     * Compontent positions
     *
     * @since 1.0.0
     * @var array
     */
    private $positions = array();
    
    /**
     *
     * @var erpPROOptions 
     */
    private $options;

    /**
     *
     * @param WP_Post $post
     * @param array $options
     * @param float $rating
     * @param int $hostPost
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function __construct(WP_Post $post, erpPROOptions $options, $rating, $hostPost) {
        $this->options = $options;
        $this->post = $post;
        $this->ID = $post->ID;
        $this->setTitle();
        $this->rating = $rating;
        $this->setPermalink($hostPost);
        $this->setPostDate('Y-m-d H:i:s');
        $this->setPositions($options);
    }

    /**
     * Get post title
     *
     * @return string
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Get post time
     *
     * @param string $timeFormat
     * @return string Formated time
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function getTheTime($timeFormat = 'Y-m-d H:i:s') {
        return date($timeFormat, strtotime($this->postDate));
    }

    /**
     * Set post date
     *
     * @param string $postFormat
     * @return \display\erpPROPostData
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    private function setPostDate($postFormat = 'Y-m-d H:i:s') {
        $this->postDate = get_the_time($postFormat, $this->ID);
        return $this;
    }

    /**
     * Set title
     *
     * @return \display\erpPROPostData
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    private function setTitle() {
        $size = $this->options->getPostTitleFontSize();
        $color = $this->options->getPostTitleColor();
        
        $fontColor = $color !== '#ffffff' ? ' color: '.$color.'; ' : '';
        $fontSize = $size !== 0 ? ' font-size: ' . $size . 'px; ' : '';
        $openTag = '<span style="'.$fontColor.$fontSize.'">';
        $closeTag = '</span>';
        
        $this->title = $openTag.$this->post->post_title.$closeTag;
        return $this;
    }

    /**
     * Get post except
     *
     * @return string
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function getExcerpt() {
        if (!isset($this->excerpt)) {
            $this->setExcerpt(erpPRODefaults::$comOpts ['excLength'], erpPRODefaults::$comOpts ['moreTxt']);
        }
        return $this->excerpt;
    }

    /**
     * Set post excerpt
     *
     * @param int $excLength
     *        	Excerpt length in words
     * @param string $moreText
     *        	More text to be displayed after post excerpt
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function setExcerpt($excLength, $moreText) {
        if (!empty($this->post->post_excerpt)) {
            $exc = $this->post->post_excerpt;
        } else {
            $exc = $this->post->post_content;
        }

        $exc = strip_shortcodes($exc);
        $exc = str_replace(']]>', ']]&gt;', $exc);
        $exc = wp_strip_all_tags($exc);
        
        
        $size = $this->options->getExcFontSize();
        $color = $this->options->getExcColor();
        
        $fontColor = $color !== '#ffffff' ? ' color: '.$color.'; ' : '';
        $fontSize = $size !== 0 ? ' font-size: ' . $size . 'px; ' : '';
        $openTag = '<span style="'.$fontColor.$fontSize.'">';
        $closeTag = '</span>';

        $tokens = explode(' ', $exc, $excLength + 1);

        if (count($tokens) > $excLength) {
            array_pop($tokens);
        }

        array_push($tokens, ' ' . $moreText);
        $exc = implode(' ', $tokens);
        $this->excerpt = $openTag.$exc.$closeTag;
    }

    /**
     * Get post rating
     *
     * @return float
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function getRating() {
        return $this->rating;
    }

    /**
     * Set post rating
     *
     * @param float $rating
     * @return \display\erpPROPostData
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    private function setRating($rating) {
        $this->rating = $rating;
        return $this;
    }

    /**
     * Get post proccesed thumbnail
     *
     * @param int $height
     *        	Thumbnail height
     * @param int $width
     *        	Thumbnail width
     * @param boolean $crop
     *        	Crop thumbnail
     * @return string URL path to generated thumb
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function getThumbnail($height, $width, $crop) {
        if (!isset($this->thumbnail)) {
            $this->setThumbnail($this->options->getDefaultThumbnail());
        }

        if (($height > 0 || $width > 0) && $crop) {
            $image = $this->resize($this->thumbnail, (int) $width, (int) $height, (bool) $crop);
            if (!is_wp_error($image) && !empty($image)) {
                return $image;
            }
        }
        
        return $this->thumbnail;
    }

    /**
     * Uses bfi resizer to resize image and returns url to new image
     * @param string $url
     * @param int $width
     * @param int $height
     * @param bool $crop
     * @return string
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    private function resize($url, $width = NULL, $height = NULL, $crop = true) {
        erpPROPaths::requireOnce(erpPROPaths::$bfiResizer);
        return bfi_thumb($url, array('width' => $width, 'height' => $height, 'crop' => $crop));
    }

    /**
     * If the post have thumbnail
     *
     * @return boolean
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function hasThumbnail() {
        return has_post_thumbnail($this->ID);
    }

    /**
     * Sets post thumbnail URL
     *
     * @param string $defaultThumbnail
     *        	URL to default thumbnail
     * @param string $size
     *        	Optional, default is 'single-post-thumbnail'
     * @return erpPROPostData
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function setThumbnail($defaultThumbnail, $size = 'single-post-thumbnail') {
        $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($this->ID), $size);
        $this->thumbnail = isset($thumbnail [0]) && !empty($thumbnail [0]) ? $thumbnail [0] : $defaultThumbnail;
        return $this;
    }

    /**
     * Get permalink
     *
     * @return string Permalink URL
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function getPermalink() {
        return $this->permalink;
    }

    /**
     * Sets permalink.
     * If rating system is in use modifies permalink to include from directive
     *
     * @param int $from
     *        	Host post id
     * @return \display\erpPROPostData
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    private function setPermalink($from) {
        $link = get_permalink($this->ID);
        if (strpos($link, '?') !== FALSE) {
            $this->permalink = $link . '&erp_from=' . $from;
        } else {
            $this->permalink = $link . '?erp_from=' . $from;
        }
        return $this;
    }

    /**
     * Set positions based on options (content)
     *
     * @param array $options
     *        	Assoc array
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    private function setPositions($options) {
        if (!$this->options->getContentPositioning() || !is_array($this->options->getContentPositioning())) {
            $this->positions [0] = &$this->thumbnail;
            $this->positions [1] = &$this->title;
            $this->positions [2] = &$this->excerpt;
        } else {
            foreach ($this->options->getContentPositioning() as $k => $v) {
                if ($v == 'title') {
                    $this->positions [$k] = &$this->title;
                } elseif ($v == 'thumbnail') {
                    $this->positions [$k] = &$this->thumbnail;
                } elseif ($v == 'excerpt') {
                    $this->positions [$k] = &$this->excerpt;
                }
            }
        }
    }

    /**
     * Get content that should be displayed at given position
     *
     * @param int $position
     * @return string
     * @author Panagiotis Vagenas <pan.vagenas@gmail.com>
     * @since 1.0.0
     */
    public function getContentAtPosition($position) {
        return $position [$position - 1];
    }

    public function getTheId() {
        return $this->ID;
    }

    /**
     */
    function __destruct() {
        
    }

}
