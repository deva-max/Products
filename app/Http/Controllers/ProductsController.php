<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Storage;

class ProductsController extends Controller
{

    private function getProducts(){
        $path = storage_path('app/products.json');
        if(file_exists($path)){
            $data = file_get_contents($path);
            if(is_string($data)){
                return json_decode($data, true) ?? [];
            }
            return json_decode($data, true) ?? [];
        }
        return [];
    }

    private function saveProducts($products)
    {
        $path = storage_path('app/products.json');
        file_put_contents($path,json_encode($products, JSON_PRETTY_PRINT));
    }
    public function index(){
        $products = $this->getProducts();
        return view('products/index', compact('products'));
    }

    public function get_data() {
        
        $products = $this->getProducts();

        return response()->json([
            'draw' => request()->get('draw'),
            'recordsTotal' => count($products),
            'recordsFiltered' => count($products),
            'data' => $products,
        ]);
    }

    public function create(){
        return view('products.add');
    }

    public function store(Request $request){
        \Session::flash('toastr', true);
        \Log::info('store');

        $rules = [
            'product_name' => 'required|string',
            'quantity_in_stock' => 'required|numeric',
            'price_per_item' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json(['status' => 'error', 'message' => $validator->errors()])->withInput();
            
        }

        $products = $this->getProducts();
        $product = ([
            'id' => uniqid(),
            'product_name' => $request->product_name,
            'quantity_in_stock' => $request->quantity_in_stock,
            'price_per_item' => $request->price_per_item,
            
        ]);

        $products[] = $product;

        $this->saveProducts($products);

        return response()->json(['status' => 'success', 'message' => 'Product Created Successfully.']);

    }

    public function update(Request $request) {

        \Session::flash('toastr', true);

        $rules = [
            'product_name' => 'required|string',
            'quantity_in_stock' => 'required|numeric',
            'price_per_item' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json(['status' => 'error', 'message' => $validator->errors()])->withInput();
            
        }

        $products = json_decode(file_get_contents(storage_path('app/products.json')), true);

        foreach ($products as &$product) {
            if($product['id'] == $request->id){
                $product['product_name'] = $request->product_name;
                $product['quantity_in_stock'] = $request->quantity_in_stock;
                $product['price_per_item'] = $request->price_per_item;
                break;
            }
        }

        file_put_contents(storage_path('app/products.json'), json_encode($products, JSON_PRETTY_PRINT));
        
        return response()->json(['status' => 'success', 'message' => 'products updated successfully']);
        
    }
}
