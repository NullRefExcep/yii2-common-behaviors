<?php

namespace nre\behaviors;

use yii\base\Behavior;
use yii\helpers\Json;

/**
 * Class Json.
 * Behavior for encoding and decoding model fields as JSON.
 *
 * @author    Serhiy Vinichuk <serhiyvinichuk@gmail.com>
 * @copyright 2014 NullReferenceException
 * @license   MIT
 */
class Json extends Behavior
{
    public $fields = [];

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'encode',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'encode',
            ActiveRecord::EVENT_AFTER_FIND => 'decode',
            ActiveRecord::EVENT_AFTER_INSERT => 'decode',
            ActiveRecord::EVENT_AFTER_UPDATE => 'decode',
        ];
    }

    public function encode()
    {
        $model = $this->owner;
        foreach ($this->fields as $field) {
            if (isset($model->$field)) {
                $model->$field = Json::encode($model->$field);
            }
        }
    }

    public function decode()
    {
        $model = $this->owner;
        foreach ($this->fields as $field) {
            $model->$field = empty($model->$field) ? [] : Json::decode($model->$field);
        }
    }
} 