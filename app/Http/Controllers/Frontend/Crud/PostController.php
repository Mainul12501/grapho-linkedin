<?php

namespace App\Http\Controllers\Frontend\Crud;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\Post;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where(['user_id' => ViewHelper::loggedUser()->id])->get();
        $data = ['posts' => $posts];
        return ViewHelper::checkViewForApi($data, 'frontend.employer.posts.index');
        return view('frontend.employer.posts.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frontend.employer.posts.create', [
            'isShown'   => false,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        if ($validator->fails())
        {
            return ViewHelper::returEexceptionError($validator->errors());
        }

        try {
            $post = Post::updateOrCreatePost($request);
            if ($post)
            {
                return ViewHelper::returnRedirectWithMessage(route('employer.posts.index'), 'success','Post created successfully');
            } else {
                return ViewHelper::returEexceptionError('Something went wrong. Please try again.');
            }
        } catch (\Exception $exception)
        {
            return ViewHelper::returEexceptionError($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         return view('frontend.employer.posts.create', [
            'isShown'   => true,
             'post' => Post::find($id)
        ]);
    }
    public function viewPost(string $id)
    {
        $post = Post::with(['employer' => function ($employer) {
            $employer->select('id', 'name', 'employer_company_id')->with(['employerCompany' => function ($employerCompany) {
                $employerCompany->select('id', 'user_id', 'logo');
            }]);
        }])->find($id);
        $data = [
            'post'  => $post,
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employer.home.view-post');
         return view('frontend.employer.home.view-post');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         return view('frontend.employer.posts.create', [
            'isShown'   => false,
             'post' => Post::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post/*string $id*/)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        if ($validator->fails())
        {
            return ViewHelper::returEexceptionError($validator->errors());
        }

        try {
            $post = Post::updateOrCreatePost($request, $post);
            if ($post)
            {
                Toastr::success('Post Updated successfully');
                return redirect(route('employer.posts.index'));
            } else {
                return ViewHelper::returEexceptionError('Something went wrong. Please try again.');
            }
        } catch (\Exception $exception)
        {
            return ViewHelper::returEexceptionError($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post/*string $id*/)
    {
        $post->delete();
        return ViewHelper::returnSuccessMessage('Post Deleted successfully');
    }
}
