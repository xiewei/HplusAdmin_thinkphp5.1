<?php
namespace app\admin\model;

use think\Model;

class MerchantUser extends Model
{
    public function profile()
    {
        return $this->hasOne('merchant_merchant', 'u_id');
    }

    public function list_get()
    {
        $user = MerchantUser::get(1);
        // 输出Profile关联模型的email属性

        return $user->profile->phone;
    }
}
