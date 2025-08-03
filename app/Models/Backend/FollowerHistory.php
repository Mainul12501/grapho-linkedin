<?php

namespace App\Models\Backend;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FollowerHistory extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['employer_id', 'follower_id', 'is_unfollowed'];

    protected $searchableFields = ['*'];

    protected $table = 'follower_histories';

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }
}
