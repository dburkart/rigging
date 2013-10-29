<?php

require_once 'abstractions/layer.php';
require_once 'abstractions/module.php';
require_once 'abstractions/view.php';

require_once 'abstractions/dependencyInjector.php';

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

		// TODO: Add support for multiple arguments to the init function.
		$this->initialModule->init();
	}

	public function render() {
		return $this->initialModule->render();
	}

	private function loadIndex() {
		require_once $this->base_dir . '/modules/index.php';
		$this->initialModule = new index( $this->base_dir );
	}
}
