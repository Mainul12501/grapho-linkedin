<?php

namespace App\Http\Controllers\Frontend\Crud;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\Post;
use App\Models\Backend\WebNotification;
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
        $posts = Post::where(['user_id' => ViewHelper::loggedUser()->id])->latest()->get();
        if (str()->contains(url()->current(), '/api/'))
        {
            foreach ($posts as $post)
            {
                if (isset($post->images))
                {
                    $post['image_array'] = json_decode($post->images);
                }
            }
        }
        $data = ['posts' => $posts];
        return ViewHelper::checkViewForApi($data, 'frontend.employer.posts.index');
        return view('frontend.employer.posts.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (ViewHelper::checkIfUserApprovedOrBlocked(auth()->user()))
        {
            return ViewHelper::returnRedirectWithMessage(route('employer.dashboard'),  'error','Your account is blocked or has not approved yet. Please contact with Likewise.');
        }
        return view('frontend.employer.posts.create', [
            'isShown'   => false,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (ViewHelper::checkIfUserApprovedOrBlocked(auth()->user()))
        {
            return ViewHelper::returnRedirectWithMessage(route('employer.dashboard'),  'error','Your account is blocked or has not approved yet. Please contact with Likewise.');
        }
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
                $loggedUser = ViewHelper::loggedUser();
                $webNotification = new WebNotification();
//                $webNotification->viewer_id = $loggedUser->id;
//                $webNotification->viewed_user_id = $user->id;
                $webNotification->notification_type = 'new_post';
                $webNotification->msg = "$loggedUser->name has posted a new post.";
                $webNotification->save();


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
        $data = [
            'isShown'   => true,
            'post' => Post::find($id)
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employer.posts.create');
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
        if (\request()->ajax() && isset($_GET['req_from']) && $_GET['req_from'] == 'admin')
        {
            return view('backend.user-management.view-post', $data)->render();
        }
        return ViewHelper::checkViewForApi($data, 'frontend.employer.home.view-post');
         return view('frontend.employer.home.view-post');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (ViewHelper::checkIfUserApprovedOrBlocked(auth()->user()))
        {
            return ViewHelper::returnRedirectWithMessage(route('employer.dashboard'),  'error','Your account is blocked or has not approved yet. Please contact with Likewise.');
        }
        $data = [
            'isShown'   => false,
            'post' => Post::find($id)
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employer.posts.create');
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
        if (ViewHelper::checkIfUserApprovedOrBlocked(auth()->user()))
        {
            return ViewHelper::returnRedirectWithMessage(route('employer.dashboard'),  'error','Your account is blocked or has not approved yet. Please contact with Likewise.');
        }
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
        if (ViewHelper::checkIfUserApprovedOrBlocked(auth()->user()))
        {
            return ViewHelper::returnRedirectWithMessage(route('employer.dashboard'),  'error','Your account is blocked or has not approved yet. Please contact with Likewise.');
        }
        $post->delete();
        return ViewHelper::returnSuccessMessage('Post Deleted successfully');
    }
}
