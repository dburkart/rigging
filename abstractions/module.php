<?php

/**
 * \brief Controller-like component.
 *
 * A Module is a controller-like class which encapsulates, in a sense, Layers
 * and Views. The main difference is idealogical -- a Module is designed to
 * be \a embeddable in another module.
 */

abstract class Module {

	/// The base directory in which the framework operates
	protected $base_dir;

	/// The module's view
	protected $view;

	/// The module's DependencyInjector
	protected $create;

	/**
	 * Constructor. Sets up the DependencyInjector.
	 *
	 * \param $base_dir The base-directory of the framework.
	 */
	public function __construct( $base_dir ) {
		$this->base_dir = $base_dir;
		$this->create = new DependencyInjector( $this->base_dir, $this );
	}

	/**
	 * Every module must define an initialization function. This is for ease
	 * of use more than anything, and also so that the user does not have to
	 * remember to call it's parent's constructor.
	 */
	abstract public function init();

	/**
	 * Renders the module's view. If this is the top-level module (i.e. not
	 * an embedded module), this is called by the framework itself.
	 */
	public function render() {
		if ( $this->view != NULL ) {
			return $this->view->render();
		}

		return '';
	}
}

/**
 * \file Module.php
 */