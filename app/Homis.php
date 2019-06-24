<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Homis extends Model
{
    protected $connection = 'homis';
    //hperson - list of patients
    //hadmlog - admitted
    //hpatroom - room
    //user_acc - user accounts
    //hpersonal - personal info
    //hdept - department

    protected $table = 'hdept';
}
