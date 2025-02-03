<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Theme;

class ThemeCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'category_name',
        'category_description',
    ];
    
    /**
     * Get the themes for the category.
     */
    public function themes(): HasMany
    {
        return $this->hasMany(Theme::class,'theme_category_id','id');
    }

    
    /**
     * Get the tags available for the theme category.
     */
    public function tags(): HasMany
    {
        return $this->hasMany(Theme::class,'theme_category_id','id');
    }
}
