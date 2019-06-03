<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 28.01.2019
 * Time: 20:05
 */

namespace app\models;

use yii\db\ActiveRecord;


class Category extends ActiveRecord {

    public static function tableName () {

        return 'category'; //подсказываем с какой таблицой нужно работать
    }


    public function getProducts () {

        return $this->hasMany(Product::className(),['category_id' => 'id']); // связка таблицы и категорий

    }

}
