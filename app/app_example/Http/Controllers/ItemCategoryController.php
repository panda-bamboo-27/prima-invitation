<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\ItemCategoryCollection;
use App\Http\Resources\ItemCategoryResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ItemCategoryController extends Controller
{
    /**
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
        $itemCategory = ItemCategory::orderBy($order_column_by,$order_type);

        // check if there is user_id applied to the filter
        if ($users != null) {
            $itemCategory->whereHas('user',function($q) use ($users){
                $q->whereIn('users.id',$users);
            });
        }

        if ($request->keyword != null) {
            $itemCategory->where('name','like',"%" . strtolower($request->keyword) . "%");
        }

        $itemCategory->with('user');

        if ($request->with_trashed === 'yes') {
            $itemCategory->withTrashed();
        }
        
        // apply to the models
        $itemCategory = $itemCategory->cursorPaginate($perPage = $number_per_page);

        return response()->json([
            'message'   => 'Item Categories fetched.',
            'data'      =>  new ItemCategoryCollection($itemCategory),
            'meta'      =>  [
                'count' => $itemCategory->count(),
                'next_cursor' => $itemCategory->nextCursor() ? $itemCategory->nextCursor()->encode() : null,
                'next_page_url' => $itemCategory->nextPageUrl(),
                'previous_cursor' => $itemCategory->previousCursor() ? $itemCategory->previousCursor()->encode() : null,
                'previous_page_url' => $itemCategory->previousPageUrl(),
                'per_page' => $itemCategory->perPage(),
                'on_first_page' => $itemCategory->onFirstPage(),
                'on_last_page' => $itemCategory->onlastPage(),
                'has_pages' => $itemCategory->hasPages(),
                'has_more_pages' => $itemCategory->hasMorePages(),
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
            'name'  => 'required|max:80|unique:item_categories,name',
            'description'  => 'nullable|max:80',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message'   => 'Validation Error',
                'errors'    =>  $validator->errors()
            ], 422);
        }

        $itemCategory = new ItemCategory();

        $itemCategory->name = $request->name;
        $itemCategory->description = $request->description;
        $itemCategory->user_id = $user->id;

        $itemCategory->save();

        return response()->json([
            'message'   => 'Item Category successfully added.',
            'data'      => new ItemCategoryResource($itemCategory)
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemCategory $itemCategory)
    {
        return response()->json([
            'message'   => 'Item Category successfully fetched.',
            'data'      => new ItemCategoryResource($itemCategory)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemCategory $itemCategory)
    {
        $user = Auth::user();

        //create validator class
        $validator = Validator::make($request->all(),[
            'name'  => 'required|max:80|unique:item_categories,name,'.$itemCategory->id,
            'description'  => 'nullable|max:80',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message'   => 'Validation Error',
                'errors'    =>  $validator->errors()
            ], 422);
        }

        $itemCategory->name = $request->name;
        $itemCategory->description = $request->description;

        $itemCategory->save();

        return response()->json([
            'message'   => 'Item Category successfully updated.',
            'data'      => new ItemCategoryResource($itemCategory)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemCategory $itemCategory)
    {   
        $itemCategory->delete();

        return response()->json([
            'message'   => 'Item Category successfully deleted.',
            'data'      => new ItemCategoryResource($itemCategory)
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($itemCategoryId)
    {   
        $itemCategory = ItemCategory::withTrashed()->find($itemCategoryId);

        if ($itemCategory == null) {
            return response()->json([
                'message'   => 'Item Category not found.',
            ], 404);
        }

        $itemCategory->restore();

        return response()->json([
            'message'   => 'Item Category successfully restored.',
            'data'      => new ItemCategoryResource($itemCategory)
        ], 200);
    }
}
