<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Theme;

class ThemeTemplate extends Model
{
    
    /**
     * Get the theme associated with the tags
     */
    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class,'theme_id','id');
    }
}
