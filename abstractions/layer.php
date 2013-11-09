<?php

/**
 * \brief Model-like abstraction
 * 
 * A Layer is like a \a Model from the MVC paradigm. The main difference is
 * that when writing a web-app, this usually means we are interacting with
 * some datastore. As such, a Layer is a 'layer' which represents some
 * class of data.
 */

abstract class Layer {

	protected $base_dir;
	protected $create;

	public function __construct( $base_dir ) {
		$this->base_dir = $base_dir;
		$this->create = new DependencyInjector( $this->base_dir, $this );
	}

	abstract public function init();
}

/**
 * \file layer.php
 */