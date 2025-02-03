<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Vendor;
use App\Models\ItemCategory;

class Item extends Model
{
    use SoftDeletes;
    use HasFactory;
    
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'item_name',
        'description',
        'price_per_unit',
        'unit',
        'vendor_item_code',
        'vendor_item_category',
        'vendor_id',
        'item_category_id'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function vendor(): BelongsTo {
        return $this->belongsTo(Vendor::class,'vendor_id','id');
    }

    public function itemCategory(): BelongsTo {
        return $this->belongsTo(ItemCategory::class,'item_category_id','id');
    }
}
