<?php

abstract class Module {

	protected $base_dir;
	protected $view;
	protected $create;

	public function __construct( $base_dir ) {
		$this->base_dir = $base_dir;
		$this->create = new DependencyInjector( $this->base_dir, $this );
	}

	abstract public function init();

	public function render() {
		if ( $this->view != NULL ) {
			return $this->view->render();
		}

		return '';
	}
}
