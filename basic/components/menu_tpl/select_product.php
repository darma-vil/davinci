<option

    value="<?= $category['id']?>"
    <?php if($category['id'] == $this->model->category_id) echo 'selected' ?>
><?= $tab . $category['name']?></option>
<?php if (isset ($category['childs'])): ?> <!--если у нас существует потомки в  элементе childs - делаем вложенный список  и внутри li рекурсивно вызываем метод getMenuHtml, передавая узел данного дерева-->

    <ul>

        <?= $this->getMenuHtml($category['childs'], $tab . '-')?>

    </ul>

<?php endif;?>
