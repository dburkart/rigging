<?php

/**
 * \brief Wraps the Scurvy Templater
 */

class View extends Scurvy {

	/**
	 * View overrides Scurvy::set, so as to allow the passing of Layers through
	 * (as associative arrays).
	 *
	 * \param $var the variable to set
	 * \param $val the value to set $var to
	 */
	public function set( $var, $val ) {
		$resolvedValue = $val;

		if ( is_array( $val ) ) {
			$resolvedValue = array();

			foreach ( $val as $assocArray ) {
				if ( is_a( $assocArray, 'Layer' ) ) {
					$resolvedValue[] = $this->resolveLayerToAssocArray( $assocArray );
				} else {
					$resolvedValue[] = $assocArray;
				}
			}
		}

		parent::__call( 'set', array( $var, $resolvedValue ) );
	}

	private function resolveLayerToAssocArray( $layer ) {
		$assocArray = array();
		$reflect = new ReflectionObject( $layer );

		$properties = $reflect->getProperties( 
			ReflectionMethod::IS_PUBLIC
		);

		foreach ( $properties as $property ) {
			$name = $property->getName();
			$assocArray[$name] = $layer->$name;#$layer->$property;
		}

		return $assocArray;
	}

}

/**
 * \file view.php
 */
