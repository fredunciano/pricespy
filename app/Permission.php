<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getHasAnyPermissionAttribute()
    {
        if (
            !$this->add_product &&
            !$this->edit_product &&
            !$this->delete_product &&
            !$this->add_new_sub_user &&
            !$this->add_competitor &&
            !$this->edit_competitor &&
            !$this->delete_competitor &&
            !$this->view_invoice_and_payment_system
        ){
            return false;
        } else {
            return true;
        }
    }

}
