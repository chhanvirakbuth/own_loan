<?php

namespace App\Http\Controllers\Admin\Account;
use Phanna\Converter\KhmerDatetime;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Admin\Account\Deposits;
use App\Admin\Account\AccountTypeItems;
use App\Admin\Account\Accounts;
use App\Admin\Account\PaymentTransactions;
use App\Admin\Account\PaymentTypes;

use App\Enums\StatusEnum;
use App\Enums\AccountEnum;
use App\Enums\DepositEnum;
use App\Enums\PaymentTypeEnum;

use App\Admin\App\Theme;

use App\Admin\Address\Provinces;
use App\Admin\Address\Districts;
use App\Admin\Address\Communes;
use App\Admin\Address\Villages;

use App\Admin\Customer\Occupations;
use App\Admin\Customer\Statuses;
use App\Admin\Customer\People;

use Session;
use Carbon\Carbon;
use Auth;
class DepositController extends Controller
{
    // __construct
    public function __construct(){
      $this->middleware(['auth','is_admin']);
    }
    //index Deposit
    public function index(){
      $theme=Theme::findOrFail(1);
      $date=date('y-m-d');
      $khmer = new KhmerDatetime($date);
      $deposits=Deposits::where('actived',StatusEnum::ACTIVE)->paginate(15);
      return view('admin.deposit.index')->with('theme',$theme)->with('deposits',$deposits)
      ->with('khmer',$khmer);
    }

    // show register function
    public function create(){
      $provinces=Provinces::where('actived',1)->get();
      $occupations=Occupations::where('actived',1)->get();
      $statuses=Statuses::all();
      $theme=Theme::findOrFail(1);
      $account_type_items=AccountTypeItems::where('account_type_id',AccountEnum::DEPOSIT)->get();
      return view('admin.deposit.create')->with('provinces',$provinces)
        ->with('occupations',$occupations)->with('statuses',$statuses)
        ->with('account_type_items',$account_type_items)
        ->with('theme',$theme);
    }

    // store/post to the database
    public function store(Request $request){
      try {
        DB::beginTransaction();
        // ##############start validation#######################################
        $this->validate($request,[
          'full_name'=>'required|max:50',
          'latin_name'=>'nullable|max:50',
          'nickname'=>'nullable|max:50',
          'inlineradio'=>'required|integer|exists:cts_genders,id',
          'occupation'=>'required|integer|exists:cts_occupations,id',
          'birth_of_date'=>'required|date_format:Y-m-d',
          'id_card_number'=>'required|max:50',
          'status'=>'required|max:255',
          'your_phone_number'=>'required|max:15',
          'email'=>'nullable|email|max:50',
          'provinces'=>'required|integer|exists:adr_provinces,id',
          'districts'=>'required|integer|exists:adr_districts,id',
          'communes'=>'required|integer|exists:adr_communes,id',
          'villages'=>'required|integer|exists:adr_villages,id',
          'avatar'=>'nullable|max:10240',
          'id_card'=>'nullable|max:10240',
          'loan_type'=>'required|integer|exists:acc_account_type_items,id',
          'percent_rate'=>'nullable',
          'begin_amount'=>'required|max:10',
          'start_at'=>'required|date_format:Y-m-d',

        ]);
        // ##############end of validation######################################
        // some decleartion
        $account_type_item=AccountTypeItems::findOrFail($request->loan_type);
        $percent_rate=$account_type_item->interest_rate;
        $account_type_id=AccountEnum::DEPOSIT;
        $user = Auth::user();

        // post to table people
        $people=new People();
        $people->gender_id=$request->inlineradio;
        $people->occupation_id=$request->occupation;
        $people->province_id=$request->provinces;
        $people->district_id=$request->districts;
        $people->commune_id=$request->communes;
        $people->village_id=$request->villages;
        $people->name_kh=$request->full_name;
        $people->name_en=$request->latin_name;
        $people->nick_name=$request->nickname;
        $people->date_of_birth=$request->birth_of_date;
        $people->phone_no=$request->your_phone_number;
        $people->id_card_number=$request->id_card_number;
        $people->email=$request->email;
        $people->status_id=$request->status;
        $people->actived=StatusEnum::ACTIVE;
        $people->created_by=$user->id;
        // check if has file then upload'to images table
        if($request->hasFile('avatar')){ //store to table people at avatar field
          $people->avatar = $request->file('avatar')->store('avatars');

        }
        // if has id card
        if ($request->hasFile('id_card')) {
          $people->idcard=$request->file('id_card')->store('idcards');
        }
        $people->save();
        $last_people_id=$people->id;

        // post to account
        $account =new Accounts() ;
        $account->people_id=$last_people_id;
        $account->account_type_id=$account_type_id;
        $account->account_type_item_id=$request->loan_type;
        $code=mt_rand(00000000, 99999999);
        if (Accounts::where('account_no', '=', $code)->count() > 0) {
          // found...
          $new_code=mt_rand(00000000, 99999999);
          $account->account_no=$new_code;
        } else {
          // note found...
          $account->account_no=$code;
        }
        $account->actived=StatusEnum::ACTIVE;
        $account->created_by=$user->id;
        $account->save();
        $last_account_id=$account->id;

        // post to table deposit
        $deposits=new Deposits();
        $deposits->people_id=$last_people_id;
        $deposits->account_id=$last_account_id;
        $deposits->status=StatusEnum::INACTIVE; //mean that already saving
        $deposits->account_type_item_id=$request->loan_type;
        $deposits->started_at=$request->start_at;
        $deposits->begin_amount=$request->begin_amount;
        $deposits->balance=$request->begin_amount;
        $deposits->interest_rate=$percent_rate;
        $deposits->n_of_paid_interest+=1;
        $deposits->created_by=$user->id;
        $deposits->save();
        $last_deposit_id=$deposits->id;
        // create new transaction
        $transaction=new PaymentTransactions();
        $p_type=PaymentTypes::findOrFail($account->account_type_item_id);
        $transaction->people_id=$last_people_id;
        $transaction->deposit_id=$last_deposit_id;
        $transaction->account_id=$last_account_id;
        $transaction->status=DepositEnum::PAID;
        $transaction->payment_type=$p_type->name_kh;
        $transaction->payment_date=Carbon::now('GMT+7');
        $transaction->payment_type_id=$p_type->id;
        $transaction->account_no=$account->account_no;
        $transaction->begin_amount=$deposits->begin_amount;
        $transaction->amount=$deposits->begin_amount;
        $transaction->balance=$deposits->begin_amount;
        $transaction->transaction_at=Carbon::now('GMT+7');
        $transaction->actived=StatusEnum::ACTIVE;
        $transaction->created_by=$user->id;
        $transaction->save();
        DB::commit();
        Session::flash('success','គណនីសន្សំបានបង្កើតជោគជ័យ..');
        return redirect()->route('deposit.create');
      } catch (Exception $e) {
        DB::rollBack();
      }

    }

