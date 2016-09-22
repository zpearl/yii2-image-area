<?php

namespace zpearl\imgarea;

use yii\web\AssetBundle;

/**
 * Description of ImageAreaAsset
 *
 * @author zpearl
 */
class UploadAreaAsset extends AssetBundle
{
    public $sourcePath = '@zpearl/imgarea/assets';
    public $css        = [
        'css/imgareaselect-default.css',
//        'css/style.css',
    ];
    public $js        = [
//        'js/uploadPreview.js',
        'js/jquery.imgareaselect.pack.js'
    ];
    public $depends    = [
    ];

}