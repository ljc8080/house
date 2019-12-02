<?php

namespace App\Model;


class Tenant extends BaseModel
{
    public $hidden = ["deleted_at","create_time","id"];
}
