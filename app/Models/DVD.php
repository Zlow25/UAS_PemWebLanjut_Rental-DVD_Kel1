<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DVD extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'dvds';
    
    protected $fillable = [
        'dvd_code',
        'title',
        'cover',
        'slug',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The roles that belong to the DVD
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'dvd_category', 'dvd_id', 'category_id');
    }
}
