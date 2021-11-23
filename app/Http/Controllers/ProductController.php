<?php

namespace App\Http\Controllers;

use App\Libraries\Ultilities;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    //
    public function index() {
        return view('products.index');
    }

    public function datatable(Product $productModel, Request $request)
    {   

        if ($request->ajax()) {
            $data = $productModel->orderBy('id', 'desc')->get();
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
            ->editColumn('image', function($data) {
                if (!empty($data->image)) {
                    $url = asset('storage/products/' . $data->image . '');
                    return '<img src=' . $url . ' style="object-fit: cover; object-position: center;" alt="" width="120px" height="80px"/>';
                } else {
                    return '<img src="' . asset('images/no-image.png') . '" style="object-fit: cover; object-position: center;" alt="" width="120px" height="80px"/>';
                }
            })
            ->editColumn('quantity', function($data) {
                return $data->count;
            })
            ->addColumn('action', function($data){
                $urlEdit = route('products.edit', $data->id);
                $urlDelete = route('products.destroy', $data->id);
                $urlCreateDetail = route('detail-products.create', $data->id);
         
                return "
                    <a href='$urlCreateDetail' class='btn btn-success waves-effect waves-light btn-sm btn-btn-create-detail data-id='$data->id' title='Add Detail'><i class='fas fa-plus'></i></a>
                    <a href=".$urlEdit." class='btn btn-info waves-effect waves-light btn-sm btn-edit' data-id=".$data->id." title='Edit'><i class='fas fa-edit'></i></a>
                    <a href=".$urlDelete." class='btn btn-danger waves-effect waves-light btn-sm btn-delete' data-id=".$data->id." title='Delete'><i class='fas fa-trash-alt'></i></a>
                ";
            })
            ->rawColumns(['action', 'image'])
            ->make(true);
        }
    }

    public function create() {
        $categories = Category::all();
        return view('products.add', compact('categories'));
    }

    public function edit($id) {
        $productEdit = Product::findOrFail($id);
        $categoriesCurrent = $productEdit->categories;
        $categories = Category::all();

        return view('products.edit', compact('productEdit', 'id', 'categoriesCurrent', 'categories'));

    }

    public function store(Request $request) {
            $request->validate([
                'name' => 'required|string|max:100',
                'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:10240',
                'slug' => 'required|string|max:100|unique:products,slug',
                'categories' => 'required|array',
                'price' => "required|numeric|max:9999999999|min:0",
                'discount' => "required|numeric|max:100|min:0",
                'description' => 'nullable',
            ]);

            $data = [
                'name' =>  Ultilities::clearXSS($request->name),
                'slug' =>  Ultilities::clearXSS($request->slug),
                'image' => $this->saveImage($request->image),
                'price' => Ultilities::clearXSS($request->price),
                'discount' => Ultilities::clearXSS($request->discount),
                'count' => 0,
                'description' =>  $request->description,
            ];

            $product = Product::create($data);

            $categories = $request->categories;
            $product->categories()->sync($categories);
   
            if ($product) {
                return redirect()->route('products.index')->with(['alert-type' => 'success', 'message' => __('app.create_success')]);
            }
            return redirect()->route('products.index')->with(['alert-type' => 'error', 'message' => __('app.create_errors')]);
        
    }

    public function update(Request $request, $id)
    {       
            $request->validate([
                'name' => 'required|string|max:100',
                'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:10240',
                'slug' => 'required|string|max:100|unique:products,slug,'. $id . ',id',
                'categories' => 'required|array',
                'price' => "required|numeric|max:9999999999|min:0",
                'discount' => "required|numeric|max:100|min:0",
                'description' => 'nullable',
            ]);
            $data = [
                'name' =>  Ultilities::clearXSS($request->name),
                'slug' =>  Ultilities::clearXSS($request->slug),
                'price' => Ultilities::clearXSS($request->price),
                'discount' => Ultilities::clearXSS($request->discount),
                'description' =>  $request->description,
            ];
            
            if ($request->image) {
                $data['image'] =  $this->saveImage($request->image);
            }

            $product = Product::findOrFail($id);
            
            $update = $product->update($data);

            $categories = $request->categories;

            $product->categories()->sync($categories);

            if ($update) {
                return redirect()->route('products.index')->with(['alert-type' => 'success', 'message' => __('app.update_success')]);
            } 
            return redirect()->route('products.index')->with(['alert-type' => 'error', 'message' => __('app.update_errors')]);
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function destroy($id)
    {   
        $product = Product::findOrFail($id);
        $product->categories()->sync([]);

        $result = $product->delete();

        if ($result) {
            return response()->json(['success' => true, 'message' => __('app.delete_success')]);
        }
    }

    public function saveImage($image){
        $imageName =  uniqid() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/products/', $imageName);
        return $imageName;
    }
}