    // for detail view
    public function detail($id){
      $theme=Theme::findOrFail(1);
      $account=Accounts::where('account_type_id',AccountEnum::DEPOSIT)->where('account_no',$id)->firstOrFail();
      $id=$account->people->deposits[0]->id;
      $deposit=Deposits::findOrFail($id);
      $transaction=PaymentTransactions::where('account_id',$deposit->account_id)->where('payment_type_id','!=',PaymentTypeEnum::WITHDRAW)->orderBy('id','DESC')->get();
      return view('admin.deposit.detail')->with('theme',$theme)
      ->with('deposit',$deposit)->with('transaction',$transaction);
    }


    // editing
    public function edit($id)
    {
      $account=Accounts::where('account_type_id',AccountEnum::DEPOSIT)->where('account_no',$id)->firstOrFail();
      $id=$account->people->deposits[0]->id;
      $deposit=Deposits::findOrFail($id);
      $provinces=Provinces::where('actived',1)->get();
      $districts=Districts::where('province_id',$deposit->people->province->id)->get();
      $communes=Communes::where('province_id',$deposit->people->province->id)
                ->where('district_id',$deposit->people->district->id)->get();
      $villages=Villages::where('province_id',$deposit->people->province->id)
                ->where('district_id',$deposit->people->district->id)
                ->where('commune_id',$deposit->people->commune->id)->get();
      $occupations=Occupations::where('actived',1)->get();
      $statuses=Statuses::all();
      $theme=Theme::findOrFail(1);
      $account_type_items=AccountTypeItems::where('account_type_id',AccountEnum::DEPOSIT)->get();

      return view('admin.deposit.edit')
        ->with('theme',$theme)->with('deposit',$deposit)
        ->with('provinces',$provinces)->with('occupations',$occupations)
        ->with('statuses',$statuses)->with('account_type_items',$account_type_items)
        ->with('districts',$districts)->with('communes',$communes)
        ->with('villages',$villages);
    }

