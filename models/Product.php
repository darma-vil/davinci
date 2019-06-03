<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 28.01.2019
 * Time: 20:36
 */

namespace app\models;

use yii\db\ActiveRecord;


class Product extends ActiveRecord {

    public static function tableName () {

        return 'product'; //подсказываем с какой таблицой нужно работать
    }


    public function getCategory () {

        return $this->hasOne(Category::className(),['id' => 'category_id']); // связка таблицы и категорий

    }

}




