<?php

namespace App\Models\Model\SuperAdmin\Contact;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable=['name','email','phone', 'address','subject','content'];
}
