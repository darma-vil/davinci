<li>
     <a href="<?= \yii\helpers\Url::to(['category/view', 'id' => $category['id']])?>"> <!--создаются хелперы, которые помогают сделать чпу ссылки-->
        <?= $category['name']?>
        <?php if (isset ($category['childs'])): ?> <!--если у нас существует в категории элемент childs, то выводим span и если есть потомки выводим 'плюсики'-->
            <span class="badge pull-right">
                <i class="fa fa-plus"></i>
            </span>
        <?php endif;?>
    </a>
    <?php if (isset ($category['childs'])): ?> <!--если у нас существует потомки в  элементе childs - делаем вложенный список  и внутри li рекурсивно вызываем метод getMenuHtml, передавая узел данного дерева-->

        <ul>

            <?= $this->getMenuHtml($category['childs'])?>

        </ul>

    <?php endif;?>
</li>

