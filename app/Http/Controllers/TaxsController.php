<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelpers;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Tax;

use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaxsController extends Controller
{
    public function index(Request $request)
    {
        $length = request('length', 10);

        $tax = QueryBuilder::for(Tax::class)
        ->where('deleted',0)->where('entity_id',session('entity_id'))
            ->defaultSort('id')
            ->allowedSorts(['id','tax_name','tax_type','tax_amount','tax_group'])
            ->paginate(10)
            ->withQueryString();
//dd($tax);
        return Inertia::render('Tax/Index', [
            'tax' => $tax,

        ])->table(function (InertiaTable $table) {
            $table->addColumns([
                'tax_name'  => 'tax_name',
                'tax_type'  => 'tax_type',
                'tax_amount'=> 'tax_amount',
                'tax_group' => 'tax_group',
                'parent_id' => 'parent_id'
            ]);
        });
    }
    public function Create()
    {
        return Inertia::render('Tax/Create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
//         dd($input);
        $validate =  $this->validateTax($input);
//        dd($input);
            Tax::create(array(
                'tax_name'      =>  $input['tax_name'],
                'tax_type'      =>  $input['tax_type'],
                'tax_group'     =>  $input['tax_group'],
                'tax_amount'    =>  $input['tax_amount'],
                'parent_id'     =>  $input['parent_id']!=null ? $input['parent_id']['id'] : null,
                'created'       =>  AppHelpers::instance()->DateTimeZone(now()),
                'created_by'    =>  Auth::user()->id,
                'entity_id'     =>  session('entity_id'),
            ));
        return redirect()->to('/tax');
    }


    public function edit(Tax $tax)
    {
        // dd($tax);
        if($tax->parent_id!=null){$parent = tax($tax->parent_id,'','',''); $parent_id = $parent[0];
        }else{ $parent_id ='';}
        return Inertia::render('Tax/Edit', [
            'tax'=>array(
                'id'           => $tax->id,
                'tax_name'     => $tax->tax_name,
                'tax_type'     => $tax->tax_type,
                'tax_amount'   => $tax->tax_amount,
                'tax_group'    => $tax->tax_group,
                'parent_id'    => $parent_id,
            ),
        ]);
        // dd($tax);
    }


    public function update(Request $request)
    {
        $input    =  $request->all();
        $validate =  $this->validateTax($input);
        Tax::findOrFail($input['id'])->update(array(
                'tax_name'      =>  $input['tax_name'],
                'tax_type'      =>  $input['tax_type'],
                'tax_group'     =>  $input['tax_group'],
                'tax_amount'    =>  $input['tax_amount'],
                'parent_id'     =>  $input['parent_id'] ? $input['parent_id']['id'] : null,
                'modified'      =>  AppHelpers::instance()->DateTimeZone(now()),
                'modified_by'   =>  Auth::user()->id,
                'entity_id'     =>  session('entity_id')
        ));

        return redirect()->to('/tax');
    }

    public function destroy($id)
    {
        // Tax::findOrFail($id)->update(array('deleted'=>'1'));
        // return Redirect::route('tax');
    }

    public function taxparent($type)
    {
       $parent = tax('',$type,'','GST');
       return $parent;
    }

    protected function validateTax($input)
    {
//        dd($input);
        if($input['tax_group']=='CGST' || $input['tax_group']=='SGST'){
            $taxval =  request()->validate([
                        'tax_name'   => ['required'],
                        'tax_type'   => ['required'],
                        'tax_amount' => ['required'],
                        'parent_id'  => ['required'],
            ]);
        }else{
            $taxval =  request()->validate([
                'tax_name'   => ['required'],
                'tax_type'   => ['required'],
                'tax_amount' => ['required'],
            ]);
        }
    }
}
