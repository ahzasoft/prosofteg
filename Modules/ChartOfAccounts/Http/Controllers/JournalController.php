<?php

namespace Modules\ChartOfAccounts\Http\Controllers;

use App\Account;
use App\AccountTransaction;
use App\Media;
use App\Transaction;
use App\Utils\ProductUtil;
use App\Utils\Util;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class JournalController extends Controller
{

    protected $commonUtil;
    protected $productUtil;
    public function __construct(Util $commonUtil,ProductUtil $productUtil)
    {
        $this->commonUtil=$commonUtil;
        $this->productUtil=$productUtil;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('chartofaccounts::journal.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('chartofaccounts::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('chartofaccounts::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('chartofaccounts::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function cash_receipt()
    {
        return view('chartofaccounts::journal.cash_receipt.index');
    }

    public function cash_receipt_add()
    {
        $business_id = request()->session()->get('user.business_id');
        $account=new Account();
        $accounts=Account::pluck('name','id');
        $save_account=Account::where('business_id',$business_id)
                   ->where('account_type_id',6)->pluck('name','id');

        $currentdate=$this->commonUtil->format_date(now(),false);

        return view('chartofaccounts::journal.cash_receipt.create',compact(['accounts','account','save_account','currentdate']));
    }

    public function get_cash_receipt(Request $request){

        $business_id = request()->session()->get('user.business_id');
        $transaction=Transaction::where('business_id', $business_id)
            ->where('transactions.type','sell_payment')
            ->join('transaction_types','transaction_types.type','transactions.type')
            ->select('transactions.id as id','transactions.additional_notes','transaction_date'
            ,'transaction_types.description'

            )
            ->orderBy('transaction_date', 'desc')->get();

        $html="";
        $row_no=1;
        foreach ($transaction as $row){
            $html .="<tr>";
            $html .="<td> ".$row->id ."</td>";
            $html .="<td>";
            $html .='<div class="btn-group" style="width:100%">
                    <button type="button" class="btn btn-info dropdown-toggle btn-xs"  style="width:100%"
                        data-toggle="dropdown" aria-expanded="false">' .
                        __("messages.actions") .
                        '<span class="caret"></span><span class="sr-only">Toggle Dropdown
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-left" role="menu">';
                         $html .= '<li><a href="' . action('\Modules\ChartOfAccounts\Http\Controllers\JournalController@cash_receipt_add', [$row->id]) . '"><i class="fas fa-eye" aria-hidden="true"></i>' . __("messages.view") . '</a></li>';
                         $html .= '<li><a href="' . action('\Modules\ChartOfAccounts\Http\Controllers\JournalController@cash_receipt_add', [$row->id]) . '" class=""><i class="glyphicon glyphicon-edit"></i>' .  __("messages.edit") . '</a></li>';
                         $html .= '<li><a href="' . action('\Modules\ChartOfAccounts\Http\Controllers\JournalController@cash_receipt_delete', [$row->id]) . '" class="btn-modal-delete"><i class="glyphicon glyphicon-trash"></i>' . __("messages.delete") . '</a></li>';



                    $html .= '</ul></div>';



            $html .="</td>";
            $html .="<td> ".$this->commonUtil->format_date($row->transaction_date, false) ."</td>";
            $html .="<td>".$row->description."</td>";
           $account=AccountTransaction::where('transaction_id',$row->id)
                ->join('accounts','accounts.id','account_transactions.account_id')->get();

           $loop=0;

         foreach ($account as $record){
               if($loop>0)
                   $html .="<tr>
                   <td></td>
                   <td class='account-link'> <i class='fa fa-angle-left' ></i>   </td>
                   <td colspan='2'>".$row->additional_notes."</td>";

               $html .="<td> ".$record->name."</td>";
               if($record->type=='debit'){
                   $html .="<td> ".$this->commonUtil->num_f($record->amount, true) ."</td>";
                   $html .="<td> </td>";
               }else{
                   $html .="<td> </td>";
                   $html .="<td> ".$this->commonUtil->num_f($record->amount, true) ."</td>";

               }
             if($loop>0){
                   $html .="</tr>";
               }


               $loop +=1;
           }



            $row_no +=1;
        }

    return $html;


    }

    public function __getPaymentDetails($row)
    {
        $details = '';
        if (!empty($row->sub_type)) {
            $details = __('account.' . $row->sub_type);

            if (in_array($row->sub_type, ['fund_transfer', 'deposit']) && !empty($row->transfer_transaction)) {

                    $details .= ' ( ' . __('account.from') .': ' . $row->transfer_transaction->account->name . ')';

                    $details .= ' ( ' . __('account.to') .': ' . $row->transfer_transaction->account->name . ')';

            }
        } else {
            if (!empty($row->transaction->type)) {
                if ($row->transaction->type == 'purchase') {
                    $details = __('lang_v1.purchase') . '<br><b>' . __('purchase.supplier') . ':</b> ' . $row->transaction->contact->full_name_with_business . '<br><b>'.
                        __('purchase.ref_no') . ':</b> <a href="#" data-href="' . action("PurchaseController@show", [$row->transaction->id]) . '" class="btn-modal" data-container=".view_modal">' . $row->transaction->ref_no . '</a>';
                }elseif ($row->transaction->type == 'expense') {
                    $details = __('lang_v1.expense') . '<br><b>' . __('purchase.ref_no') . ':</b>' . $row->transaction->ref_no;
                } elseif ($row->transaction->type == 'sell') {
                    $is_return = $row->is_return == 1 ? ' (' . __('lang_v1.change_return') . ')' : '';
                    $details = __('sale.sale') . $is_return . '<br><b>' . __('contact.customer') . ':</b> ' . $row->transaction->contact->full_name_with_business . '<br><b>'.
                        __('sale.invoice_no') . ':</b> <a href="#" data-href="' . action("SellController@show", [$row->transaction->id]) . '" class="btn-modal" data-container=".view_modal">' . $row->transaction->invoice_no . '</a>';
                }
            } else {
                //for contact payment which is not advance
                if ($row->is_advance != 1) {
                    if ($row->payment_for_type == 'supplier') {
                        $details .= '<b>' . __('purchase.supplier') . ':</b> ';
                    } elseif ($row->payment_for_type == 'customer') {
                        $details .= '<b>' . __('contact.customer') . ':</b> ';
                    } else {
                        $details .= '<b>' . __('account.payment_for') . ':</b> ';
                    }

                    if (!empty($row->payment_for_business_name)) {
                        $details .= $row->payment_for_business_name . ', ';
                    }
                    if (!empty($row->payment_for_contact)) {
                        $details .= $row->payment_for_contact;
                    }
                }
            }
        }

        if (!empty($row->payment_ref_no)) {
            if (!empty($details)) {
                $details .= '<br/>';
            }

            $details .= '<b>' . __('lang_v1.pay_reference_no') . ':</b> ' . $row->payment_ref_no;
        }
        if (!empty($row->transaction->contact) && $row->transaction->type == 'expense') {
            if (!empty($details)) {
                $details .= '<br/>';
            }

            $details .= '<b>';
            $details .= __('lang_v1.expense_for_contact');
            $details .= ':</b> ' . $row->transaction->contact->full_name_with_business;
        }

        if (!empty($row->transaction->transaction_for)) {
            if (!empty($details)) {
                $details .= '<br/>';
            }

            $details .= '<b>' . __('expense.expense_for') . ':</b> ' . $row->transaction->transaction_for->user_full_name;
        }

        if ($row->is_advance == 1) {
            $total_advance = $row->amount - $row->total_recovered;
            $details .= '<br>';

            if ($total_advance > 0) {
                $details .= '<b>' . __('lang_v1.advance_payment') . '</b>: ' . $this->commonUtil->num_f($total_advance, true) . '<br>';
            }

            if (!empty($row->child_sells)) {
                $details .= '<b>' . __('lang_v1.payments_recovered_for') . '</b>: ' . $row->child_sells . '<br>';
            }

            if ($row->payment_for_type == 'supplier') {
                $details .= '<b>' . __('purchase.supplier') . ':</b> ';
            } elseif ($row->payment_for_type == 'customer') {
                $details .= '<b>' . __('contact.customer') . ':</b> ';
            } else {
                $details .= '<b>' . __('account.payment_for') . ':</b> ';
            }

            if (!empty($row->payment_for_business_name)) {
                $details .= $row->payment_for_business_name . ', ';
            }
            if (!empty($row->payment_for_contact)) {
                $details .= $row->payment_for_contact;
            }
        }

        if (!empty($row->added_by)) {
            $details .= '<br><b>' . __('lang_v1.added_by') . ':</b> ' . $row->added_by;
        }

        return $details;
    }

    public function cash_receipt_save(Request $request)
    {

        $business_id = request()->session()->get('user.business_id');
        $transaction_data=[
            'business_id'=>$business_id,
            'type'=>'sell_payment',
            'status'=>'final',
            'total_before_tax'=>0,
            'final_total'=>0,
            'transaction_date'=>  $this->commonUtil->uf_date($request->input('transaction_date'), false),
            'created_by'=>auth()->user()->id,
            'additional_notes'=>$request->input('additional_notes'),
        ];

       DB::beginTransaction();
        $transaction=Transaction::create($transaction_data);

             $debit_data = [
            'business_id'=>$business_id,
            'amount' =>$request->amount,
            'account_id' => $request->debit_account,
            'type' => 'debit',
            'sub_type' => 'fund_transfer',
            'created_by' => session()->get('user.id'),
            'note' => '',
            'transaction_id' => $transaction->id,
            'operation_date' => $this->commonUtil->uf_date($request->input('transaction_date'), false),
        ];

        $debit = AccountTransaction::createAccountTransaction($debit_data);

        $credit_data = [
            'business_id'=>$business_id,
            'amount' =>$request->amount,
            'account_id' => $request->credit_account,
            'type' => 'credit',
            'sub_type' => 'fund_transfer',
            'created_by' => session()->get('user.id'),
            'note' =>'',
            'transaction_id' => $transaction->id,
            'transfer_transaction_id'=>$debit->id,
            'operation_date' => $this->commonUtil->uf_date($request->input('transaction_date'), false),
        ];

        $credit = AccountTransaction::createAccountTransaction($credit_data);
        $debit->transfer_transaction_id = $credit->id;
        $debit->save();


        Media::uploadMedia($business_id, $transaction, $request, 'document');

        DB::commit();

        $output=['success'=>true,
            'msg'=>'تم حفظ السند بنجاح'];

        return $output;
    }

    public function cash_receipt_delete($id)
    {
        $transaction= Transaction::where('id',$id)->first();
        DB::beginTransaction();
        $transaction->delete();
        AccountTransaction::where('transaction_id',$id)->delete();
        DB::commit();
        $output=['success'=>true,
            'msg'=>'تم حذف القيد بنجاح'];
        return $output;
    }


}
