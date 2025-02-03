<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\ItemCollection;
use App\Http\Resources\ItemResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{

    private $orderColumnMapping = [
        'item_name' => 'item_name',
        'price_per_unit' => 'price_per_unit',
        'unit' => 'unit',
        'vendor_item_code' => 'vendor_item_code',
        'vendor_item_category' => 'vendor_item_category',
        'vendor_id' => 'vendor_id',
        'vendor_code' => 'vendor_code',
        'vendor_name' => 'vendor_name',
        'item_category_id' => 'item_category_id',
        'item_category_name' => 'item_category_name',
        'user_id' => 'user_id',
        'user_name' => 'user_name',
        'created_at' => 'created_at'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //create validator class
        $validator = Validator::make($request->all(),[
            'number_per_page'   => 'required|integer|min:4',
            'order_column_by'   => ['required',Rule::in(
                'item_name',
                'price_per_unit',
                'unit',
                'vendor_item_code',
                'vendor_item_category',
                'vendor_id',
                'vendor_code',
                'vendor_name',
                'item_category_id',
                'item_category_name',
                'user_id',
                'user_name',
                'created_at')],
            'order_type'        => ['required',Rule::in('asc','desc')],
            'users'             => 'nullable|array',
            'vendors'           => 'nullable|array',
            'item_categories'   => 'nullable|array',
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

        // users using in pagination
        $users = $request->users;

        // vendors using in pagination
        $vendors = $request->vendors;
        
        // item_categories using in pagination
        $itemCategories = $request->item_categories;

        // column and order type using in pagination
        $order_column_by = $request->order_column_by;
        $order_type = $request->order_type;

        // fetch models
        $item = Item::select([
            'items.*',
            'users.name as user_name',
            'users.email as user_email',
            'vendors.vendor_code as vendor_code',
            'vendors.vendor_name as vendor_name',
            'item_categories.id as item_category_id',
            'item_categories.name as item_category_name'
            ])
            ->join('item_categories','item_categories.id','=','items.item_category_id')
            ->join('vendors','vendors.id','=','items.vendor_id')
            ->join('users','users.id','=','items.user_id');

        // check if there is user_id applied to the filter
        if ($users != null) $item->whereIn('users.id',$users);

        // check if there is vendors applied to the filter
        if ($vendors != null) $item->whereIn('vendors.id',$vendors);

        // check if there is item_categories applied to the filter
        if ($itemCategories != null) $item->whereIn('item_categories.id',$itemCategories);

        if ($request->keyword != null) {
            $item->where('item_name','like',"%" . strtolower($request->keyword) . "%");
            $item->orWhere('vendor_code','like',"%" . strtolower($request->keyword) . "%");
            $item->orWhere('vendor_name','like',"%" . strtolower($request->keyword) . "%");
        }

        if ($request->with_trashed === 'yes') {
            $item->withTrashed();
        } 

        $item->orderBy($order_column_by,$order_type);

        // apply to the models
        $item = $item->cursorPaginate($perPage = $number_per_page);

        return response()->json([
            'message'   => 'Item(s) fetched.',
            'data'      =>  new ItemCollection($item),
            'meta'      =>  [
                'count' => $item->count(),
                'next_cursor' => $item->nextCursor() ? $item->nextCursor()->encode() : null,
                'next_page_url' => $item->nextPageUrl(),
                'previous_cursor' => $item->previousCursor() ? $item->previousCursor()->encode() : null,
                'previous_page_url' => $item->previousPageUrl(),
                'per_page' => $item->perPage(),
                'on_first_page' => $item->onFirstPage(),
                'on_last_page' => $item->onlastPage(),
                'has_pages' => $item->hasPages(),
                'has_more_pages' => $item->hasMorePages(),
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
            'item_name' => 'required|min:3|max:255|',
            'description' => 'nullable|max:255',
            'price_per_unit' => 'required|integer',
            'unit' => 'nullable|min:3|max:60',
            'vendor_item_code' => 'nullable|min:3|max:40',
            'vendor_item_category' => 'nullable|min:3|max:80',
            'vendor_id' => 'required|exists:vendors,id',
            'item_category_id' => 'required|exists:item_categories,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message'   => 'Validation Error',
                'errors'    =>  $validator->errors()
            ], 422);
        }

        $item = new Item();
        $item->item_name = $request->item_name;
        $item->description = $request->description;
        $item->price_per_unit = $request->price_per_unit;
        $item->unit = $request->unit;
        $item->vendor_item_code = $request->vendor_item_code;
        $item->vendor_item_category = $request->vendor_item_category;
        $item->vendor_id = $request->vendor_id;
        $item->item_category_id = $request->item_category_id;
        $item->user_id = $user->id;

        $item->save();

        return response()->json([
            'message'   => 'Item successfully added.',
            'data'      => new ItemResource($item)
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return response()->json([
            'message'   => 'Item successfully fetched.',
            'data'      => new ItemResource($item)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $user = Auth::user();

        //create validator class
        $validator = Validator::make($request->all(),[
            'item_name' => 'required|min:3|max:255|',
            'description' => 'nullable|max:255',
            'price_per_unit' => 'required|integer',
            'unit' => 'nullable|min:3|max:60',
            'vendor_item_code' => 'nullable|min:3|max:40',
            'vendor_item_category' => 'nullable|min:3|max:80',
            'vendor_id' => 'required|exists:vendors,id',
            'item_category_id' => 'required|exists:item_categories,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message'   => 'Validation Error',
                'errors'    =>  $validator->errors()
            ], 422);
        }

        $item->item_name = $request->item_name;
        $item->description = $request->description;
        $item->price_per_unit = $request->price_per_unit;
        $item->unit = $request->unit;
        $item->vendor_item_code = $request->vendor_item_code;
        $item->vendor_item_category = $request->vendor_item_category;
        $item->vendor_id = $request->vendor_id;
        $item->item_category_id = $request->item_category_id;
        $item->user_id = $user->id;

        $item->save();

        return response()->json([
            'message'   => 'Item successfully updated.',
            'data'      => new ItemResource($item)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {   
        $item->delete();

        return response()->json([
            'message'   => 'Item successfully deleted.',
            'data'      => new ItemResource($item)
        ], 200);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($itemId)
    {   
        $item = Item::withTrashed()->findOrFail($itemId);

        if ($item == null) {
            return response()->json([
                'message'   => 'Item not found.',
            ], 404);
        }

        $item->restore();

        return response()->json([
            'message'   => 'Item successfully restored.',
            'data'      => new ItemResource($item)
        ], 200);
    }
}
