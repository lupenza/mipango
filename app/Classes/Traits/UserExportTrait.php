<?php

namespace App\Classes\Traits;
use Rap2hpoutre\FastExcel\FastExcel;


trait UserExportTrait{
    public function extendUserExport($users){

        return (new FastExcel($this->usersGenerator($users)))->download('UseReport.xlsx',function($user){

            return [
                'Reg Date' =>date('d ,M-Y H:i:s',strtotime($user->created_at)),
                'Name'     =>$user->name .' '.$user->last_name,
                'Email'    =>$user->email,
                'Phone Number'    =>$user->phone,
                'Country'         =>$user->country,
                'Region'          =>$user->region,
                'Occupation'      =>$user->occupation,
                'Device Type'      =>$user->device_type,
                'No of Accounts'   =>$user->accounts->count(),
                'Accounts Total Balance'   =>$user->accounts->sum('balance'),
                'No of Budgets'   =>$user->budgets->count(),
                'Budgets Total Amount'   =>$user->budgets->sum('amount'),
                'User Status'            =>$user->accounts_count > 0 ? "Active User": "In Active User"
            ];
        });
    }

    function usersGenerator($users) {
        foreach ($users as $user) {
            yield $user;
        }
    }

    public function extendBudgetExport($budgets){
        //return "here";
        return (new FastExcel($this->budgetsGenerator($budgets)))->download('BudgetReport.xlsx',function($budget){

            return [
                'Reg Date' =>date('d ,M-Y H:i:s',strtotime($budget->created_at)),
                'Name'     =>$budget->user->name ?? null .' '.$budget->user->last_name ?? null,
                'Email'    =>$budget->user->email ?? null,
                'Phone Number'    =>$budget->user->phone ?? null,
                'Budget Name'     =>$budget->name,
                'Budget category'     =>$budget->category->name_en ?? null,
                'Budget Description'     =>$budget->description,
                'Budget Amount'          =>$budget->amount,
            ];
        });
    }

    function budgetsGenerator($budgets) {
        foreach ($budgets as $budget) {
            yield $budget;
        }
    }
    public function extendTransationReport($ledgers){
        //return "here";
        return (new FastExcel($this->transactionsGenerator($ledgers)))->download('TransactionReport.xlsx',function($ledger){

            return [
                'Reg Date' =>date('d ,M-Y H:i:s',strtotime($ledger->created_at)),
                'Name'     =>$ledger->user->name ?? null .' '.$ledger->user->last_name ?? null,
                'Email'    =>$ledger->user->email ?? null,
                'Phone Number'    =>$ledger->user->phone ?? null,
                'Transaction category'     =>$ledger->category->name_en ?? null,
                'Transaction category Group'     =>$ledger->category->category_group ?? null,
                'Transaction Description'     =>$ledger->description,
                'Transaction Amount'          =>$ledger->amount,
                'Transaction Type'            =>$ledger->txn_type,
                'Account Name'                =>$ledger->account->name ?? null,
                'Account Type'                =>$ledger->account->account_type->name ?? null,
                'Account Balance'             =>$ledger->account->balance ?? 0
            ];
        });
    }

    function transactionsGenerator($ledgers) {
        foreach ($ledgers as $ledger) {
            yield $ledger;
        }
    }
}
