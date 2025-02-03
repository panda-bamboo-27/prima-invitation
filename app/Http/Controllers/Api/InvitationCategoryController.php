<?php

namespace App\Http\Controllers\Api;

use App\Models\InvitationCategory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\InvitationCategoryCollection;
use App\Http\Resources\InvitationCategoryResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InvitationCategoryController extends Controller
{/**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //create validator class
        $validator = Validator::make($request->all(),[
            'number_per_page'   => 'required|integer|min:4',
            'order_column_by'   => ['required',Rule::in('name','user_id','created_at')],
            'order_type'        => ['required',Rule::in('asc','desc')],
            'users'             => 'nullable|array',
            'keyword'           => 'nullable',
            'with_trashed'      => [Rule::in('yes','no')]
        ]);

        //if validation fails then return the error(s).
        if ($validator->fails()) {
            return response()->json([
                'message'   => 'Validation Error',
                'errors'    =>  $validator->errors()
            ], 422);
        }

        // number per page using in pagination
        $number_per_page = $request->number_per_page;

        // number per page using in pagination
        $users = $request->users;

        // column and order type using in pagination
        $order_column_by = $request->order_column_by;
        $order_type = $request->order_type;

        // fetch models
        $invitationCategory = InvitationCategory::orderBy($order_column_by,$order_type);

        // check if there is user_id applied to the filter
        if ($users != null) {
            $invitationCategory->whereHas('user',function($q) use ($users){
                $q->whereIn('users.id',$users);
            });
        }

        if ($request->keyword != null) {
            $invitationCategory->where('name','like',"%" . strtolower($request->keyword) . "%");
        }

        $invitationCategory->with('user');

        if ($request->with_trashed === 'yes') {
            $invitationCategory->withTrashed();
        }
        
        // apply to the models
        $invitationCategory = $invitationCategory->cursorPaginate($perPage = $number_per_page);

        return response()->json([
            'message'   => 'Invitation category(s) fetched.',
            'data'      =>  new InvitationCategoryCollection($invitationCategory),
            'meta'      =>  [
                'count' => $invitationCategory->count(),
                'next_cursor' => $invitationCategory->nextCursor() ? $invitationCategory->nextCursor()->encode() : null,
                'next_page_url' => $invitationCategory->nextPageUrl(),
                'previous_cursor' => $invitationCategory->previousCursor() ? $invitationCategory->previousCursor()->encode() : null,
                'previous_page_url' => $invitationCategory->previousPageUrl(),
                'per_page' => $invitationCategory->perPage(),
                'on_first_page' => $invitationCategory->onFirstPage(),
                'on_last_page' => $invitationCategory->onlastPage(),
                'has_pages' => $invitationCategory->hasPages(),
                'has_more_pages' => $invitationCategory->hasMorePages(),
            ]
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        //create validator class
        $validator = Validator::make($request->all(),[
            'name'  => 'required|max:80|unique:invitation_categories,name',
            'description'  => 'nullable|max:80',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message'   => 'Validation Error',
                'errors'    =>  $validator->errors()
            ], 422);
        }

        $invitationCategory = new InvitationCategory();

        $invitationCategory->name = $request->name;
        $invitationCategory->description = $request->description;
        $invitationCategory->user_id = $user->id;

        $invitationCategory->save();

        return response()->json([
            'message'   => 'Invitation Category successfully added.',
            'data'      => new InvitationCategoryResource($invitationCategory)
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(InvitationCategory $invitationCategory)
    {
        return response()->json([
            'message'   => 'Invitation Category successfully fetched.',
            'data'      => new InvitationCategoryResource($invitationCategory)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvitationCategory $invitationCategory)
    {
        $user = Auth::user();

        //create validator class
        $validator = Validator::make($request->all(),[
            'name'  => 'required|max:80|unique:invitation_categories,name,'.$invitationCategory->id,
            'description'  => 'nullable|max:80',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message'   => 'Validation Error',
                'errors'    =>  $validator->errors()
            ], 422);
        }

        $invitationCategory->name = $request->name;
        $invitationCategory->description = $request->description;

        $invitationCategory->save();

        return response()->json([
            'message'   => 'Invitation Category successfully updated.',
            'data'      => new InvitationCategoryResource($invitationCategory)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvitationCategory $invitationCategory)
    {   
        $invitationCategory->delete();

        return response()->json([
            'message'   => 'Invitation Category successfully deleted.',
            'data'      => new InvitationCategoryResource($invitationCategory)
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($invitationCategoryId)
    {   
        $invitationCategory = InvitationCategory::withTrashed()->find($invitationCategoryId);

        if ($invitationCategory == null) {
            return response()->json([
                'message'   => 'Invitation Category not found.',
            ], 404);
        }

        $invitationCategory->restore();

        return response()->json([
            'message'   => 'Invitation Category successfully restored.',
            'data'      => new InvitationCategoryResource($invitationCategory)
        ], 200);
    }
}
