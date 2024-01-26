<?php

namespace App\Http\Controllers\WEB\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\BillingAddress;
use App\Models\ShippingAddress;
use App\Models\User;
use Str;

use App\Exports\CountryExport;
use App\Imports\CountryImport;
use App\Models\Currency;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $countries = Country::with('countryStates','addressCountires')->get();

        return view('admin.country', compact('countries'));
    }


    public function create()
    {
        return view('admin.create_country');
    }


    public function store(Request $request)
    {
        $rules = [
            'name'=>'required|unique:countries',
            'status'=>'required'
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'name.unique' => trans('admin_validation.Name already exist'),
        ];
        $this->validate($request, $rules,$customMessages);

        $country=new Country();
        $country->name = $request->name;
        $country->slug = Str::slug($request->name);
        $country->status = $request->status;
        $country->save();

        $notification=trans('admin_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.country.index')->with($notification);
    }


    public function show($id)
    {
        $country = Country::find($id);
        return response()->json(['country' => $country], 200);
    }

    public function edit($id)
    {
        $country = Country::find($id);
        return view('admin.edit_country', compact('country'));
    }

    public function update(Request $request, $id)
    {
        $country = Country::find($id);
        $rules = [
            'name'=>'required|unique:countries,name,'.$country->id,
            'status'=>'required'
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'name.unique' => trans('admin_validation.Name already exist'),
        ];
        $this->validate($request, $rules,$customMessages);

        $country->name = $request->name;
        $country->slug = Str::slug($request->name);
        $country->status = $request->status;
        $country->save();

        $notification=trans('admin_validation.Updated Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.country.index')->with($notification);
    }


    public function destroy($id)
    {
        $country = Country::find($id);
        $country->delete();
        $notification=trans('admin_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.country.index')->with($notification);
    }

    public function changeStatus($id){
        $country = Country::find($id);
        if($country->status==1){
            $country->status=0;
            $country->save();
            $message= trans('admin_validation.Inactive Successfully');
        }else{
            $country->status=1;
            $country->save();
            $message= trans('admin_validation.Active Successfully');
        }
        return response()->json($message);
    }


    public function country_import_page()
    {
        return view('admin.country_import_page');
    }

    public function country_export()
    {
        $is_dummy = false;
        $first_item = Country::first();
        return Excel::download(new CountryExport($is_dummy, $first_item), 'countries.xlsx');
    }

    public function demo_country_export()
    {
        $is_dummy = true;
        $first_item = Country::first();

        return Excel::download(new CountryExport($is_dummy, $first_item), 'countries.xlsx');
    }



    public function country_import(Request $request)
    {
        try{
            Excel::import(new CountryImport, $request->file('import_file'));

            $notification=trans('Uploaded Successfully');
            $notification=array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->back()->with($notification);
        }catch(Exception $ex){
            $notification=trans('Please follow the instruction and input the value carefully');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }


    }

    public function currencyIndex()
    {

        $currencies = Currency::get();

        return view('admin.currency', compact('currencies'));
    }


    public function currencyCreate()
    {
        return view('admin.create_currency');
    }


    public function currencyStore(Request $request)
    {
        // dd($request->all());
        $rules = [
            'name'  =>  'required|unique:currencies',
            'code'  =>  'required|unique:currencies',
            'rate'  =>  'required',
            'status'=>  'required'
        ];

        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'code.required' => trans('admin_validation.Name is required'),
            'rate.required' => trans('admin_validation.Currency rate is required'),
            'name.unique' => trans('admin_validation.Name already exist'),
            'code.unique' => trans('admin_validation.Name already exist'),
        ];

        $this->validate($request, $rules,$customMessages);

        $currency=new Currency();
        $currency->name = $request->name;
        $currency->code = $request->code;
        $currency->rate = $request->rate;
        $currency->status = $request->status;
        $currency->save();

        $notification=trans('admin_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.add-currencies')->with($notification);
    }


    public function currencyShow($id)
    {
        $currency = Currency::find($id);
        return response()->json(['currency' => $currency], 200);
    }

    public function currencyEdit($id)
    {
        $currency = Currency::find($id);
        return view('admin.edit_currency', compact('currency'));
    }

    public function currencyUpdate(Request $request, $id)
    {
        $currency       =   Currency::find($id);
        $notification   =   trans('admin_validation.Currency not found');
        $type           =   'info';

        if($currency)
        {
            $rules = [
                'name'  =>  'required|unique:currencies,name,'.$currency->id,
                'code'  =>  'required|unique:currencies,code,'.$currency->id,
                'rate'  =>  'required',
                'status'=>  'required'
            ];

            $customMessages = [
                'name.required'     =>  trans('admin_validation.Name is required'),
                'code.required'     =>  trans('admin_validation.Code is required'),
                'rate.required'     =>  trans('admin_validation.Currency rate is required'),
                'name.unique'       =>  trans('admin_validation.Name already exists'),
                'code.unique'       =>  trans('admin_validation.Code already exists'),
            ];

            $this->validate($request, $rules, $customMessages);

            $updated    =   $currency->update([
                'name'      =>  $request->name,
                'code'      =>  $request->code,
                'rate'      =>  $request->rate,
                'status'    =>  $request->status,
            ]);

            $notification   =   trans('admin_validation.Something went wrong');
            $type           =   'info';

            if($updated)
            {
                $notification   =   trans('admin_validation.Updated Successfully');
                $type           =   'success';
            }
        }

        $notification=array('messege'=>$notification,'alert-type'=>$type);
        return redirect()->route('admin.add-currencies')->with($notification);
    }

    public function currencyDestroy($id)
    {
        $currency = Currency::find($id);
        $currency->delete();
        $notification=trans('admin_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.add-currencies')->with($notification);
    }

    // public function test(Request $request)
    // {
    //     $price          =   123;
    //     $category_id    =   3;
    //     $brand_id       =   4;

    //     $request        =   [
    //         'price'         =>  $price,
    //         'category_id'   =>  $category_id,
    //         'brand_id'      =>  $brand_id,
    //     ];


    //     $query          =   Product::query();
    //     $request_data   =   $request;
    //     foreach ($request_data as $r_key => $value)
    //     {
    //         if (isset($request[$r_key]) && !in_array($request[$r_key],["All","undefined"]))
    //         {
    //             switch ($r_key)
    //             {
    //                 case 'price':
    //                 case 'category_id':
    //                 case 'brand_id':
    //                     $query->where($r_key, $request[$r_key]);
    //                 break;
    //             }
    //         }
    //     }

    //     $product   =   $query->latest()->get();

    //     // dd($product);
    //     $product_id =   49;
    //     $currency_id =   165;

    //     $product        =   Product::where('id',$product_id)->first();
    //     $notification   =   trans('admin_validation.Product not found');
    //     $type           =   'info';

    //     if($product)
    //     {
    //         $price          =   $product->offer_price
    //                             ?   $product->offer_price
    //                             :   ($product->price
    //                                 ?   $product->price
    //                                 :   null);
    //         $notification   =   trans('admin_validation.Parice not found');
    //         $type           =   'info';

    //         if($price)
    //         {
    //             $currency       =   Currency::where('id',$currency_id)->first();
    //             $notification   =   trans('admin_validation.Currency not found');
    //             $type           =   'info';

    //             if($currency)
    //             {
    //                 $currency_rate  =   $currency->rate     ?   $currency->rate :   null;
    //                 $notification   =   trans('admin_validation.Currency rate not define');
    //                 $type           =   'info';

    //                 if($currency_rate)
    //                 {
    //                     $amount     =   number_format($price*$currency_rate,3);
    //                 }
    //             }
    //         }
    //     }

    //     dd($amount);
    //     $notification   =   array('messege'=>$notification,'alert-type'=>$type);
    //     return response()->json(['amount'=>$amount]);
    // }


}
