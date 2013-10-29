<?php

abstract class Flow extends Module {
	private $actions = array();
	private $action;

	public function __construct( $base_dir ) {
		parent::__construct( $base_dir );
	}

	protected function register( $mixedAction ) {
		if ( is_array( $mixedAction ) ) {
			$this->actions = $mixedAction;
		} else {
			$this->actions[] = $mixedAction;
		}
	}

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