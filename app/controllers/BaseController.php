<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
    protected $layout = 'layouts/main';

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

    protected function res_pre($data)
    {
        return '<pre>'.
        print_r($data, true).
        '</pre>';

    }

    // helper function
    // make post array to input name
    protected function http_build_query_for_curl( $arrays, &$new = array(), $prefix = null ) {
        if ( is_object( $arrays ) ) {
            $arrays = get_object_vars( $arrays );
        }
        foreach ( $arrays AS $key => $value ) {
            $k = isset( $prefix ) ? $prefix . '[' . $key . ']' : $key;
            if ( is_array( $value ) OR is_object( $value )  ) {
                $this->http_build_query_for_curl( $value, $new, $k );
            } else {
                $new[$k] = $value;
            }
        }
    }

}