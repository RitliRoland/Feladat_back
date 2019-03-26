<?php

namespace Feladat;

use Illuminate\Database\Eloquent\Model;

class companies extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['Name', 'Email', 'Logo', 'Website', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employees()
    {
        return $this->hasMany('App\Employee', 'Company');
    }
}
