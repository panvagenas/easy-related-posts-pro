<?php


/**
 * Easy related posts PRO.
 *
 * @package Easy_Related_Posts_Related
 * @author Your Name <email@example.com>
 * @license GPL-2.0+
 * @link http://example.com
 * @copyright 2014 Your Name or Company Name
 */

/**
 * Query formater class.
 *
 * @package Easy_Related_Posts_Related
 * @author Your Name <email@example.com>
 */
class erpPROQueryFormater {

	/**
	 * Post id
	 *
	 * @since 1.0.0
	 * @var int
	 */
	private $pid;

	/**
	 * argument array
	 *
	 * @since 1.0.0
	 * @var array;
	 */
	private $argsArray = array ();

	/**
	 * Tags array
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $tags = array ();

	/**
	 * Cats array
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $categories = array ();

	/**
	 * post types array
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $postTypes = array ();

	/**
	 * vissited posts
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $visitedPosts = array ();

	/**
	 * query limit
	 *
	 * @since 1.0.0
	 * @var int
	 */
	private $queryLimit = 10;

	/**
	 * Query offset
	 *
	 * @since 1.0.0
	 * @var int
	 */
	private $queryOffset = 0;

	/**
	 * Post in array
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $postIn = array ();

	/**
	 * Return arguments array
	 *
	 * @return array;
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function getArgsArray( ) {
		return $this->argsArray;
	}

	/**
	 * Sets main query arguments.
	 * These are: post_status, perm, post_visibility,
	 * ignore_sticky_posts, post__not_in, orderby, order.
	 * Also limits the query based in $this->queryLimit value
	 *
	 * @param int $pid
	 * @param string $orderBy
	 * @param string $order
	 * @param int $limit
	 *        	limits the fetched post default 10
	 * @param int $offset
	 *        	Default 0
	 * @return erpPROQueryFormater
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since
	 *
	 *
	 */
	public function setMainArgs( $pid, $limit = 10, $offset = 0, $orderBy = 'date', $order = 'DESC' ) {
		if ( $this->pid != $pid ) {
			$this->clearQueryArgs();
		}
		$this->setQueryLimit( $limit, $offset );

		if ( !has_filter( 'post_limits', array (
				$this,
				'limitPosts'
		) ) ) {
			add_filter( 'post_limits', array (
					$this,
					'limitPosts'
			) );
		}

		$this->argsArray [ 'post_status' ] = 'publish';
		$this->argsArray [ 'perm' ] = 'readable';
		$this->argsArray [ 'post_visibility' ] = 'public';
		$this->argsArray [ 'ignore_sticky_posts' ] = 1;
		$this->argsArray [ 'post__not_in' ] = ( array ) $pid;
		$this->argsArray [ 'orderby' ] = $orderBy;
		$this->argsArray [ 'order' ] = $order;

		return $this;
	}

