<?php

namespace App\Models\Backend;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostViewer extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['post_id', 'viewer_id'];

    protected $searchableFields = ['*'];

    protected $table = 'post_viewers';

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function viewer()
    {
        return $this->belongsTo(User::class, 'viewer_id');
    }
}
