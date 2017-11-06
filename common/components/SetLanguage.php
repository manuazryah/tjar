<?php

/**
 * Description of SetLnguage
 *
 * @author user
 */

namespace common\components;

use Yii;
use yii\base\Component;
use yii\web\Cookie;

class SetLanguage extends Component {
        /*
         * check cookie set or not, if not set default language is Ebglish
         */

        public function Language() {
                $cookies1 = Yii::$app->request->cookies;
                if ($cookies1->has('language')) {
                        $language = $cookies1->getValue('language');
                } else {
                        $language = 'English';
                }
                return $language;
        }

        /*
         * set cookie
         */

        public function SetLanguage($langauge = null) {

                $cookie = new Cookie([
                    'name' => 'language',
                    'value' => $langauge,
                    'expire' => time() + 86400 * 1,
                ]);
                Yii::$app->getResponse()->getCookies()->add($cookie);
        }

        /*
         * json for common words in static page
         */

        public function Words($language) {
                if ($language == 'Arabic') {

                        $array = [
                            'electronics' => 'إلكترونيات',
                            'appliances' => 'الأجهزة',
                            'men' => 'رجالي',
                            'women' => 'نساء',
                            'baby' => 'بيبي & كيدس',
                            'home' => 'الأثاث المنزلي',
                            'books' => 'كتب وأكثر',
                            'offer_zone' => 'منطقة العرض',
                            'Warranty' => 'ضمانض',
                        ];
                } else {
                        $array = [
                            'electronics' => 'Electronics',
                            'appliances' => 'Appliances',
                            'men' => 'Men',
                            'women' => 'Women',
                            'baby' => 'BABY & KIDS',
                            'home' => 'HOME & FURNITURE',
                            'books' => 'BOOKS & MORE',
                            'offer_zone' => 'OFFER ZONE',
                            'Warranty' => 'Warranty',
                        ];
                }
                $values = json_encode($array);
                return $values;
        }

        Public function ViewData($model, $field) {

                $data = $model->$field;
                $cookies = Yii::$app->request->cookies;
                if ($cookies->has('language')) {
                        $language = $cookies->getValue('language');
                        if ($language == 'Arabic') {
                                $table = Yii::$app->db->schema->getTableSchema($model->tableName());

                                if (isset($table->columns[$field . '_arabic'])) {
                                        $x = $field . '_arabic';
                                        $data = $model->$x;
                                }
                        }
                }
                return $data;
        }

}
