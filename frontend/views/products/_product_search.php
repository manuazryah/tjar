<ul class="search-dropdown">
        <?php
        $p = 0;
        foreach ($products as $value) {
                $category_name = '';
                $p++;
                $link_params = '';

                if (isset($value->subcategory) && $value->subcategory != '') {
                        $sub_category_detail = \common\models\ProductSubCategory::findOne($value->subcategory);
                        $main_category_detail = common\models\ProductMainCategory::findOne($sub_category_detail->main_category_id);
                        $main_category_name = $main_category_detail->canonical_name;
                        $sub_category_name = $sub_category_detail->canonical_name;
                        $category_detail = common\models\ProductCategory::findOne($value->category);
                        $category_name = $category_detail->category_name;
                        $link_params = 'main_categ=' . $main_category_name . '&sub_categ=' . $sub_category_name;
                } else if (isset($value->category)) {
                        $category_detail = common\models\ProductCategory::findOne($value->category);
                        $category_name = $category_detail->category_name;
                        $main_category_detail = common\models\ProductMainCategory::findOne($category_detail->category_id);
                        $main_category_name = $main_category_detail->canonical_name;
                        $link_params = 'main_categ=' . $main_category_name . '&categ=' . $category_detail->canonical_nam;
                }
                ?>

                <li class="<?= $p == 1 ? 'search-selected' : '' ?>" id="<?= $value->tag_name ?>">
                        <a id="<?= $value->id ?>" href="<?= Yii::$app->homeUrl ?>products/product-search?<?= $link_params ?>&query_search=<?= $value->canonical_name ?>">  <div style="height: 25px"><span class="search-li-value"><?= $value->tag_name ?> </span> in  <span class="search-category"> <?= $category_name ?> </span></div> </a>

                </li>

        <?php } ?>
</ul>

<style>
        .search-category{
                color:#0070CC;
                font-weight: bold;
        }
</style>

