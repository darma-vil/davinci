<?php


namespace app\components;

use yii\base\Widget;
use app\models\Category;
use Yii;



class MenuWidget extends  Widget
{


    public $tpl;
    public $model;
    public $data; //здесь хранятся все категории из бд
    public $tree; //здесь будет хранится результат функции data. Из обычного массива будет строит - массив-дерево
    public $menuHtml; //здесь будет хранится код html меню

    public function init () {
        parent::init();
        if($this->tpl === null){
            $this->tpl = 'menu';
        }
        $this->tpl .='.php';
    }

    public function run () {
        //get cache // получить нужные данные из кэша
        if($this->tpl == 'menu.php') {
            $menu = Yii::$app->cache->get('menu');
            if ($menu) return $menu; //если, что-то получено из кэша, то вернем меню
        }



        $this->data = Category::find()->indexBy('id')->asArray()->all();//возращаем данные из нужной категории. Метод indexBy позволяет указать- какую колонку\поле таблицы, использовать для индексирование массивов
        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree); //возвращение результата getMenuHtml
        //set cache
        if($this->tpl == 'menu.php') {
            Yii::$app->cache->set('menu', $this->menuHtml, 60); //в случае игнорирования той строки, то будем формировать меню, после чего данные запишутся в кэш
        }

        return $this->menuHtml;
    }

    protected function getTree() { // позволяет из обычного массива сделать дерево-массива. Поддерживает неограниченное кол-во вложенностей

        $tree = [];

        foreach ($this->data as $id=>&$node) {

            if (!$node ['parent_id'])
                $tree[$id] = &$node;
            else
                $this->data[$node['parent_id']]['childs'][$node ['id']] = &$node;

        }
        return $tree;
    }


    protected function getMenuHtml($tree, $tab = '') { //tree передается именно параметром, так как не всегда нужно будет работать целиком с массивом

        $str = ''; //создаем пустую переменную, чтобы поместить готовый html
        foreach ($tree as $category) { //проходится в цикле по узлу дерева
            $str .= $this->catToTemplate($category, $tab);  //вызываем метод catToTemplate, передавая каждый элемент дерева

        }
        return $str;

    }
    protected function catToTemplate($category, $tab) { // этот метод принимает параметр, от  переданного элемента $category

        ob_start(); //буферизация вывода
        include __DIR__.'/menu_tpl/' . $this->tpl; //помещает его в шаблон
        return ob_get_clean();
    }

}