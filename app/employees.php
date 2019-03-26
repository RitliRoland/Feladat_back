<?php

namespace Feladat;

use Illuminate\Database\Eloquent\Model;

class employees extends Model
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
    protected $fillable = ['First_name', 'Last_name', 'Company', 'Email', 'Phone', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Company', 'Company');
    }
}
