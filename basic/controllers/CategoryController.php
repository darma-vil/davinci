<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 11.02.2019
 * Time: 20:29
 */

namespace app\controllers;
use app\models\Category;
use app\models\Product;
use Yii;
use yii\data\Pagination;

class CategoryController extends AppController{


    public function actionIndex() {

        $hits = Product::find()->where(['hit' =>'1'])->limit(6)->all();

        $this->setMeta('Da-Vinci');

        return $this->render('index', compact('hits'));

    }

    public function actionView($id){
        //$id = Yii::$app->request->get('id');

        $category = Category::findOne($id);
        if(empty($category))
            throw new \yii\web\HttpException(404, 'Такой категории нет');



        //$products = Product::find()->where(['category_id' => $id])->all();
        $id = Yii::$app->request->get('id');
        $query = Product::find()->where(['category_id' => $id]);

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3,  'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();

        $this->setMeta('Da-Vinci| ' . $category->name, $category->keywords, $category->description);
        return $this->render('view', compact('products', 'pages', 'category'));
    }


    public function actionSearch(){
        $q = trim(Yii::$app->request->get('q'));

            if(!$q)

                return $this->render('search');

        $query = Product::find()->andFilterWhere(['like', 'name',  $q]);

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3,  'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('search', compact('products', 'pages', 'q'));
    }

}