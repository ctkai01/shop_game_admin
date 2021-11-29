<?php

namespace App\Http\Controllers;

use App\Libraries\Ultilities;
use App\Models\DetailProduct;
use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DetailProductController extends Controller
{
    //
    public function index() {
        return view('detail_products.index');
    }

    public function datatable(DetailProduct $detailProductModel, Request $request)
    {   
        if ($request->ajax()) {
            $data = $detailProductModel->where('sold', DetailProduct::NOT_SOLD)->orderBy('id', 'desc')->get();
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
                if (!empty($data->product)) {
                    $url = asset('storage/products/' . $data->product->image . '');
                    return '<img src=' . $url . ' style="object-fit: cover; object-position: center;" alt="" width="120px" height="80px"/>';
                } else {
                    return '<img src="' . asset('images/no-image.png') . '" style="object-fit: cover; object-position: center;" alt="" width="120px" height="80px"/>';
                }
            })
            ->editColumn('name', function($data) {
               return $data->product ? $data->product->name : '';
            })
            ->addColumn('action', function($data){
                $urlEdit = route('detail-products.edit', $data->id);
                $urlDelete = route('detail-products.destroy', $data->id);
         
                return "
                    <a href=".$urlEdit." class='btn btn-info waves-effect waves-light btn-sm btn-edit' data-id=".$data->id." title='Edit'><i class='fas fa-edit'></i></a>
                    <a href=".$urlDelete." class='btn btn-danger waves-effect waves-light btn-sm btn-delete' data-id=".$data->id." title='Delete'><i class='fas fa-trash-alt'></i></a>
                ";
            })
            ->rawColumns(['action', 'image', 'name'])
            ->make(true);
        }
    }

    public function create($idProduct) {
        $nameProduct = Product::find($idProduct)->name;
        return view('detail_products.add', compact('nameProduct', 'idProduct'));
    }

    public function edit($id) {
        $detailProductEdit = DetailProduct::find($id);
        $nameProduct = $detailProductEdit->product->first() ? $detailProductEdit->product->first()->name : '';
        return view('detail_products.edit', compact('detailProductEdit', 'id', 'nameProduct'));

    }

    public function store(Request $request) {
        $request->validate([
                'code_card' => "nullable|string|max:255|unique:detail_products,code_card",
                'game_account' => 'nullable|required_with: password_account|string|max:255|unique:detail_products,account_game',
                'password_account' => "nullable|required_with: game_account|string|min:8|max:255",
            ]);

            $data = [];

            if ($request->code_card) {
                $data['code_card'] = Ultilities::clearXSS($request->code_card);
            } else {
                $data['account_game'] = Ultilities::clearXSS($request->game_account);
                $data['password_game'] = Ultilities::clearXSS($request->password_account);
            }

            $data['product_id'] = $request->id_product;
            
            $productDetail = DetailProduct::create($data);

            Product::where('id', $request->id_product)->increment('count', 1);
            

            if ($productDetail) {
                return redirect()->route('detail-products.index')->with(['alert-type' => 'success', 'message' => __('app.create_success')]);
            }
            return redirect()->route('detail-products.index')->with(['alert-type' => 'error', 'message' => __('app.create_errors')]);
    }

    public function update(Request $request, $id)
    {       
        $request->validate([
            'code_card' => "nullable|string|max:255|unique:detail_products,code_card",
            'game_account' => 'nullable|required_with: password_account|string|max:255|unique:detail_products,account_game',
            'password_account' => "nullable|required_with: game_account|string|min:8|max:255",
        ]);

        $data = [];

        if ($request->code_card) {
            $data['code_card'] = Ultilities::clearXSS($request->code_card);
        } else {
            $data['account_game'] = Ultilities::clearXSS($request->game_account);
            $data['password_game'] = Ultilities::clearXSS($request->password_account);
        }

        $detailProduct = DetailProduct::find($id);
            
        $update = $detailProduct->update($data);

        if ($update) {
            return redirect()->route('detail-products.index')->with(['alert-type' => 'success', 'message' => __('app.update_success')]);
        } 
        return redirect()->route('detail-products.index')->with(['alert-type' => 'error', 'message' => __('app.update_errors')]);
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function destroy($id)
    {   
        $detailProduct = DetailProduct::find($id);

        Product::where('id', $detailProduct->product_id)->decrement('count', 1);
        
        $result = $detailProduct->delete();

        if ($result) {
            return response()->json(['success' => true, 'message' => __('app.delete_success')]);
        }
    }
}
