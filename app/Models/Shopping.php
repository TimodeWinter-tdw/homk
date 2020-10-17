<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Shopping
 *
 * @property int $id
 * @property int $user_id
 * @property string $product
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Shopping newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shopping newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shopping query()
 * @method static \Illuminate\Database\Eloquent\Builder|Shopping whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shopping whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shopping whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shopping whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shopping whereProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shopping whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shopping whereUserId($value)
 * @mixin \Eloquent
 */
class Shopping extends Model
{
    protected $fillable = [
        'product', 'description'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