    // editing process //update account information
    public function  updateAccount(Request $request,$id){
      $deposit=Deposits::findOrFail($id);
      $people=People::findOrFail($deposit->people->id);
      $account=Accounts::findOrFail($deposit->account->id);
      $user=Auth::user();
      // some decleartion
      $account_type_item=AccountTypeItems::findOrFail($request->loan_type);
      $percent_rate=$account_type_item->interest_rate;
      // validation rule
      $this->validate($request,[
        'full_name'=>'required|max:50',
        'latin_name'=>'nullable|max:50',
        'nickname'=>'nullable|max:50',
        'inlineradio'=>'required|integer|exists:cts_genders,id',
        'occupation'=>'required|integer|exists:cts_occupations,id',
        'birth_of_date'=>'required|date_format:Y-m-d',
        'id_card_number'=>'required|max:50',
        'status'=>'required|max:255',
        'your_phone_number'=>'required|max:15',
        'email'=>'nullable|email|max:50',
        'provinces'=>'required|integer|exists:adr_provinces,id',
        'districts'=>'required|integer|exists:adr_districts,id',
        'communes'=>'required|integer|exists:adr_communes,id',
        'villages'=>'required|integer|exists:adr_villages,id',
        'avatar'=>'nullable|max:10240',
        'id_card'=>'nullable|max:10240',
        'loan_type'=>'required|integer|exists:acc_account_type_items,id',
        'percent_rate'=>'nullable',
        'begin_amount'=>'required|max:10',
        'start_at'=>'required|date_format:Y-m-d',
      ]);

      try {
        DB::beginTransaction();
        // update table people
        $people->gender_id=$request->inlineradio;
        $people->occupation_id=$request->occupation;
        $people->province_id=$request->provinces;
        $people->district_id=$request->districts;
        $people->commune_id=$request->communes;
        $people->village_id=$request->villages;
        $people->name_kh=$request->full_name;
        $people->name_en=$request->latin_name;
        $people->nick_name=$request->nickname;
        $people->date_of_birth=$request->birth_of_date;
        $people->phone_no=$request->your_phone_number;
        $people->id_card_number=$request->id_card_number;
        $people->email=$request->email;
        $people->status_id=$request->status;
        $people->actived=StatusEnum::ACTIVE;
        $people->updated_by=$user->id;
        // check if has file then upload'to images table
        if($request->hasFile('avatar')){ //store to table people at avatar field
          $people->avatar = $request->file('avatar')->store('avatars');

        }
        // if has id card
        if ($request->hasFile('id_card')) {
          $people->idcard=$request->file('id_card')->store('idcards');
        }
        $people->save();

        // update table account
        $account->account_type_id=AccountEnum::DEPOSIT;
        $account->account_type_item_id=$request->loan_type;
        $account->actived=StatusEnum::ACTIVE;
        $account->updated_by=$user->id;
        $account->save();
        // update table deposit
        $deposit->status=StatusEnum::INACTIVE; //mean that already saving
        $deposit->account_type_item_id=$request->loan_type;
        $deposit->started_at=$request->start_at;
        $deposit->begin_amount=$request->begin_amount;
        $deposit->balance=$request->begin_amount;
        $deposit->interest_rate=$percent_rate;
        $deposit->updated_by=$user->id;
        $deposit->save();

        DB::commit();
        Session::flash('success','ការកែបានជោគជ័យ!');
        return redirect()->route('deposit.index');
      } catch (Exception $e) {
        DB::rollback();
      }

    }


    // searching view
    public function search(){
      $theme=Theme::findOrFail(1);
      return view('admin.deposit.search')->with('theme',$theme);
    }

    // searching result
    public function result(Request $request){
      $this->validate($request,[
        'account_no'=>'required|numeric'
      ]);
      $no=$request->account_no;
      $theme=Theme::findOrFail(1);
      $account=Accounts::where('account_type_id',AccountEnum::DEPOSIT)->where('account_no',$no)->first();
      if ($account == null) {
        Session::flash('warning','មិនមានក្នុងប្រព័ន្ធ!');
        return redirect()->back();
      } else {
        $id=$account->people->deposits[0]->id;
        $deposit=Deposits::findOrFail($id);
        $transaction=PaymentTransactions::where('account_id',$deposit->account->id)
                    ->where('payment_type_id','!=',PaymentTypeEnum::WITHDRAW)->orderBy('id','DESC')->get();
        return view('admin.deposit.result')->with('theme',$theme)
        ->with('deposit',$deposit)->with('account',$account)
        ->with('transaction',$transaction);
      }
      // exit;
    }

}
