<?php

class DependencyInjector {
	private $base_dir;
	private $client;

	public function __construct( $base_dir, $client ) {
		$this->base_dir = $base_dir;
		$this->client = $client;
	}

	public function layer( $layerName ) {

	}

	public function module( $moduleName ) {
		if ( !is_a( $this->client, 'Module' ) ) {
			throw new Exception( 'Only modules are allowed to create modules.' );
		}
	}

	public function view( $viewName ) {
		if ( !is_a( $this->client, 'Module' ) ) {
			throw new Exception( 'Only modules and views are allowed to create views.' );
		}

		$templateDir = $this->base_dir . '/views/';

		if ( file_exists( $templateDir . $viewName ) ) {
			return new View( $viewName, $templateDir, true, $viewName );
		} else {
			trigger_error( "Cannot find view: $viewName" );
			return false;
		}
	}
}