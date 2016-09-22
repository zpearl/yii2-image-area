<?php

namespace zpearl\imgarea;

use yii\widgets\InputWidget;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\web\View;

/**
 * This is just an example.
 */
class UploadArea extends InputWidget
{
    /**
     * @var array Attribute name that content information about crop image.
     */
    public $attributeCropInfo;

    /**
     * @var array Options of jQuery plugin.
     */
    public $pluginOptions = [];

    /**
     * @string URL to image for display before upload to original URL.
     */
    public $originalImageUrl;

    /**
     * @var array URL to images for display before upload to preview URL.
     *
     * Example:
     * [
     *      '/uploads/1.png',
     *      '/uploads/2.png',
     * ];
     *
     * or simply string to image.
     */
    public $previewImagesUrl;

    /**
     * @var string Path to view of cropbox field.
     *
     * Example: '@app/path/to/view'
     */
    public $pathToView = 'field';

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        UploadAreaAsset::register($this->view);
        /**
          $this->pluginOptions                           = array_merge([
          'selectors'    => [
          'inputFile'       => '#'.$this->id.' input[type="file"]',
          'btnCrop'         => '#'.$this->id.' .btn-crop',
          'btnReset'        => '#'.$this->id.' .btn-reset',
          'resultContainer' => '#'.$this->id.' .cropped',
          'messageBlock'    => '#'.$this->id.' .alert',
          ],
          'imageOptions' => [
          'class' => 'img-thumbnail',
          ],
          ], $this->pluginOptions);
          $this->pluginOptions['selectors']['inputInfo'] = '#'
          .$this->id
          .' input[name="'
          .Html::getInputName($this->model, $this->attributeCropInfo)
          .'"]';

          $optionsCropbox = Json::encode($this->pluginOptions);

         *
         */
        $js = "
var image_holder = $('#image-holder');

$('#{$this->options['id']}').on('change', function () {
    if (typeof (FileReader) != 'undefined') {
        image_holder.empty();

        var reader = new FileReader();
        reader.onload = function (e) {
            $('<img />', {
                'src': e.target.result,
                'class': 'thumb-image'
            }).appendTo(image_holder);

            image_holder.imgAreaSelect({
                handles: true,
                onSelectEnd: handleCoords
            });
        }
        image_holder.show();
        if ($(this)[0].files[0]) {
            reader.readAsDataURL($(this)[0].files[0]);
        }
    } else {
        alert('This browser does not support FileReader.');
    }
});

if ('{$this->model->path}') {
    image_holder.imgAreaSelect({
        x1: '{$this->model->image_x1}',
        y1: '{$this->model->image_y1}',
        x2: '{$this->model->image_x2}',
        y2: '{$this->model->image_y2}',
        handles: true,
        onSelectEnd: handleCoords,
    });
}
var handleCoords = function(img, selection) {
    if (!selection.width || !selection.height)
        return;

    var scaleX = 100 / selection.width;
    var scaleY = 100 / selection.height;

    $('#preview img').css({
        width: Math.round(scaleX * 300),
        height: Math.round(scaleY * 300),
        marginLeft: -Math.round(scaleX * selection.x1),
        marginTop: -Math.round(scaleY * selection.y1)
    });

    $('#".Html::getInputId($this->model, 'image_x1')."').val(selection.x1);
    $('#".Html::getInputId($this->model, 'image_y1')."').val(selection.y1);
    $('#".Html::getInputId($this->model, 'image_x2')."').val(selection.x2);
    $('#".Html::getInputId($this->model, 'image_y2')."').val(selection.y2);
    $('#".Html::getInputId($this->model, 'image_width')."').val(selection.width);
    $('#".Html::getInputId($this->model, 'image_height')."').val(selection.height);
}
";
        $this->view->registerJs($js, View::POS_READY);

//        $js = '$.uploadPreview({input_field: "#image-upload", preview_box: "#image-preview"});';
//        $this->view->registerJs($js, View::POS_READY);
    }

    public function run()
    {
        $output = "";
        $output .= Html::activeHiddenInput($this->model, 'image_x1');
        $output .= Html::activeHiddenInput($this->model, 'image_y1');
        $output .= Html::activeHiddenInput($this->model, 'image_x2');
        $output .= Html::activeHiddenInput($this->model, 'image_y2');
        $output .= Html::activeHiddenInput($this->model, 'image_width');
        $output .= Html::activeHiddenInput($this->model, 'image_height');

        return $output.$this->render('area');
    }
}