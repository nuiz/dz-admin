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
 <a href="{$add}" class="glyphicon glyphicon-plus-sign create-class"></a>
HTML;

}