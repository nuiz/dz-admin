<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 11/9/2556
 * Time: 12:30 น.
 * To change this template use File | Settings | File Templates.
 */

exit('Only to be used as an helper for your IDE');

Class DZApi extends DZApi\DZApi {
    public static function instance(){
        return \DZApi\DZApi::instance();
    }
}