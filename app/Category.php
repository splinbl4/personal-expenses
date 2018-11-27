<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
*/


class Category extends Model
{
    protected $fillable = ['title'];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
