<?php

return [
    '' => 'site/index',
    'product-detail/<canonical:\w+(-\w+)*>/<product:\w+(-\w+)*>' => 'products/product-detail',
    'order-cancel/<orderdetail:\w+(-\w+)*>' => 'products/order-cancel',
    'my-wallet' => 'myaccounts/wallet',
];
