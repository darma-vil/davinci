<?php

namespace app\modules\admin\models;

use Yii;

class Product extends \yii\db\ActiveRecord
{

    public $image;

    public $gallery;



    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';

    }


    public function getCategory() {

        return $this->hasOne(Category::className(), ['id' => 'category_id']);

    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'name'], 'required'],
            [['category_id'], 'integer'],
            [['content', 'hit', 'new', 'sale'], 'string'],
            [['price'], 'number'],
            [['name', 'keywords', 'description', 'img'], 'string', 'max' => 255],
            [['image'], 'file', 'extensions' => 'png,jpg'],
  //          [['gallery'], 'file',  false, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];

    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID Товара',
            'category_id' => 'Категория',
            'name' => 'Имя',
            'content' => 'Контент',
            'price' => 'Цена',
            'keywords' => 'Ключевые слова',
            'description' => 'Описание',
            'image' => 'Фото',
            'hit' => 'Хит',
            'new' => 'Новинка',
            'sale' => 'Распродажа',
        ];
    }

    public function upload () {
        if($this->validate()) {
            $path = 'upload/store/' . $this->image->baseName . '.' . $this->image->extension;
            $this->image->saveAs($path);

            return true;
        }else {
            return false;
        }

    }

}
