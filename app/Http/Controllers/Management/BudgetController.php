<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Management\Budget;
use App\Models\Management\Category; 
use App\Classes\Traits\UserExportTrait;


class BudgetController extends Controller
{
  use UserExportTrait;
    public function index(Request $request){
        $requests   =$request->all();
        $categories =Category::get();
        $budgets    =Budget::with('user','category')
                  ->when($requests, function ($query) use ($requests){
                    $query->withFilters($requests);
                  })
                  ->latest()
                  ->get();
        return view('reports.budgets',compact('budgets','categories','requests'));
     }

     public function generateReport(Request $request){
      $requests   =$request->all();
      $budgets    =Budget::with('user','category')
                ->when($requests, function ($query) use ($requests){
                  $query->withFilters($requests);
                })
                ->latest()
                ->get();
      
      return $this->extendBudgetExport($budgets);
     }
}
