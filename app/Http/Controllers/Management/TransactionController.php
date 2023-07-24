<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Management\Ledger;
use App\Models\Management\Category; 
use App\Models\Management\AccountType; 
use App\Classes\Traits\UserExportTrait;



class TransactionController extends Controller
{
    use UserExportTrait;

    public function index(Request $request){
        $requests =$request->all();
        $category_group =$requests['category_group'] ?? null;
        $requests ? $num =null : $num =1000;
        $categories =Category::orderBy('name_en','ASC')->get();
        $accounts   =AccountType::get();
        $ledgers    =Ledger::with('user','category','account','account.account_type')
                    ->when($requests ,function ($query) use ($requests){
                        $query->withFilters($requests);
                    })
                    ->whereHas('account',function ($query) use ($requests){
                        $query->withFilters($requests);
                    })
                    ->when($category_group, function ($query) use ($category_group) {
                        $query->whereHas('category', function ($query) use ($category_group) {
                            $query->where('category_group', $category_group);
                        });
                    })
                    ->latest()
                    ->limit($num)
                    ->get();
        return view('reports.transactions',compact('ledgers','categories','requests','accounts'));
    }

   

    public function goals(){
       // return "dah";
        return view('reports.goals');
    }

    public function generateReport(Request $request){
        $requests =$request->all();
        $requests ? $num =null : $num =1000;
        $ledgers =Ledger::with('user','category','account','account.account_type')
                    ->when($requests ,function ($query) use ($requests){
                        $query->withFilters($requests);
                    })
                    ->whereHas('account',function ($query) use ($requests){
                        $query->withFilters($requests);
                    })
                   ->latest()
                   ->limit($num)
                   ->get();  

        return $this->extendTransationReport($ledgers);
    }
}
