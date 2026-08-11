<?php

namespace App\Models\Backend;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Industry extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'note', 'slug', 'status'];

    protected $searchableFields = ['*'];

    public static function createOrUpdateIndustry($request, $industry = null)
    {
        if (!$industry) {
            $industry = new self();
        }
        $industry->name = $request->name;
        $industry->note = $request->note;
        $industry->status = $request->status == 'on' ? 1 : 0;
        $industry->slug = str_replace(' ', '-', $request->name);
        $industry->save();
        return $industry;
    }

    public function employerCompanies()
    {
        return $this->hasMany(EmployerCompany::class);
    }
}
