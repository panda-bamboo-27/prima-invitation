<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Theme;

class ThemeTag extends Model
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
        'tag_name',
        'tag_description',
    ];
    
    /**
     * Get the theme associated with the tags
     * The third argument is the foreign key name of the model on which you are defining the relationship, while the fourth argument is the foreign key name of the model that you are joining to:
     */
    public function theme(): BelongsToMany
    {
        return $this->belongsToMany(Theme::class,'tags','tag_id','theme_id')->withTimestamps();
    }
 
}
