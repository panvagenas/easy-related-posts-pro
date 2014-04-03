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
 * Related class.
 *
 * @package Easy_Related_Posts_Related
 * @author Your Name <email@example.com>
 */
class erpProRelated {

	/**
	 * Relative data obj
	 *
	 * @since 1.0.0
	 * @var erpPRORelData
	 */
	private $relData;

	/**
	 * Pool of reldata objects
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $relDataPool = array ();

	/**
	 * Options array.
	 * All critical must be set
	 *
	 * @since 1.0.0
	 * @var erpPROOptions
	 */
	private $options = array ();

	/**
	 * DB actions obj
	 *
	 * @since 1.0.0
	 * @var erpPRODBActions
	 */
	private $dbActions;

	/**
	 * WP_Session obj
	 *
	 * @since 1.0.0
	 * @var WP_Session
	 */
	private $wpSession;

	/**
	 * Instance of this class.
	 *
	 * @since 1.0.0
	 * @var erpProRelated
	 */
	protected static $instance = null;

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 * @return erpProRelated A single instance of this class.
	 */
	public static function get_instance( &$options ) {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self( $options );
		}
		self::$instance->options = $options;
		return self::$instance;
	}

	/**
	 *
	 * @param array $options
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	protected function __construct( $options ) {
		if ( !class_exists( 'erpPROQueryFormater' ) ) {
			erpPROPaths::requireOnce( erpPROPaths::$erpPROQueryFormater );
		}
		if ( !class_exists( 'erpPRODBActions' ) ) {
			erpPROPaths::requireOnce( erpPROPaths::$erpPRODBActions );
		}
		if ( !class_exists( 'erpPRORatingSystem' ) ) {
			erpPROPaths::requireOnce( erpPROPaths::$erpPRORatingSystem );
		}
		if ( !class_exists( 'erpPRORelData' ) ) {
			erpPROPaths::requireOnce( erpPROPaths::$erpPRORelData );
		}
		$this->options = $options;
		$this->dbActions = erpPRODBActions::getInstance();
		$this->wpSession = WP_Session::get_instance();
	}

	public function getRelated( $pid ) {
		// TODO Remove debug
		do_action( 'debug', __FUNCTION__ . ' Started' );
		/**
		 * Check if we have a reldata obj with same query and if yes return it
		 */
		foreach ( $this->relDataPool as $key => $value ) {
			$missMatch = $value->criticalOptionsMismatch( $this->options->getOptions() );
			if ( empty( $missMatch ) ) {
				$this->relData = $value;
				// TODO Remove debug
				do_action( 'debug', 'getRelated found rel in pool' );
				return $this->relData->getResult();
			}
		}
		// Check if we have relTable in pool
		foreach ( $this->relDataPool as $key => $value ) {
			if ($value->pid == $pid) {
				$relTable = $value->relTable;
				// TODO Remove debug
				do_action( 'debug', 'getRelated found relTable in pool' );
				break;
			}
		}
		// If we couldn't get a relTable search in cache
		if (!isset($relTable)) {
			$relTable = $this->dbActions->getAllOccurrences( $pid );
		}

		// TODO Remove debug
		do_action( 'debug', __FUNCTION__ . ' creating rel data obj' );
		$criticalOptions = array_intersect_key( $this->options->getOptions(), array_flip( erpPRODefaults::$criticalOpts ) );
		$this->relData = new erpPRORelData( $pid, $criticalOptions, $relTable );
		/**
		 * If no cached ratings or not the required number of posts
		 */
		if ( empty( $relTable ) || count( $relTable ) < $this->options->getNumberOfPostsToDiplay() || !$this->isPostProcesed( $pid, $relTable ) ) {
			// TODO Remove debug
			do_action( 'debug', __FUNCTION__ . ' doing rating' );
			$relTable = $this->doRating( $pid );
			// TODO Remove debug
			do_action( 'debug', __FUNCTION__ . ' did new rating, posts related: ' . count( $relTable ) );
		} else {
			// TODO Remove debug
			do_action( 'debug', __FUNCTION__ . ' found rel in cache, posts related: ' . count( $relTable ) );
		}

		/**
		 * If reltable is still empty return an empty wp_query obj
		 */
		if ( empty( $relTable ) ) {
			// TODO Remove debug
			do_action( 'debug', 'getRelated no rel in pool, no rel in cache and empty reltable. returning empty object' );
			// Normally this should return an empty wp_query
			return $this->relData->getResult();
		}

		// TODO Remove debug
		do_action( 'debug', __FUNCTION__ . ' setting rel table in reldata' );
		$this->relData->setRelTable( $relTable );
		$ratingSystem = erpPRORatingSystem::get_instance( $this->relData );
		// TODO Remove debug
		do_action( 'debug', __FUNCTION__ . ' calculating weights' );
		$weights = $this->calcWeights();
		// TODO Remove debug
		do_action( 'debug', __FUNCTION__ . ' setting weights' );
		$ratingSystem->setWeights( $weights );
		// TODO Remove debug
		do_action( 'debug', __FUNCTION__ . ' forming rating arrays' );
		$ratingSystem->formRatingsArrays();
		// TODO Remove debug
		do_action( 'debug', __FUNCTION__ . ' sorting rating arrays' );
		$ratingSystem->sortRatingsArrays( $this->options->getSortRelatedBy(true) );
		// TODO Remove debug
		do_action( 'debug', __FUNCTION__ . ' forming wp query args' );
		$postsToExclude = isset( $this->wpSession [ 'visited' ] ) ? unserialize( $this->wpSession [ 'visited' ] ) : array ();
		$slicedArray = $ratingSystem->getSlicedRatingsArrayFlat( $this->options->getOffset(), $this->options->getNumberOfPostsToDiplay(), $postsToExclude );
		$qForm = new erpPROQueryFormater();
		$qForm->setMainArgs( $pid );
		$qForm->setPostInArg( array_keys( $slicedArray ) );
		$this->relData->setWP_Query( $qForm->getArgsArray(), $this->options->getNumberOfPostsToDiplay(), $this->options->getOffset() );
		// TODO Remove debug
		do_action( 'debug', __FUNCTION__ . ' getting result' );
		$this->relData->getResult();
		// TODO Remove debug
		do_action( 'debug', __FUNCTION__ . ' sorting result' );
		$this->relData->setRatings( $slicedArray );
		$this->relData->sortWPQuery( array_keys( $slicedArray ) );
		// TODO Remove debug
		do_action( 'debug', __FUNCTION__ . ' storing reldata to pool' );
		array_push( $this->relDataPool, $this->relData );
		return $this->relData->getResult();
	}

	public function isPostProcesed( $pid, $relTable = null ) {
		if ( empty( $relTable ) ) {
			$relTable = $this->dbActions->getAllOccurrences( $pid );
		}
		foreach ( $relTable as $key => $value ) {
			if ( $value [ 'pid1' ] == $pid ) {
				return true;
			}
		}
		return false;
	}

	public function doRating( $pid ) {
		$qForm = new erpPROQueryFormater();
		$ratingSystem = erpPRORatingSystem::get_instance( $this->relData );
// 		$ratingSystemIsOn = easyRelatedPostsPRO::get_instance()->isRatingSystemOn();
		// TODO Maybe query limit should follow a dif approach

		$queryLimit = $this->options->getValue( 'queryLimit' );

		if ( isset( $queryLimit ) ) {
			$qForm->setMainArgs( $pid, $queryLimit );
		} else {
			$qForm->setMainArgs( $pid, 100 );
		}

		$postCats = get_the_category( $pid );
		$postTags = get_the_tags( $pid );
		$relTable = array ();
		// TODO Implement function to keep only the n best rated posts
		if ( !empty( $postCats ) ) {
			$qForm->setCategories( $postCats );

			$qForm->exPostTypes( $this->options->getValue( 'postTypes' ) )
				->exCategories($this->options->getValue('categories'))
				->exTags($this->options->getValue('tags'));

			$wpq = new WP_Query( $qForm->getArgsArray() );
			$postsArray = $wpq->posts;
			if ( !empty( $postsArray ) ) {
				foreach ( $postsArray as $key => $value ) {
					$relTable [ $value->ID ] [ 'score2_cats' ] = $ratingSystem->rateBasedOnCats( $pid, $value->ID );
					$relTable [ $value->ID ] [ 'score1_cats' ] = $ratingSystem->rateBasedOnCats( $value->ID, $pid );
					$relTable [ $value->ID ] [ 'score2_tags' ] = $ratingSystem->rateBasedOnTags( $pid, $value->ID );
					$relTable [ $value->ID ] [ 'score1_tags' ] = $ratingSystem->rateBasedOnTags( $value->ID, $pid );
					$relTable [ $value->ID ] [ 'post_date1' ] = get_the_time( 'Y-m-d', $pid );
					$relTable [ $value->ID ] [ 'post_date2' ] = get_the_time( 'Y-m-d', $value->ID );
// 					if ( $ratingSystemIsOn ) {
						$this->dbActions->insertRecToRel( $pid, $value->ID, $relTable [ $value->ID ] );
// 					}
					$relTable [ $value->ID ] [ 'pid1' ] = $pid;
					$relTable [ $value->ID ] [ 'pid2' ] = $value->ID;
				}
			}
		}
		if ( !empty( $postTags ) ) {
			$qForm->setTags( $postTags );
			$qForm->exPostTypes( $this->options->getValue( 'postTypes' ) )
				->exCategories($this->options->getValue('categories'))
				->exTags($this->options->getValue('tags'));

			$wpq = new WP_Query( $qForm->getArgsArray() );
			$postsArray = $wpq->posts;
			if ( !empty( $postsArray ) ) {
				$inserted = array_keys( $relTable );
				foreach ( $postsArray as $key => $value ) {
					if ( !in_array( $value->ID, $inserted ) ) {
						$relTable [ $value->ID ] [ 'score2_cats' ] = $ratingSystem->rateBasedOnCats( $pid, $value->ID );
						$relTable [ $value->ID ] [ 'score1_cats' ] = $ratingSystem->rateBasedOnCats( $value->ID, $pid );
						$relTable [ $value->ID ] [ 'score2_tags' ] = $ratingSystem->rateBasedOnTags( $pid, $value->ID );
						$relTable [ $value->ID ] [ 'score1_tags' ] = $ratingSystem->rateBasedOnTags( $value->ID, $pid );
						$relTable [ $value->ID ] [ 'post_date1' ] = get_the_time( 'Y-m-d H:i:s', $pid );
						$relTable [ $value->ID ] [ 'post_date2' ] = get_the_time( 'Y-m-d H:i:s', $value->ID );
// 						if ( $ratingSystemIsOn ) {
							$this->dbActions->insertRecToRel( $pid, $value->ID, $relTable [ $value->ID ] );
// 						}
						$relTable [ $value->ID ] [ 'pid1' ] = $pid;
						$relTable [ $value->ID ] [ 'pid2' ] = $value->ID;
					}
				}
			}
		}
		// if ($ratingSystemIsOn) {
		// $best = $this->chooseTheBest($pid, $relTable);
		// foreach ($relTable as $key => $value) {
		// if (in_array($value['pid2'], $best)) {
		// $this->dbActions->insertRecToRel($pid, $value['pid2'], $relTable[$value['pid2']]);
		// } else {
		// unset($relTable[$value['pid2']]);
		// }
		// }
		// }
		return $relTable;
	}

	/**
	 * TODO This should check the best for both posts
	 *
	 * @param unknown $pid
	 * @param unknown $relTable
	 * @return multitype:
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	private function chooseTheBest( $pid, $relTable ) {
		$relData = new erpPRORelData( $pid, erpPRODefaults::$criticalOpts, $relTable );
		$ratingSystem = erpPRORatingSystem::get_instance( $relData );

		$ratingSystem->formRatingsArrays();
		$ratingsFlatenedPool = array ();
		/**
		 * Get the best based on categories and for all sorting options
		 */
		$weights [ 'categories' ] = 1;
		$weights [ 'tags' ] = 0;
		$weights [ 'clicks' ] = 0;
		$ratingSystem->setWeights( $weights );
		foreach ( erpPRODefaults::$sortRelatedByOption as $key => $value ) {
			$ratingSystem->sortRatingsArrays( $value );
			foreach ( array_keys( $ratingSystem->getSlicedRatingsArrayFlat( 0, 15 ) ) as $k => $v ) {
				if ( !in_array( $v, $ratingsFlatenedPool ) ) {
					array_push( $ratingsFlatenedPool, $v );
				}
			}
		}
		/**
		 * Get the best based on tags and for all sorting options
		 */
		$weights [ 'categories' ] = 0;
		$weights [ 'tags' ] = 1;
		$weights [ 'clicks' ] = 0;
		$ratingSystem->setWeights( $weights );
		foreach ( erpPRODefaults::$sortRelatedByOption as $key => $value ) {
			$ratingSystem->sortRatingsArrays( $value );
			foreach ( array_keys( $ratingSystem->getSlicedRatingsArrayFlat( 0, 15 ) ) as $k => $v ) {
				if ( !in_array( $v, $ratingsFlatenedPool ) ) {
					array_push( $ratingsFlatenedPool, $v );
				}
			}
		}
		/**
		 * Find array intersections
		 */
		/**
		 * return the result
		 */
		return $ratingsFlatenedPool;
	}

	/**
	 * Calculates weights based on options
	 *
	 * @return array Assoc array (categories,tags,clicks)
	 * @author Vagenas Panagiotis <pan.vagenas@gmail.com>
	 * @since 1.0.0
	 */
	private function calcWeights( ) {
		$weights = array ();
		/**
		 * TODO This must be instance specific.
		 * Check local options for this
		 */
// 		if ( easyRelatedPostsPRO::get_instance()->isRatingSystemOn() == TRUE ) {
			$weights [ 'clicks' ] = 0.15;
			if ( $this->options->getFetchBy() == 'tags_first_then_categories' ) {
				$weights [ 'categories' ] = 0.25;
				$weights [ 'tags' ] = 0.60;
			} elseif ( $this->options->getFetchBy() == 'tags' ) {
				$weights [ 'categories' ] = 0;
				$weights [ 'tags' ] = 0.85;
			} elseif ( $this->options->getFetchBy() == 'categories_first_then_tags' ) {
				$weights [ 'categories' ] = 0.60;
				$weights [ 'tags' ] = 0.25;
			} else {
				$weights [ 'categories' ] = 0.85;
				$weights [ 'tags' ] = 0;
			}
// 		} else {
// 			$weights [ 'clicks' ] = 0;
// 			if ( $this->options [ 'fetchBy' ] == 'tags_first_then_categories' ) {
// 				$weights [ 'categories' ] = 0.3;
// 				$weights [ 'tags' ] = 0.7;
// 			} elseif ( $this->options [ 'fetchBy' ] == 'tags' ) {
// 				$weights [ 'categories' ] = 0;
// 				$weights [ 'tags' ] = 1;
// 			} elseif ( $this->options [ 'fetchBy' ] == 'categories_first_then_tags' ) {
// 				$weights [ 'categories' ] = 0.7;
// 				$weights [ 'tags' ] = 0.3;
// 			} else {
// 				$weights [ 'categories' ] = 1;
// 				$weights [ 'tags' ] = 0;
// 			}
// 		}
		return $weights;
	}

	private function getCachedRatings( $pid ) {
		return $this->dbActions->getAllOccurrences( $pid );
	}

	public function isInPool( $pid ) {
		foreach ( $this->relDataPool as $k => $v ) {
			if ( $v->pid == $pid ) {
				return $k;
			}
		}
		return false;
	}

	public function getRatingsFromRelDataObj( ) {
		return $this->relData->getRatings();
	}
}