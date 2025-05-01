<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use App\Models\Product;
use App\Models\Tax;
use App\Models\EntityUser;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends Controller
{
    public $timestamps = false;

    function __construct()
    {
         $this->middleware('permission:edit_products|create_products|delect_products', ['only' => ['index','store']]);
         $this->middleware('permission:create_products', ['only' => ['create','store']]);
         $this->middleware('permission:edit_products', ['only' => ['edit','update']]);
         $this->middleware('permission:delete_products', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $length = request('length', 10);

        $product = QueryBuilder::for(Product::class)
            ->where('deleted',0)->where('entity_id',session('entity_id'))
            ->when($request->term, function($query, $term) {
                $query->Where('name', 'like', '%'.$term.'%');
            })
            ->defaultSort('-id')
            ->allowedSorts(['id','name','sale_price','quantity'])
            ->paginate($length)
            ->withQueryString();

        return Inertia::render('Product/Index', [
            'products' => $product,
        ])->table(function (InertiaTable $table) {
            $table->addColumns([
                'name' => 'name',
                'sale_price'=>'sale_price',
                'quantity'=>'quantity',
            ]);
        });
    }
    public function create()
    {
        $tax = tax('', '', '', 'GST');
        return Inertia::render('Product/Create',compact('tax'));
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $date = Carbon::now();
        $validate =  $this->validateProduct();
        Product::create(array('name' =>$input['name'],'code'=>$input['code'],'description'=>$input['description'],'sale_price'=>$input['sale_price']
                ,'purchase_price'=>$input['purchase_price'],
                'created'=>$date->toDateTimeString(),'created_by'=>Auth::user()->id
                ,'quantity'=>$input['quantity'],'category_id'=> $input['category_id']
                ,'tax_id'=> $input['tax_id'],'entity_id'=>session('entity_id')));

        return Redirect::route('product');
    }
    public function show($id){
    }
    public function edit($id)
    {
        $tax = tax('','','','GST');
        $product = Product::where('id','=',$id)->get(['products.*']);
        //dd($products);
        return Inertia::render('Product/Edit',compact('product','tax'));
    }
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $date = Carbon::now();
        $request->validate(
            [
                'name' => ['required',Rule::unique('products')->ignore($input['id'])->where(function ($query) {
                return $query->where('entity_id',session('entity_id'))->where('deleted', 0);
                })],
            ]
        );
        Product::findOrFail($input['id'])->update(array('name' =>$input['name'],'code'=>$input['code'],'description'=>$input['description']
                                        ,'sale_price'=>$input['sale_price']
                                        ,'purchase_price'=>$input['purchase_price'],'quantity'=>$input['quantity']
                                        ,'category_id'=> $input['category_id'],'tax_id'=> $input['tax_id'],'entity_id'=>session('entity_id')
                                        ,'modified'=>$date->toDateTimeString(),'modified_by'=>Auth::user()->id));

        return Redirect::route('product');
    }
    public function destroy($id)
    {
        Product::findOrFail($id)->update(array('deleted'=>'1'));
        return Redirect::route('product')->with('success', 'Product Deleted.');
    }
    // protected function tax(){
    //     $tax = Tax::where('entity_id',session('entity_id'))->where('deleted', 0)->get();
    //     return $tax;
    // }
    protected function validateProduct()
    {
     return request()->validate([
             'name' => ['required',Rule::unique('products')->where(function ($query) {
                return $query->where('entity_id',session('entity_id'));
                })],
             ]);
    }
}
