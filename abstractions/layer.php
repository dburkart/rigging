<?php

abstract class Layer {

	protected $base_dir;
	protected $create;

	public function __construct( $base_dir ) {
		$this->base_dir = $base_dir;
		$this->create = new DependencyInjector( $this->base_dir, $this );
	}

	abstract public function init();
}
