<?php

namespace App\Http\Controllers\Admin\Account;
use Phanna\Converter\KhmerDatetime;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Enums\AccountEnum;
use App\Enums\GenderEnum;
use App\Enums\StatusEnum;
use App\Enums\LoanStatusEnum;
use App\Enums\PaymentTypeEnum;

use App\Admin\Address\Provinces;
use App\Admin\Address\Districts;
use App\Admin\Address\Communes;
use App\Admin\Address\Villages;

use App\Admin\Customer\Occupations;
use App\Admin\Customer\Statuses;
use App\Admin\Customer\Images;
use App\Admin\Customer\Reason;
use App\Admin\Customer\People;

use App\Admin\Account\Accounts;
use App\Admin\Account\AccountTypeItems;
use App\Admin\Account\Loans;
use App\Admin\Account\PaymentTypes;
use App\Admin\Account\PaymentTransactions;

use App\Admin\App\Theme;


use Session;
use Carbon\Carbon;
use Auth;
class LoanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }
    //
    public function index(){
      $theme=Theme::findOrFail(1);
      $loans=Loans::where('balance','!=' , 0)->paginate(15);
      return view('admin.loan.index')->with('loans',$loans)->with('theme',$theme);
    }
    // show unpaid customer
    public function unpaid(){
      $theme=Theme::findOrFail(1);
      $date=date('y-m-d');
      $khmer = new KhmerDatetime($date);
      $loans=Loans::paginate(15);
      return view('admin.loan.unpaid')->with('loans',$loans)->with('theme',$theme)
      ->with('khmer',$khmer);
    }
    // show create loan form
    public function create(){
      // find out all the total money
      $transaction=PaymentTransactions::sum('amount'); //it the income
      $total_withdraw=PaymentTransactions::where('payment_type_id',PaymentTypeEnum::WITHDRAW)->sum('balance');
      $loan=Loans::sum('begin_amount');
      $left_amount=$transaction-$loan - $total_withdraw;
      if ($left_amount == null) {
        Session::flash('error','មិនមានប្រាក់សម្រាប់ផ្ដល់កម្ចី');
        return redirect()->back();
      }
      // end of checking condition
      $provinces=Provinces::where('actived',1)->get();
      $occupations=Occupations::where('actived',1)->get();
      $statuses=Statuses::all();
      $theme=Theme::findOrFail(1);
      $account_type_items=AccountTypeItems::where('account_type_id',AccountEnum::LOAN)->get();
      return view('admin.loan.create')->with('provinces',$provinces)
        ->with('occupations',$occupations)->with('statuses',$statuses)
        ->with('account_type_items',$account_type_items)
        ->with('theme',$theme);
    }

    // store method
    public function store(Request $request){
      // check validation
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
        'percent_rate'=>'required',
        'begin_amount'=>'required|max:10',
        'reason'=>'required|max:255',
        'start_at'=>'required|date_format:Y-m-d',
        'close_at'=>'nullable|date_format:Y-m-d'
      ]);
      // end check validation
      $request_loan=$request->begin_amount;
      // find out all the total money
      $transaction=PaymentTransactions::sum('amount'); //it the income
      $total_withdraw=PaymentTransactions::where('payment_type_id',PaymentTypeEnum::WITHDRAW)->sum('balance');
      $loan=Loans::sum('begin_amount');
      $left_amount=$transaction-$loan - $total_withdraw;
      // check condition
      if ($left_amount < $request_loan) {
        Session::flash('error','លុយមិនគ្រប់សម្រាប់ផ្ដល់កម្ចី!');
        return redirect()->back();
      } else {
        // loan process
        try {
          DB::beginTransaction();
          $account_type_id=AccountEnum::LOAN;
          $accountTypeItemId=$request->loan_type;
          $startAt=$request->start_at;
          $beginAmount=$request->begin_amount;
          $rate=AccountTypeItems::findOrFail($accountTypeItemId);

          // let insert to Database
            $user = Auth::user();
            // to table people
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

             // to table reason
          $reasons=new Reason();
          $reasons->people_id=$last_people_id;
          $reasons->title=$request->reason;
          $reasons->save();

            //to table account
          $account =new Accounts() ;
          $account->people_id=$last_people_id;
          $account->account_type_id=$account_type_id;
          $account->account_type_item_id=$accountTypeItemId;
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
          $account->status=StatusEnum::ACTIVE;
          $account->created_by=$user->id;
          $account->save();
          $last_account_id=$account->id;
          //
             //to table loans

          $loans=new Loans();
          $loans->people_id=$last_people_id;
          $loans->account_id=$last_account_id;
          $loans->status=StatusEnum::ACTIVE;
          $loans->account_type_item_id=$accountTypeItemId;
          $loans->started_at=$startAt;
          $loans->closed_at=$request->close_at;
          $loans->begin_amount=$beginAmount;
          $loans->balance=$beginAmount;
          $loans->interest_rate=$rate->interest_rate;
          $loans->created_by=$user->id;
          $loans->save();

          DB::commit();
          Session::flash('success','ការស្នើរសុំបានជោគជ័យ');
          return redirect(route('admin.loan.index'));
        } catch (Exception $e) {
          DB::rollBack();
          Session::flash('error','ការស្នើរសុំបានបរាជ័យ');
        }
      }



    }

    // show loaner profile
    public function show($id){
      $loans=Loans::findOrFail($id);
      $theme=Theme::findOrFail(1);
      return view('admin.loan.show')->with('loans',$loans)->with('theme',$theme);
      // exit;
    }

    // get Loan Rate
    public function getLoanRate($id)
    {
      $rate=AccountTypeItems::where('id',$id)->pluck('interest_rate','id');
      return json_encode($rate);
    }

    // view edit loans
    public function edit($id){
      $loans=Loans::findOrFail($id);
      $provinces=Provinces::where('actived',1)->get();
      $districts=Districts::where('province_id',$loans->people->province->id)->get();
      $communes=Communes::where('province_id',$loans->people->province->id)
                ->where('district_id',$loans->people->district->id)->get();
      $villages=Villages::where('province_id',$loans->people->province->id)
                ->where('district_id',$loans->people->district->id)
                ->where('commune_id',$loans->people->commune->id)->get();
      $occupations=Occupations::where('actived',1)->get();
      $statuses=Statuses::all();
      $theme=Theme::findOrFail(1);
      $account_type_items=AccountTypeItems::where('account_type_id',1)->get();
      return view('admin.loan.edit')->with('loans',$loans)->with('theme',$theme)
      ->with('provinces',$provinces)->with('occupations',$occupations)
      ->with('statuses',$statuses)->with('account_type_items',$account_type_items)
      ->with('districts',$districts)->with('communes',$communes)
      ->with('villages',$villages);
    }

    // update loan Edit account loan
    public function update(Request $request, $id){
      try {
        DB::beginTransaction();
        // check validation
        // dd($request->begin_amount);
        // exit;
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
          'percent_rate'=>'required',
          'begin_amount'=>'required',
          'balance'=>'required',
          'reason'=>'required|max:255',
          'start_at'=>'required|date_format:Y-m-d',
          'close_at'=>'nullable|date_format:Y-m-d'
        ]);

        $user = Auth::user();

        $loans=Loans::findOrFail($id);
        // update table people
        $people=People::findOrFail($loans->people->id);
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

        // update table reason
        $reason=Reason::findOrFail($loans->people->reason->id);
        $reason->people_id=$loans->people->id;
        $reason->title=$request->reason;
        $reason->save();

        // update to table account
        $account =Accounts::findOrFail($loans->account_id);
        $account->people_id=$loans->people->id;
        $account->account_type_item_id=$request->loan_type;
        $account->updated_by=$user->id;
        $account->save();

        // update to table loan
        $rate=AccountTypeItems::findOrFail($request->loan_type);

        $loans->account_type_item_id=$request->loan_type;
        $loans->started_at=$request->start_at;
        $loans->closed_at=$request->close_at;
        $loans->begin_amount=$request->begin_amount;
        $loans->balance=$request->balance;
        $loans->interest_rate=$rate->interest_rate;
        $loans->updated_by=$user->id;
        $loans->save();
        DB::commit();

        Session::flash('success','កែប្រែបានជោគជ័យ!');
        return redirect(route('admin.loan.index'));

      } catch (Exception $e) {
        DB::rollback();

      }

    }
}
