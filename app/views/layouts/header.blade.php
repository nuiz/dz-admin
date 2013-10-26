<?php
/**
 * Created by JetBrains PhpStorm.
 * User: P2DC
 * Date: 9/10/2556
 * Time: 10:34 น.
 * To change this template use File | Settings | File Templates.
 */
?>
<?php
if(isset($breadcrumbs)){
    $i = 0;
    foreach($breadcrumbs as $key => $value) {
        if($i!=0){
            echo " >> ";
        }
        echo <<<HTML
    <a href="{$value}">{$key}</a>
HTML;
        $i++;
    }
}
if(isset($add)){
    echo <<<HTML
 <a href="{$add}" class="glyphicon glyphicon-plus-sign create-class add-on-header"></a>
HTML;

}
?>
<style type="text/css">

</style>
<a href="" class="glyphicon glyphicon-envelope notification-button">
    <span class="badge all-notify-count" style="position: absolute;
top: 30px;
left: 10px;
zoom: 0.5;"></span>
</a>