<?php

function validateSCGridOptions( $options ) {
	$newOptions = array (
			'numOfPostsPerRow' => isset( $options [ 'numOfPostsPerRow' ] ) ? ( int ) $options [ 'numOfPostsPerRow' ] : 3,
			'thumbCaption' => isset( $options [ 'thumbCaption' ] )
	);
	return $newOptions;
}