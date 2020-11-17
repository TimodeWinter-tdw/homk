<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TaskParticipants
 *
 * @property int $id
 * @property int $task_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Task $task
 * @method static \Illuminate\Database\Eloquent\Builder|TaskParticipants newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskParticipants newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskParticipants query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskParticipants whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskParticipants whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskParticipants whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskParticipants whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskParticipants whereUserId($value)
 * @mixin \Eloquent
 */
class TaskParticipants extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id', 'user_id'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
