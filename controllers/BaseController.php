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

}