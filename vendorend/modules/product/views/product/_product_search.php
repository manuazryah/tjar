<ul class="search-dropdown">
        <?php
        $p = 0;
        foreach ($products as $value) {
                $category_name = '';
                $p++;
                if (isset($value->category)) {
                        $category_detail = common\models\ProductCategory::findOne($value->category);
                        $category_name = $category_detail->category_name;
                }
                ?>

                <li class="<?= $p == 1 ? 'search-selected' : '' ?>" id="<?= $value->tag_name ?>">
                        <a href="<?= Yii::$app->homeUrl ?>product/product/product-search?query_search=<?= $value->id ?>"> <span class="search-li-value"><?= $value->tag_name ?> </span> in  <span class="search-category"> <?= $category_name ?> </span> </a>
                </li>

        <?php } ?>
</ul>

<style>
        .search-category{
                color:#0070CC;
                font-weight: bold;
        }
</style>

