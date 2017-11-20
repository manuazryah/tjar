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
use common\models\AdminUsers;
use common\models\Vendors;
use common\models\User;

class SetValues extends Component {

        public function Attributes($model) {
                if (isset($model) && !Yii::$app->user->isGuest) {
                        if ($model->isNewRecord) {
                                $model->UB = Yii::$app->user->identity->id;
                                $model->CB = Yii::$app->user->identity->id;
                                $model->DOC = date('Y-m-d');
                        } else {
                                $model->UB = Yii::$app->user->identity->id;
                        }
                        return TRUE;
                } else {
                        return FALSE;
                }
        }

        /*
         * Repeated followups Dates listing
         */

        public function Dates() {
                $dates = [];
                for ($i = 1; $i <= 31; $i++) {
                        $dates[$i] = $i;
                }
                return $dates;
        }

        /*
         * Repeated followups Dates listing
         */

        public function Months() {
//        $months = array(1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                $months = array(1 => 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec');
                return $months;
        }

        /*
         * Repeated followups Dates listing
         */

        public function Years() {
                $years = range(date("Y"), 1910);
                return $years;
        }

        public function Selected($value) {
                $options = array();
                if (is_array($value)) {
                        $array = $value;
                } else {
                        $array = explode(',', $value);
                }

                foreach ($array as $valuee):
                        $options[$valuee] = ['selected' => true];
                endforeach;
                return $options;
        }

        /*
         * Add entry to history table
         * $reference_id- id of the table
         * $type- history type
         * $product_id- id of the product
         * $user_type- if it is admin/vendor/user
         * $user_id- user id
         */

        public function History($reference_id, $type, $product_id = null, $user_type, $user_id) {
                $model = new \common\models\History;
                $model->reference_id = $reference_id;
                $model->history_type = $type;
                $model->product_id = $product_id;
                $model->content = $this->GetContent($type, $user_type, $user_id, $product_id);
                $model->date = date('Y-m-d');
                $model->save();
                if ($model->save())
                        return $model->id;
                else
                        return FALSE;
        }

        /*
         * History table content
         */

        public function GetContent($type, $user_type, $user_id, $product_id) {
                $user_name = $this->GetUser($user_type, $user_id);
                $history_type = \common\models\MasterHistoryType::findOne($type);
                if ($type == 1) {
                        $content = 'Seller ' . $user_name . ' ' . $history_type->content;
                } else if ($type == 2) {
                        $product_details = \common\models\ProductVendor::findOne($product_id);
                        $product_name = \common\models\Products::findOne($product_details->product_id)->product_name;
                        $content = $history_type->content . ' ' . $product_name;
                } else if ($type == 3) {
                        $product_details = \common\models\ProductVendor::findOne($product_id);
                        $product_name = \common\models\Products::findOne($product_details->product_id)->product_name;
                        $content = $history_type->content . ' ' . $product_name;
                } else if ($type == 4) {
                        $content = $history_type->content;
                } else if ($type == 5) {
                        $content = $history_type->content;
                } else if ($type == 6) {
                        $content = $history_type->content;
                }
                return $content;
        }

        public function GetUser($user_type, $user_id) {
                if ($user_type == 1) { /* admin */
                        $user_name = AdminUsers::findOne($user_id)->name;
                } else if ($user_type == 2) { /* vendors */
                        $user_name = \common\models\Vendors::findOne($user_id)->first_name;
                } else if ($user_type == 3) { /* users */
                        $user_name = \common\models\User::findOne($user_id)->first_name;
                }
                return $user_name;
        }

        /*
         * Add entry to Notification table
         * $reference_id- id of the reference table
         * $history_id -History table id
         * $type- user type, if admin or vendor or user
         * $user_id -id of the user
         */

        public function Notifications($reference_id, $history_id, $user_id) {
                $history_model = \common\models\History::findOne($history_id);
                $master_history = \common\models\MasterHistoryType::findOne($history_model->history_type);
                $super_admins = AdminUsers::find()->where(['status' => 1])->all();
                $sent_notification = explode(',', $master_history->notification);
                if (in_array(1, $sent_notification))
                        $this->NotificationSuperAdmins($super_admins, $history_model->reference_id, $history_id, $history_model, 1);
                if (in_array(2, $sent_notification)) {

                        if ($history_model->history_type == 4 || $history_model->history_type == 5)
                                $this->OrderVendorNotifications($reference_id, $history_id, $user_id, $history_model, 2, $history_model->history_type);
                        else
                                $this->OtherNotifications($reference_id, $history_id, $user_id, $history_model, 2);
                }
                if (in_array(3, $sent_notification))
                        $this->OtherNotifications($reference_id, $history_id, $type, $user_id, $history_model, 3);
        }

        /*
         * Notification for SuperAdmin
         */

        public function NotificationSuperAdmins($superadmins, $reference_id, $history_id, $history_model, $user_type) {
                foreach ($superadmins as $superadmin) {
                        $model = new \common\models\NotificationViewStatus();
                        $model->reference_id = $reference_id;
                        $model->history_id = $history_id;
                        $model->user_type = $user_type;
                        $model->user_id = $superadmin->id;
                        $model->content = $history_model->content;
                        $model->date = date('Y-m-d');
                        $model->view_status = 0;
                        $model->save();
                }
        }

        /*
         * Vendor / User notification
         */

        public function OtherNotifications($reference_id, $history_id, $user_id, $history_model, $user_type) {
                $model = new \common\models\NotificationViewStatus;
                $model->reference_id = $reference_id;
                $model->history_id = $history_id;
                $model->user_type = $user_type;
                $model->user_id = $user_id;
                $model->content = $history_model->content;
                $model->date = date('Y-m-d');
                $model->view_status = 0;
                $model->save();
        }

        public function OrderVendorNotifications($reference_id, $history_id, $user_id, $history_model, $user_type, $type) {
                $order_master = \common\models\OrderMaster::findOne($history_model->reference_id);
                $order_details = \common\models\OrderDetails::find()->where(['master_id' => $order_master->id])->all();
                foreach ($order_details as $value) {
                        $model = new \common\models\NotificationViewStatus;
                        $model->reference_id = $value->id;
                        $model->history_id = $history_id;
                        $model->user_type = 2;
                        $model->user_id = $value->vendor_id;
                        $product_vendor_details = \common\models\ProductVendor::findOne($value->product_id);
                        $product_detail = \common\models\Products::findOne($product_vendor_details->product_id);
                        if ($type == 4)
                                $model->content = 'Order received for ' . $product_detail->product_name;
                        else
                                $model->content = 'Order cancelled of ' . $product_detail->product_name;

                        $model->date = date('Y-m-d');
                        $model->view_status = 0;
                        $model->save();
                }
        }

}
