<?php

namespace App\Models\Model\SuperAdmin\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use Notifiable;
    protected $table='users';
    protected $fillable=['name','username','role','status','phone','gender','address','image','password','email', 'verification_code', 'refer_by', 'is_verified', 'created_by', 'is_new'];
    protected function getStatusTextAttribute()
    {
        return  ucwords(str_replace( '_', ' ',$this->status));
    }
    public function getUserRoleAttribute(){
        if($this->role == 'admin'){
            return 'Admin';
        }elseif ($this->role =='agent'){
            return 'Agent';
        }elseif ($this->role =='demo'){
            return 'Demo Admin';
        }else{
            return 'Customer';
        }
    }


}
