<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SetValues
 *
 * @author user
 */

namespace common\components;

use Yii;
use yii\base\Component;
use yii\web\Cookie;

class SetLanguage extends Component {

        public function Language() {
                $cookies1 = Yii::$app->request->cookies;
                //   setcookie('abc', '', time() - 999999, '/', '');

                if ($cookies1->has('language')) {
                        $language = $cookies1->getValue('language');
                } else {
                        $language = 'English';
                }
                return $language;
        }

        public function SetLanguage($langauge = null) {

                $cookie = new Cookie([
                    'name' => 'language',
                    'value' => $langauge,
                    'expire' => time() + 86400 * 365,
                ]);
                Yii::$app->getResponse()->getCookies()->add($cookie);
        }

        public function Words($language) {
                if ($language == 'English') {
                        $array = [
                            'electronics' => 'Electronics',
                            'appliances' => 'Appliances',
                            'men' => 'Men',
                            'women' => 'Women',
                            'baby' => 'BABY & KIDS',
                            'home' => 'HOME & FURNITURE',
                            'books' => 'BOOKS & MORE',
                            'offer_zone' => 'OFFER ZONE',
                        ];
                } else {
                        $array = [
                            'electronics' => 'إلكترونيات',
                            'appliances' => 'الأجهزة',
                            'men' => 'رجالي',
                            'women' => 'نساء',
                            'baby' => 'بيبي & كيدس',
                            'home' => 'الأثاث المنزلي',
                            'books' => 'كتب وأكثر',
                            'offer_zone' => 'منطقة العرض',
                        ];
                }
                $values = json_encode($array);
                return $values;
        }

}
