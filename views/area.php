<?php

use yii\helpers\Html;

$image_path = $this->context->model->{$this->context->attribute};
?>
<div id="wrapper">
    <?= Html::activeFileInput($this->context->model, $this->context->attribute, $this->context->options); ?>
    <div id="image-holder">
        <?= $image_path ? Html::img(Yii::$app->fileStorage->baseUrl.DIRECTORY_SEPARATOR.$image_path) : '' ?>
    </div>
</div>