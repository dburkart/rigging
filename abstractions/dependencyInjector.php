<?php

/**
 * \brief Finds and manages dependencies
 */

class DependencyInjector {
	private $base_dir;
	private $client;

	public function __construct( $base_dir, $client ) {
		$this->base_dir = $base_dir;
		$this->client = $client;
	}

	public function layer( $layerName ) {
		$layerDir = $this->base_dir . '/layers/';
		$layerPath = $layerDir . $layerName . '.php';

		// Error out if we can't find the layer.
		if ( !file_exists( $layerPath ) ) {
			trigger_error( "Cannot locate $layerName.php. (search path: $this->base_dir/layers)", E_USER_ERROR );
		}

		require_once $layerPath;

		// There's gotta be a class here!
		if ( !class_exists( $layerName ) ) {
			trigger_error( "Could not find a class named '$layerName'.", E_USER_ERROR );
		}

		$layer = new $layerName( $this->base_dir );
		$reflect = new ReflectionObject( $layer );

		// Make sure it's actually a layer
		if ( !is_a( $layer, 'Layer' ) ) {
			trigger_error( "Class '$layerName' must extend Layer.", E_USER_ERROR );
		}

		// TODO: Handle multiple arguments to init()

		$layer->init();

		// Check for a post-init function
		if ( $reflect->hasMethod( '___POST_INIT' ) ) {
			$layer->___POST_INIT();
		}

		return $layer;
	}

	public function module( $moduleName ) {
		if ( !is_a( $this->client, 'Module' ) ) {
			throw new Exception( 'Only modules are allowed to create modules.' );
		}

		$moduleDir = $this->base_dir . '/modules/';
		$modulePath = $moduleDir . $moduleName . '.php';

		// If the file doesn't exist, print a helpful error, and return false
		if ( !file_exists( $modulePath ) ) {
			trigger_error( "Cannot locate $moduleName.php. (search path: $this->base_dir/modules)", E_USER_ERROR );
		}
		
		require_once $modulePath;

		// If we don't have the requisite class, print another error
		if ( !class_exists( $moduleName ) ) {
			trigger_error( "Cannot find class named '$moduleName].", E_USER_ERROR );
		}

		$module = new $moduleName( $this->base_dir );
		$reflect = new ReflectionObject( $module );

		// The module we're loading must subclass Module!
		if ( !is_a( $module, 'Module' ) ) {
			trigger_error( "Class '$moduleName' must extend Module.", E_USER_ERROR );
		}

		// TODO: Handle multiple arguments to init()

		$module->init();

		// Check for a post-init function
		if ( $reflect->hasMethod( '___POST_INIT' ) ) {
			$module->___POST_INIT();
		}

		return $module;
	}

	public function view( $viewName ) {
		if ( !is_a( $this->client, 'Module' ) ) {
			throw new Exception( 'Only modules and views are allowed to create views.' );
		}

		$templateDir = $this->base_dir . '/views/';

		if ( file_exists( $templateDir . $viewName ) ) {
			return new View( $viewName, $templateDir, true, $viewName );
		} else {
			trigger_error( "Cannot find view: '$viewName'", E_USER_ERROR );
		}
	}
}

/**
 * \file dependencyInjector.php
 */
