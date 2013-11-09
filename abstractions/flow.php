<?php

/**
 * \brief Specialized Module representing a user-interaction.
 *
 * A Flow is a special kind of Module which makes creating flow-like user
 * interactions a bit easier. For example, creating a form with several steps
 * is super easy using the Flow module, and the entire logic can be
 * encapsulated within one Module.
 */

abstract class Flow extends Module {
	private $actions = array();
	private $action;

	public function __construct( $base_dir ) {
		parent::__construct( $base_dir );
	}

	/**
	 * \brief Post-init hook to route actions
	 *
	 * We define a ___POST_INIT hook which will invoke route()
	 */
	public function ___POST_INIT() {
		$this->route();
	}

	/**
	 * \brief Register an action
	 *
	 * Register an action, or set of actions. These should correspond to
	 * functions defined in the class which subclasses this flow.
	 *
	 * \param $mixedAction a single action, or an array of actions
	 */
	protected function register( $mixedAction ) {
		if ( is_array( $mixedAction ) ) {
			$this->actions = $mixedAction;
		} else {
			$this->actions[] = $mixedAction;
		}
	}

	/**
	 * \brief Route a requested action to the correct function
	 *
	 * The route function looks at $_REQUEST['act'] and determines if a
	 * corresponding function exists. If it does, the action is called into.
	 */
	protected function route() {
		if ( !empty( $_REQUEST['act'] ) ) {
			$this->action = mysql_escape_string( $_REQUEST['act'] );

			if ( in_array( $this->action, $this->actions ) ) {
				$function = $this->action;
				$class = get_class( $this );

				try {
					$reflect = new ReflectionMethod( $class, $function );
				} catch ( ReflectionException $e ) {
					trigger_error( "Action method '$function()' is not defined in Class $class.", E_USER_ERROR );
				}

				$this->$function();
			}
		}
	}
}

/**
 * \file flow.php
 */