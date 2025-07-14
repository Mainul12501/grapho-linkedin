<?php

namespace App\Http\Controllers\Frontend\Crud;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\EmployeeDocument;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class EmployeeDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file =  $request->file('file');
        $fileSize = (int) ($file->getSize()/1000);
        $fileType = $file->getClientMimeType();
        $fileThumb = explode('/', $fileType)[1] == 'image' ? imageUpload($file, 'employee-document', 'employee-document',150, 150,  null) : null;
        $validator = Validator::make($request->all(), [
            'file'  => 'required',
            'title'  => 'required',
        ]);
        if ($validator->fails())
        {
            return ViewHelper::returEexceptionError($validator->errors());
        }
        $employeeDocument = new EmployeeDocument();
        $employeeDocument->user_id  = ViewHelper::loggedUser()->id;
        $employeeDocument->title    = $request->title;
        $employeeDocument->file = fileUpload($file, 'employee-document', 'employee-document',  null);
        $employeeDocument->file_thumb   = $fileThumb;
        $employeeDocument->file_type    = $fileType;
        $employeeDocument->file_size    = $fileSize;
//        $employeeDocument->status   = $request->status;
        $employeeDocument->slug = str_replace(' ', '-', $request->title);
        $employeeDocument->save();
        return ViewHelper::returnResponseFromPostRequest(true, 'Document uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeDocument $employeeDocument/*string $id*/)
    {
        return ViewHelper::returnBackViewAndSendDataForApiAndAjax(['data' => $employeeDocument], 'frontend.employee.include-edit-forms.document');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
//            'file'  => 'required',
            'title'  => 'required',
        ]);

        $file =  $request->file('file');
        if ($file)
        {
            $fileSize = (int) ($file->getSize()/1000);
            $fileType = $file->getClientMimeType();
            $fileThumb = explode('/', $fileType)[1] == 'image' ? imageUpload($file, 'employee-document', 'employee-document',150, 150,  null) : null;
        }

        $employeeDocument = EmployeeDocument::findOrFail($id);
        if (!$employeeDocument)
        {
            return ViewHelper::returnResponseFromPostRequest(false, 'Document not found. Please try again.');
        }


        if ($validator->fails())
        {
            return ViewHelper::returEexceptionError($validator->errors());
        }

        $employeeDocument->user_id  = ViewHelper::loggedUser()->id;
        $employeeDocument->title    = $request->title;
        if ($file)
        {
            $employeeDocument->file = fileUpload($file, 'employee-document', 'employee-document',  null);
            $employeeDocument->file_thumb   = $fileThumb ?? $employeeDocument->file_thumb;
            $employeeDocument->file_type    = $fileType ?? $employeeDocument->file_type;
            $employeeDocument->file_size    = $fileSize ?? $employeeDocument->file_size;
        }
//        $employeeDocument->status   = $request->status;
        $employeeDocument->slug = str_replace(' ', '-', $request->title);
        $employeeDocument->save();
        return ViewHelper::returnResponseFromPostRequest(true, 'Document uploaded successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeDocument $employeeDocument)
    {
        if ($employeeDocument)
        {
            $employeeDocument->delete();
            return ViewHelper::returnResponseFromPostRequest(true, 'Document deleted successfully.');
        } else {
            return ViewHelper::returnResponseFromPostRequest(false, 'Document not found. Please try again.');
        }
    }
}
