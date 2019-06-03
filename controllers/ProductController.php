<?php

namespace app\controllers;
use app\models\Category;
use app\models\Product;
use Yii;


class ProductController extends AppController{


    public function actionView($id){

        //$id = Yii::$app->request->get('id');
        $product = Product::findOne($id);
        if(empty($product))
            throw new \yii\web\HttpException(404, 'Такого продукции нет');
        $hits = Product::find()->where(['hit' =>'1'])->limit(6)->all();
        $this->setMeta('Da-Vinci| ' . $product->name, $product->keywords, $product->description);
        return $this->render('view', compact('product', 'hits'));
    }



}