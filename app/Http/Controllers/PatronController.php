<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelpers;
use App\Helpers\CustomQuery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\PatronContact;
use App\Models\Patron;
use App\Models\Contact;
use App\Models\EntityUser;
use App\Models\Personnel;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use DB;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PatronController extends Controller
{
    public $timestamps = false;

    function __construct()
    {
        $this->middleware('permission:edit_patroncontact|create_patroncontact|delete_patroncontact', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_patroncontact', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_patroncontact', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_patroncontact', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $length = request('length', 12);

        $patron = PatronContact::join('patrons', 'patrons.id', '=', 'patron_contacts.patron_id')
            ->join('contacts', 'contacts.id', '=', 'patron_contacts.contact_id')
            ->where('patrons.deleted', 0)->where('patrons.entity_id', session('entity_id'))
            ->when($request->term, function ($query, $term) {
                $query->Where('patrons.legal_name', 'like', '%' . $term . '%');
            })
            ->paginate($length);
        $total = $patron->total();
        $firstItem = $patron->firstItem();
        $lastItem = $patron->lastItem();
        // dd($patron,$total,$firstItem,$lastItem);

        return Inertia::render('Patron/Index', [
            'patrons' => $patron,
            'total' => $total,
            'firstItem' => $firstItem,
            'lastItem' => $lastItem,
        ])->table(function (InertiaTable $table) {
            $table->addColumns([
                'legal_name' => 'legal_name',
                'patron_type' => 'patron_type',
                'poc_name' => 'poc_name',
                'gstin' => 'gstin',
            ]);
        });
    }
    public function create()
    {

        return Inertia::render('Patron/Create', [
            'Customer' => Personnel::where('entity_id', session('entity_id'))->get()
        ]);
    }
    public function store(Request $request)
    {
        $date = Carbon::now();
        $input = $request->all();
        // dd()
        $validate =  $this->validatepatron();
        $patron_type = implode(',', $input['patron_type']);
        $creditledger = AppHelpers::instance()->defaultledger('Patron', 'Credit Ledger');
        $debitledger = AppHelpers::instance()->defaultledger('Patron', 'Debit Ledger');
        Patron::create(array(
            'entity_id' => session('entity_id'),
            'patron_type' => $patron_type,
            'legal_name' => $input['legal_name'],
            'gstin' => $input['gstin'],
            'credit_ledger_id' => $creditledger[0]['ledger_id'],
            'debit_ledger_id' => $debitledger[0]['ledger_id'],
            'created' => $date->toDateTimeString(),
            'created_by' => Auth::user()->id,
            'lead_by' => $input['lead_by'] ?? null
        ));

        Contact::create(array(
            'entity_id' => session('entity_id'),
            'person_name' => $input['name'],
            'line_1' => $input['line_1'],
            'line_2' => $input['line_2'],
            'city' => $input['city'],
            'state_name' => $input['state_name'],
            'zipcode' => $input['zipcode'],
            'landmark' => $input['landmark'],
            'contact_type' => $input['contact_type'],
            'tag' => $input['tag'],
            'email' => $input['email'],
            'mobile' => $input['mobile'],
            'alt_mobile' => $input['alt_mobile'],
            'land_line' => $input['land_line'],
            'secondary_address' => $input['secondary_address'],
            'secondary_contact_name' => $input['secondary_contact_name'],
            'created' => $date->toDateTimeString(),
            'created_by' => Auth::user()->id,
            'secondary_email' => $input['secondary_email'],
            'secondary_phone' => $input['secondary_phone']
        ));

        $patronid = Patron::where('entity_id', session('entity_id'))->latest()->first();
        //dd($id['id']);
        $contactid = Contact::where('entity_id', session('entity_id'))->latest()->first();
        PatronContact::create(array('patron_id' => $patronid['id'], 'contact_id' => $contactid['id']));

        return Redirect::route('patron');
    }

    public function address(Request $request, $id)
    {
        $date = Carbon::now();
        $input = $request->all();
        // dd($input);
        Contact::create(array(
            'entity_id' => session('entity_id'),
            'line_1' => $input['line_1'],
            'line_2' => $input['line_2'],
            'city' => $input['city'],
            'state_name' => $input['state_name'],
            'zipcode' => $input['zipcode'],
            'landmark' => $input['landmark'],
            'contact_type' => $input['contact_type'],
            'tag' => $input['tag'],
            'email' => $input['email'],
            'mobile' => $input['mobile'],
            'alt_mobile' => $input['alt_mobile'],
            'land_line' => $input['land_line'],
            'created' => $date->toDateTimeString(),
            'created_by' => Auth::user()->id
        ));

        $contactid = Contact::where('entity_id', session('entity_id'))->latest()->first();
        PatronContact::create(array('patron_id' => $id, 'contact_id' => $contactid['id']));

        return Redirect::route('patron');
    }

    public function patronstore(Request $request)
    {
        $date = Carbon::now();
        $input = $request->all();
        // dd($input['patron_type']);
        $validate =  $this->validatepatron();
        Patron::create(array(
            'entity_id' => session('entity_id'),
            'patron_type' => $input['patron_type'][0],
            'legal_name' => $input['legal_name'],
            'payment_mode' => $input['payment_mode'],
            'created' => $date->toDateTimeString(),
            'created_by' => Auth::user()->id,
        ));

        Contact::create(array(
            'entity_id' => session('entity_id'),
            'line_1' => $input['line_1'],
            'line_2' => $input['line_2'],
            'city' => $input['city'],
            'state_name' => $input['state_name'],
            'zipcode' => $input['zipcode'],
            'mobile' => $input['mobile'],
            'created' => $date->toDateTimeString(),
            'created_by' => Auth::user()->id
        ));

        $patronid = Patron::where('entity_id', session('entity_id'))->latest()->first();
        //dd($id['id']);
        $contactid = Contact::where('entity_id', session('entity_id'))->latest()->first();
        PatronContact::create(array('patron_id' => $patronid['id'], 'contact_id' => $contactid['id']));

        if ($input['trip'] == 'Outbound') return redirect()->to('trip/outbound/create');
        else return redirect()->to('trips/inbound/create');
    }


    public function show($patronid, $contactid) {}

    public function edit($id)
    {
        $data = PatronContact::join('patrons', 'patrons.id', '=', 'patron_contacts.patron_id')
            ->join('contacts', 'contacts.id', '=', 'patron_contacts.contact_id')
            ->where('patron_id', '=', $id)->get();
        $myString        = $data[0]['patron_type'];
        $patron_type     = explode(',', $myString);
        $c_ledgerId      = $data[0]['credit_ledger_id'] != null ? AppHelpers::instance()->account_type_ledger($data[0]['credit_ledger_id'], '') : null;
        $d_ledgerId      = $data[0]['debit_ledger_id'] != null ? AppHelpers::instance()->account_type_ledger($data[0]['debit_ledger_id'], '') : null;
        $credit_ledger   = AppHelpers::instance()->account_type_ledger('', 'Liability');
        $debit_ledger    = AppHelpers::instance()->account_type_ledger('', 'Asset');
        $Customer = Personnel::where('entity_id', session('entity_id'))->get();

        //        dd($data,$c_ledgerId,$d_ledgerId);
        return Inertia::render('Patron/Edit', compact('data', 'patron_type', 'credit_ledger', 'debit_ledger', 'c_ledgerId', 'd_ledgerId', 'Customer'));
    }

    public function addressome($id)
    {

        $address = Contact::where('id', '=', $id)->get();
        return  $address;
    }

    public function update(Request $request, $id)
    {
        $input  = $request->all();
        $date   = Carbon::now();
        $validate =  $this->up_validatepatron();
        //     dd($input);
        $patron_type = implode(',', $input['patron_type']);

        Patron::findOrFail($input['patron_id'])->update(array(
            'entity_id' => session('entity_id'),
            'patron_type' => $patron_type,
            'legal_name' => $input['legal_name'],
            'credit_ledger_id' => $input['credit_ledger_id'] ? $input['credit_ledger_id']['id'] : null,
            'payment_mode' => $input['payment_mode'],
            'debit_ledger_id' => $input['debit_ledger_id'] ? $input['debit_ledger_id']['id'] : null,
            'gstin' => $input['gstin'],
            'modified' => $date->toDateTimeString(),
            'modified_by' => Auth::user()->id,
            'lead_by' => $input['lead_by'] ?? null
        ));

        Contact::findOrFail($input['contact_id'])->update(array(
            'entity_id' => session('entity_id'),
            'person_name' => $input['name'],
            'line_1' => $input['line_1'],
            'line_2' => $input['line_2'],
            'city' => $input['city'],
            'state_name' => $input['state_name'],
            'zipcode' => $input['zipcode'],
            'landmark' => $input['landmark'],
            'contact_type' => $input['contact_type'],
            'tag' => $input['tag'],
            'email' => $input['email'],
            'mobile' => $input['mobile'],
            'alt_mobile' => $input['alt_mobile'],
            'land_line' => $input['land_line'],
            'secondary_address' => $input['secondary_address'],
            'secondary_contact_name' => $input['secondary_contact_name'],
            'modified' => $date->toDateTimeString(),
            'modified_by' => Auth::user()->id,
            'secondary_email' => $input['secondary_email'],
            'secondary_phone' => $input['secondary_phone']
        ));

        return Redirect::route('patron');
    }

    public function addressupdate(Request $request, $id)
    {
        $input = $request->all();
        $date = Carbon::now();
        // dd($id, $input);

        Contact::findOrFail($id)->update(array(
            'entity_id' => session('entity_id'),
            'line_1' => $input['line_1'],
            'line_2' => $input['line_2'],
            'city' => $input['city'],
            'state_name' => $input['state_name'],
            'zipcode' => $input['zipcode'],
            'landmark' => $input['landmark'],
            'contact_type' => $input['contact_type'],
            'tag' => $input['tag'],
            'email' => $input['email'],
            'mobile' => $input['mobile'],
            'alt_mobile' => $input['alt_mobile'],
            'land_line' => $input['land_line'],
            'secondary_address' => $input['secondary_address'],
            'secondary_contact_name' => $input['secondary_contact_name'],
            'modified' => $date->toDateTimeString(),
            'modified_by' => Auth::user()->id,
            'secondary_email' => $input['secondary_email'],
            'secondary_phone' => $input['secondary_phone']
        ));

        return Redirect::route('patron');
    }

    public function destroy($id)
    {
        // dd($id);
        Patron::findOrFail($id)->update(array('deleted' => '1'));
        Contact::findOrFail($id)->update(array('deleted' => '1'));
        // Patron::where('');
        return Redirect::route('patron')->with('Success', 'Patron Deleted.');
    }

    protected function validatepatron()
    {
        return request()->validate([
            // 'legal_name' => ['required',Rule::unique('patrons')->where(function ($query) {
            //     return $query->where('entity_id',session('entity_id'));
            //     })],
            'legal_name'    => ['required'],
            'patron_type'   => ['required'],
            'email'         => ['required'],
            'mobile'        => ['required'],
        ]);
    }

    protected function up_validatepatron()
    {
        return request()->validate([
            // 'legal_name' => ['required',Rule::unique('patrons')->where(function ($query) {
            //     return $query->where('entity_id',session('entity_id'));
            //     })],
            'legal_name'    => ['required'],
            'patron_type'   => ['required'],
            'email'         => ['required'],
            'mobile'        => ['required'],
            //            'credit_ledger_id'        => ['required'],
            //            'debit_ledger_id'        => ['required'],
        ]);
    }

}
