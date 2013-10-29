<?php

require_once 'abstractions/layer.php';
require_once 'abstractions/module.php';

class Framework {
	private $base_dir;
	private $initialModule;

	public function __construct( $base_dir ) {

		$this->base_dir = realpath( $base_dir );

		$module = 'index';
		if ( isset( $_GET['m'] ) &&
			 file_exists( $this->base_dir . '/modules/' . $_GET['m'] . '.php' ) ) {

			$module = preg_replace( '/\.\.\//', '', $_GET['m'] );
			require_once $this->base_dir . '/modules/' . $module . '.php';

			if ( class_exists( $module ) ) {
				$this->initialModule = new $module( $this->base_dir );
			} else {
				$this->loadIndex();
			}
		} else {
			$this->loadIndex();
		}
	}

	private function loadIndex() {
		require_once $this->base_dir . '/modules/index.php';
		$this->initialModule = new index( $this->base_dir );
	}
}