	/**
	 * Resets class arguments to default values
	 *
	 * @return erpPROQueryFormater
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function clearQueryArgs( ) {
		$this->argsArray = array ();
		$this->categories = array ();
		$this->postIn = array ();
		$this->postTypes = array ();
		$this->queryLimit = 10;
		$this->queryOffset = 0;
		$this->tags = array ();
		$this->visitedPosts = array ();
		return $this;
	}

	/**
	 * Sets tags in query args array
	 *
	 * @param array $tags
	 *        	Array of tags object
	 * @param string $operator
	 *        	WP_Query tags operator
	 * @return erpPROQueryFormater
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function setTags( $tags, $operator = 'in' ) {
		if ( !empty( $tags ) ) {
			if ( gettype( end( $tags ) ) == 'object' ) {
				$temp = array ();
				foreach ( $tags as $k => $v ) {
					$temp [ $k ] = $v->term_id;
				}
				$tags = $temp;
			}
			$this->argsArray [ 'tag__' . $operator ] = $tags;
			$this->tags [ $operator ] = $tags;
		}
		return $this;
	}

	/**
	 * Excludes tags that are setted in plugin options
	 *
	 * @return erpPROQueryFormater
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function exTags( $tags ) {
		if ( !empty( $tags ) && $tags ) {
			$this->setTags( $tags, 'not_in' );
		}
		return $this;
	}

	/**
	 * Clears any tag filters in args array
	 *
	 * @return erpPROQueryFormater
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function clearTags( ) {
		$filters = array (
				'tag',
				'tag_id',
				'tag__and',
				'tag__in',
				'tag__not_in',
				'tag_slug__and',
				'tag_slug__in'
		);
		foreach ( $filters as $k => $v ) {
			unset( $this->argsArray [ $v ] );
		}
		$this->tags = array ();
		return $this;
	}

	/**
	 * Sets categories in query args array
	 *
	 * @param array $categories
	 *        	Array of categories object
	 * @param string $operator
	 *        	WP_Query categories operator
	 * @return erpPROQueryFormater
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function setCategories( $categories, $operator = 'in' ) {
		if ( !empty( $categories ) ) {
			if ( gettype( end( $categories ) ) == 'object' ) {
				$temp = array ();
				foreach ( $categories as $k => $v ) {
					$temp [ $k ] = $v->term_id;
				}
				$categories = $temp;
			}
			$this->argsArray [ 'category__' . $operator ] = $categories;
			$this->categories [ $operator ] = $categories;
		}
		return $this;
	}

	/**
	 * Excludes categories
	 *
	 * @param array $categories
	 *        	Array of categories obj
	 * @return erpPROQueryFormater
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function exCategories( $categories ) {
		if ( !empty( $categories ) && $categories ) {
			$this->setCategories( $categories, 'not_in' );
		}
		return $this;
	}

	/**
	 * Clears any categories filters in args array
	 *
	 * @return erpPROQueryFormater
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function clearCategories( ) {
		$filters = array (
				'cat',
				'category_name',
				'category__and',
				'category__in',
				'category__not_in'
		);
		foreach ( $filters as $k => $v ) {
			unset( $this->argsArray [ $v ] );
		}
		$this->categories = array ();
		return $this;
	}

	/**
	 * Clears post_type argument in args array
	 *
	 * @return erpPROQueryFormater
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function clearPostTypes( ) {
		unset( $this->argsArray [ 'post_type' ] );
		$this->postTypes = array ();
		return $this;
	}

	/**
	 * Excludes post types
	 *
	 * @param array $post_types
	 * @return erpPROQueryFormater
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function exPostTypes( $post_types ) {
		if ( isset( $post_types ) && !empty( $post_types ) ) {
			$post_typ = get_post_types();
			foreach ( $post_types as $key => $value ) {
				unset( $post_typ [ $value ] );
			}
			$this->argsArray [ 'post_type' ] = $post_typ;
			$this->postTypes = $post_typ;
		}
		return $this;
	}

	/**
	 * Excludes the visited posts by setting post__not_in argument in WP_Query
	 *
	 * @param
	 *        	<array, string> $visited If is a string tries to unserializeit
	 * @return erpPROQueryFormater
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function exVisitedPosts( $visited ) {
		if ( is_string( $visited ) ) {
			$visited = unserialize( $visited );
		}
		if ( isset( $visited ) ) {
			if ( isset( $this->argsArray [ 'post__not_in' ] ) ) {
				$this->argsArray [ 'post__not_in' ] = array_merge( $this->argsArray [ 'post__not_in' ], $visited );
			} else {
				$this->argsArray [ 'post__not_in' ] = $visited;
			}
		}
		return $this;
	}

	/**
	 * Limits posts in WP query.
	 * !IMPORTAND! This is an action hook, not to be called directly.
	 * $this->queryLimit must be set in order to actually work
	 *
	 * @param int $limit
	 * @return string
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function limitPosts( $limit ) {
		if ( $this->queryLimit > 0 ) {
			if ( $this->queryOffset > 0 ) {
				$offset = $this->offset;
			} else {
				$offset = 0;
			}
			return 'LIMIT ' . $offset . ', ' . $this->queryLimit;
		}
		return $limit;
	}

	/**
	 * Sets post__in param in args array
	 *
	 * @param array $postsIds
	 * @return erpPROQueryFormater
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function setPostInArg( Array $postsIds ) {
		$this->argsArray [ 'post__in' ] = $postsIds;
		$this->postIn = $postsIds;
		return $this;
	}

	/**
	 * Unsets post__in param
	 *
	 * @return erpPROQueryFormater
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function clearPostInParam( ) {
		$this->postIn = array ();
		unset( $this->argsArray [ 'post__in' ] );
		return $this;
	}

	/**
	 * Sets $this->queryLimit and $this->queryOffset
	 *
	 * @param int $limit
	 * @param int $offset
	 * @return erpPROQueryFormater
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	public function setQueryLimit( $limit, $offset ) {
		$this->queryLimit = $limit;
		$this->queryOffset = $offset;
		return $this;
	}
}