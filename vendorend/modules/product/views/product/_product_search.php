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

                <li class="select <?= $p == 1 ? 'search-selected' : '' ?>" id="<?= $value->id ?>">
                        <a id="<?= $value->id ?>" href="<?= Yii::$app->homeUrl ?>product/product/product-search?query_cat=<?= $category_detail->canonical_name ?>&&query_search=<?= $value->canonical_name ?>">  <div style="height: 25px"><span class="search-li-value"><?= $value->tag_name ?> </span> in  <span class="search-category"> <?= $category_name ?> </span></div> </a>
                </li>

        <?php } ?>
</ul>

<style>
        .search-category{
                color:#0070CC;
                font-weight: bold;
        }
</style>

