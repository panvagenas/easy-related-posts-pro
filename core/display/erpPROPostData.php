<?php

/**
 * Easy related posts PRO.
 *
 * @package   Easy_Related_Posts_Core_display
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */

/**
 * Post data class of plugin templates
 *
 * @package Easy_Related_Posts_Core_display
 * @author Your Name <email@example.com>
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
	private $positions = array ();

	/**
	 *
	 * @param WP_Post $post
	 * @param array $options
	 * @param float $rating
	 * @param int $hostPost
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function __construct( WP_Post $post, Array $options, $rating, $hostPost ) {
		$this->post = $post;
		$this->ID = $post->ID;
		$this->setTitle();
		// TODO This is called from template
		//$this->setExcerpt( $options [ 'excLength' ], $options [ 'moreTxt' ] );
		$this->rating = $rating;
		// TODO This is called from template
		//$this->setThumbnail( $options [ 'defaultThumbnail' ] );
		$this->setPermalink( $hostPost );
		$this->setPostDate( 'Y-m-d H:i:s' );
		$this->setPositions( $options );
	}
	/**
	 * Get post title
	 * @return string
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getTitle( ) {
		return $this->title;
	}
	/**
	 * Get post time
	 * @param string $timeFormat
	 * @return string Formated time
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getTheTime( $timeFormat = 'Y-m-d H:i:s' ) {
		return date( $timeFormat, strtotime( $this->postDate ) );
	}
	/**
	 * Set post date
	 *
	 * @param string $postFormat
	 * @return \display\erpPROPostData
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	private function setPostDate( $postFormat = 'Y-m-d H:i:s' ) {
		$this->postDate = get_the_time( $postFormat, $this->ID );
		return $this;
	}
	/**
	 * Set title
	 * @return \display\erpPROPostData
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	private function setTitle( ) {
		$this->title = $this->post->post_title;
		return $this;
	}
	/**
	 * Get post except
	 * @return string
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getExcerpt( ) {
		if (!isset($this->excerpt)) {
			$this->setExcerpt(erpPRODefaults::$comOpts [ 'excLength' ], erpPRODefaults::$comOpts['moreTxt']);
		}
		return $this->excerpt;
	}
	/**
	 * Set post excerpt
	 * @param int $excLength Excerpt length in words
	 * @param string $moreText More text to be displayed after post excerpt
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function setExcerpt( $excLength, $moreText ) {
		if ( !empty( $this->post->post_excerpt ) ) {
			$exc = $this->post->post_excerpt;
		} else {
			$exc = $this->post->post_content;
		}

		$exc = strip_shortcodes( $exc );
		$exc = str_replace( ']]>', ']]&gt;', $exc );
		$exc = wp_strip_all_tags( $exc );

		$tokens = explode( ' ', $exc, $excLength + 1 );

		if ( count( $tokens ) > $excLength ) {
			array_pop( $tokens );
		}

		array_push( $tokens, ' ' . $moreText );
		$exc = implode( ' ', $tokens );
		$this->excerpt = $exc;
	}

	/**
	 * Get post rating
	 * @return float
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getRating( ) {
		return $this->rating;
	}
	/**
	 * Set post rating
	 * @param float $rating
	 * @return \display\erpPROPostData
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	private function setRating( $rating ) {
		$this->rating = $rating;
		return $this;
	}
	/**
	 * Get post proccesed thumbnail
	 * @param int $height Thumbnail height
	 * @param int $width Thumbnail width
	 * @param boolean $crop Crop thumbnail
	 * @return string URL path to generated thumb
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getThumbnail( $height, $width, $crop ) {
		// TODO Set an option to diplay a default thumbnail
		erpPROPaths::requireOnce(erpPROPaths::$resize);

		if (!isset($this->thumbnail)) {
			$this->setThumbnail(erpPRODefaults::$comOpts['defaultThumbnail']);
		}

		if ( $height && $crop ) {
			// TODO Find a way to set retina
			$retina = false;
			$image = matthewruddy_image_resize( $this->thumbnail, ( int ) $width, ( int ) $height, ( bool ) $crop, $retina );
			if ( !is_wp_error( $image ) && !empty( $image ) ) {
				return $image [ 'url' ];
			}
		}
		return $this->thumbnail;
	}
	/**
	 * If the post have thumbnail
	 * @return boolean
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function hasThumbnail( ) {
		return has_post_thumbnail( $this->ID );
	}
	/**
	 * Sets post thumbnail URL
	 * @param string $defaultThumbnail URL to default thumbnail
	 * @param string $size Optional, default is 'single-post-thumbnail'
	 * @return erpPROPostData
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function setThumbnail( $defaultThumbnail, $size = 'single-post-thumbnail' ) {
		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $this->ID ), $size );
		$this->thumbnail = isset( $thumbnail [ 0 ] ) ? $thumbnail [ 0 ] : $defaultThumbnail;
		return $this;
	}
	/**
	 * Get permalink
	 * @return string Permalink URL
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getPermalink( ) {
		return $this->permalink;
	}
	/**
	 * Sets permalink. If rating system is in use modifies permalink to include from directive
	 * @param int $from Host post id
	 * @return \display\erpPROPostData
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	private function setPermalink( $from ) {
		$link = get_permalink( $this->ID );
// 		if ( !easyRelatedPostsPRO::get_instance()->isRatingSystemOn() ) {
// 			$this->permalink = $link;
// 		} else
		if ( strpos( $link, '?' ) !== FALSE ) {
			$this->permalink = $link . '&erp_from=' . $from;
		} else {
			$this->permalink = $link . '?erp_from=' . $from;
		}
		return $this;
	}
	/**
	 * Set positions based on options (content)
	 * @param array $options Assoc array
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	private function setPositions( $options ) {
		if ( !isset( $options [ 'content' ] ) ) {
			$this->positions [ 0 ] = &$this->thumbnail;
			$this->positions [ 1 ] = &$this->title;
			$this->positions [ 2 ] = &$this->excerpt;
		} else {
			foreach ( $options [ 'content' ] as $k => $v ) {
				if ( $v == 'title' ) {
					$this->positions [ $k ] = &$this->title;
				} elseif ( $v == 'thumbnail' ) {
					$this->positions [ $k ] = &$this->thumbnail;
				} elseif ( $v == 'excerpt' ) {
					$this->positions [ $k ] = &$this->excerpt;
				}
			}
		}
	}
	/**
	 * Get content that should be displayed at given position
	 * @param int $position
	 * @return string
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getContentAtPosition( $position ) {
		return $position [ $position - 1 ];
	}

	public function getTheId(){
		return $this->ID;
	}

	/**
	 */
	function __destruct( ) {
	}
}

?>