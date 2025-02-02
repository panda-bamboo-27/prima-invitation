<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Theme;

class ThemeTag extends Model
{
    use HasFactory;

    
    /**
     * Get the theme associated with the tags
     * The third argument is the foreign key name of the model on which you are defining the relationship, while the fourth argument is the foreign key name of the model that you are joining to:
     */
    public function theme(): BelongsToMany
    {
        return $this->belongsToMany(Theme::class,'tags','tag_id','theme_id')->withTimestamps();
    }
 
}
