<?php

require_once 'abstractions/dependencyInjector.php';

require_once 'abstractions/layer.php';
require_once 'abstractions/view.php';
require_once 'abstractions/module.php';
require_once 'abstractions/flow.php';

class Framework extends Module {
	private $initialModule;

	public function __construct( $base_dir ) {
		parent::__construct( realpath( $base_dir ) );
		$this->init();
	}

	public function init() {
		$module = 'index';
		if ( isset( $_GET['m'] ) &&
			 file_exists( $this->base_dir . '/modules/' . $_GET['m'] . '.php' ) ) {
			$module = preg_replace( '/\.\.\//', '', $_GET['m'] );
			require_once $this->base_dir . '/modules/' . $module . '.php';

			if ( !class_exists( $module ) ) {
				$module = 'index';
			}
		}

		$this->initialModule = $this->create->module( $module );
	}

	public function render() {
		return $this->initialModule->render();
	}
}
