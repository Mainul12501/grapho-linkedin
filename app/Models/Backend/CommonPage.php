<?php

namespace App\Models\Backend;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommonPage extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'type',
        'title',
        'main_image',
        'content',
        'status',
        'seo_header',
        'seo_footer',
        'slug',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'common_pages';


    public static function createOrUpdateCommonPage($request, $commonPage = null)
    {
        if (!$commonPage)
        {
            $commonPage = new CommonPage();
        }
        $commonPage->type   = $request->type;
        $commonPage->title  = $request->title;
        $commonPage->main_image = imageUpload($request->file('main_image'), 'common-page', 'common-page', 800, 600, $commonPage->main_image ?? '');
        $commonPage->content    = $request->content;
        $commonPage->status = $request->status == 'on' ? 1 : 0;
        $commonPage->seo_header = $request->seo_header;
        $commonPage->seo_footer = $request->seo_footer;
        $commonPage->slug = str_replace(' ', '-', $request->title);
        $commonPage->save();
        return $commonPage;
    }
}
