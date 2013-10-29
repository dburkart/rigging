<?php

abstract class Layer {

	private $base_dir;

	public function __construct( $base_dir ) {
		$this->base_dir = $base_dir;
	}
	
}
