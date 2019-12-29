<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Enums\AccountEnum;
use App\Enums\GenderEnum;
use App\Enums\StatusEnum;

use App\Admin\Address\Provinces;

use App\Admin\Customer\Occupations;
use App\Admin\Customer\Statuses;
use App\Admin\Customer\Images;
use App\Admin\Customer\Reason;
use App\Admin\Customer\People;

use App\Admin\Account\Accounts;
use App\Admin\Account\AccountTypeItems;
use App\Admin\Account\Loans;
use App\Admin\Account\PaymentTypes;

use App\Admin\App\Theme;

use Session;
class LoanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function index(){
      $theme=Theme::findOrFail(1);
      $loans=Loans::with(['people','account','account_type_item'])->paginate(15);
      return view('admin.loan.index')->with('loans',$loans)->with('theme',$theme);
    }

    // show create loan form
    public function create(){
      $provinces=Provinces::where('actived',1)->get();
      $occupations=Occupations::where('actived',1)->get();
      $statuses=Statuses::all();
      $theme=Theme::findOrFail(1);
      $account_type_items=AccountTypeItems::where('account_type_id',1)->get();
      return view('admin.loan.create')->with('provinces',$provinces)
        ->with('occupations',$occupations)->with('statuses',$statuses)
        ->with('account_type_items',$account_type_items)
        ->with('theme',$theme);
    }

    // store method
    public function store(Request $request){
      // dd($request->all());
      // Session::flash('success','ការស្នើរសុំបានជោគជ័យ');
      // return redirect(route('admin.loan.index'));
      // exit;

      try {
        DB::beginTransaction();
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
        $account_type_id=AccountEnum::LOAN;
        $accountTypeItemId=$request->loan_type;
        $startAt=$request->start_at;
        $beginAmount=$request->begin_amount;

        // let insert to Database
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
        $people->created_by=$request->user_id;
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
        $account->account_no=mt_rand(00000000, 99999999);
        $account->actived=StatusEnum::ACTIVE;
        $account->created_by=$request->user_id;
        $account->save();
        $last_account_id=$account->id;
        //
           //to table loans
        $loans=new Loans();
        $loans->people_id=$last_people_id;
        $loans->account_id=$last_account_id;
        $loans->status_id=StatusEnum::ACTIVE;
        $loans->account_type_item_id=$accountTypeItemId;
        $loans->started_at=$startAt;
        $loans->closed_at=$request->close_at;
        $loans->begin_amount=$beginAmount;
        $loans->balance=$beginAmount;
        $loans->interest_rate=$request->percent_rate;
        $loans->created_by=$request->user_id;
        $loans->save();

        DB::commit();
        Session::flash('success','ការស្នើរសុំបានជោគជ័យ');
        return redirect(route('admin.loan.index'));
      } catch (Exception $e) {
        DB::rollback();
        Session::flash('error','ការស្នើរសុំបានបរាជ័យ');
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

}
