<?php

namespace App\Models\Backend;

use App\Models\Scopes\Searchable;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'skills_category_id',
        'skill_name',
        'note',
        'slug',
        'status',
    ];

    protected $searchableFields = ['*'];

    public static function createOrUpdateSkill($request, $skill = null)
    {
        if (!$skill) {
            $skill = new self();
        }
        $skill->skill_name = $request->skill_name;
        $skill->skills_category_id = $request->skills_category_id;
        $skill->note = $request->note;
        $skill->status = $request->status == 'on' ? 1 : 0;
        $skill->slug = str_replace(' ', '-', $request->skill_name);
        $skill->save();
        return $skill;
    }

    public function skillsCategory()
    {
        return $this->belongsTo(SkillsCategory::class);
    }

    public function jobTasks()
    {
        return $this->belongsToMany(JobTask::class);
    }

    public function employees()
    {
        return $this->belongsToMany(User::class);
    }
}
