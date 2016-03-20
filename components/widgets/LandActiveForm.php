<?php
/**
 * Created by PhpStorm.
 * User: Андрюха
 * Date: 15.02.2016
 * Time: 8:27
 */

namespace app\components\widgets;


use yii\bootstrap\ActiveForm;

class LandActiveForm extends ActiveForm
{
    public function init() {
        parent::init();
        $this->fieldConfig = function($model,$attribute){
            return [
                'errorOptions' => ['encode' => FALSE],
                'inputOptions' => [
                    'id' => $model->scenario . '-landing-' .$attribute
                ]
            ];
        };
    }
}