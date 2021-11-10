<?php

namespace App\Http\Controllers;

use App\Libraries\Ultilities;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    //
    public function index() {
        return view('categories.index');
    }

    public function datatable(Category $category, Request $request)
    {   

        if ($request->ajax()) {
            $data = $category->orderBy('id', 'desc')->get();
            return DataTables::of($data)
            ->addIndexColumn()
            
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if (Str::contains(Str::lower($row['name']), Str::lower($request->get('search')))) {
                            return true;
                        }
                        return false;
                    });
                }
            })
            ->addColumn('action', function($data){
                return view('common.action', [
                    'model' => $data,
                    'url_edit' => route('categories.edit', $data->id),
                    'url_destroy' => route('categories.destroy', $data->id)
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function create() {
        return view('categories.add');
    }

    public function edit($id) {
        $category = Category::findOrFail($id);

        return view('categories.edit', compact('id','category'));
    }

    public function store(Request $request) {
            $request->validate([
                'name' => 'required|string|max:100',
                'slug' => 'required|string|max:100|unique:categories,slug'
            ]);
  
            $data = [
                'name' =>  Ultilities::clearXSS($request->name),
                'slug' =>  Ultilities::clearXSS($request->slug),
            ];

            $category = Category::create($data);

            if ($category) {
                return redirect()->route('categories.index')->with(['alert-type' => 'success', 'message' => __('app.create_success')]);
            }
            return redirect()->route('categories.index')->with(['alert-type' => 'error', 'message' => __('app.create_errors')]);
        
    }

    public function update(Request $request, $id)
    {   
            $request->validate([
                'name' => 'required|string|max:100',
                'slug' => 'required|string|max:100|unique:categories,slug,'. $id . ',id'
            ]);

            $data = [
                'name' =>  Ultilities::clearXSS($request->name),
                'slug' =>  Ultilities::clearXSS($request->slug),
            ];
    
            $category = Category::findOrFail($id);
            $update = $category->update($data);

            if ($update) {
                return redirect()->route('categories.index')->with(['alert-type' => 'success', 'message' => __('app.update_success')]);
            } 
            return redirect()->route('categories.index')->with(['alert-type' => 'error', 'message' => __('app.update_errors')]);
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function destroy($id)
    {   
        $category = Category::findOrFail($id);
        $result = $category->delete();

        if ($result) {
            return response()->json(['success' => true, 'message' => __('app.delete_success')]);
        }
    }
}
