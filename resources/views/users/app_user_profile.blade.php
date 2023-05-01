@extends('layouts.master')
@section('content')

<style>
    .table th{
        background-color: #fa03241e;
    }
    .nav-text{
        font-size: 13px !important;
        font-weight: 500 !important;
    }
</style>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">App User Profile</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Details</a></li>
                            <li class="breadcrumb-item active">App User Profile</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
                <div class="card">
                    <div class="col-md-12">
                        <div class="card-body table-responsive">
                            <div> 
                                <h4 class="card-title text-center">App User Profile</h4>
                            </div>
                            {{-- <div class="page-header">
                                <div class="header-center">
                                    <h4 class="card-title" >Loan Application Profile</h4>
                                </div>
                            </div> --}}
                            
                            <table class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                <tr class="text-center">
                                    <td colspan="6"><h6>User Kyc</h6></td>
                                </tr>
                                </thead>
                                <tbody>
                                   <tr>
                                    <th>First Name</th>
                                    <td>{{ $user->name ?? "N\A"  }}</td>
                                    <th>Last Name</th>
                                    <td>{{ $user->last_name ?? "N\A"  }}</td>
                                   </tr>
                                   <tr>
                                    <th>Gender</th>
                                    <td>{{ $user->gender ?? "N\A" }}</td>
                                    <th>DOB</th>
                                    <td>{{ $user->dob ?? "N\A"  }}</td>
                                   </tr>
                                   <tr>
                                    <th>Phone</th>
                                    <td>{{ $user->phone  ?? "N\A" }}</td>
                                    <th>Email</th>
                                    <td>{{ $user->email  ?? "N\A" }}</td>
                                   </tr>
                                   <tr>
                                    <th>Country</th>
                                    <td>{{ $user->country ?? "N\A"  }}</td>
                                    <th>Region</th>
                                    <td>{{ $user->region ?? "N\A"  }}</td>
                                   </tr>
                                   <tr>
                                    <th>Occupation</th>
                                    <td>{{ $user->occupation ?? "N\A"  }}</td>
                                    <th>Device Type</th>
                                    <td>{{ $user->device_type ?? "N\A"  }}</td>
                                   </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12" style="padding: 2px  20px  2px 20px">
                        <h4 class="card-title text-center">Other Details</h4>

                          <ul class="nav nav-pills nav-fill gap-2 p-1 small bg-danger rounded-5 shadow-sm" id="pillNav2" role="tablist" style="--bs-nav-link-color: var(--bs-white); --bs-nav-pills-link-active-color: var(--bs-primary); --bs-nav-pills-link-active-bg: var(--bs-white);">
                            <li class="nav-item" role="presentation">
                              <button class="nav-link active rounded-5" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment-tab-pane" type="button" role="tab" aria-selected="true"> <span class="nav-text">User's Accounts</span> </button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link rounded-5" id="repayment-tab" data-bs-toggle="tab" type="button" data-bs-target="#repayment-tab-pane" role="tab" aria-selected="false"> <span class="nav-text">User's Transactions</span> </button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link rounded-5" id="affordability-tab" data-bs-toggle="tab" data-bs-target="#affordability-tab-pane"  type="button" role="tab" aria-selected="false"><span class="nav-text">User's Budgets</span></button>
                            </li>
                          </ul>
                          <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="payment-tab-pane" role="tabpanel" aria-labelledby="payment-tab" tabindex="0">
                                <div class="col-md-12" style="padding: 10px 2px 10px 2px">
                                    <h4 class="card-title text-center">User Accounts</h4>
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Reg Date</th>
                                                    <th>Account Type</th>
                                                    <th>Account Name</th> 
                                                    <th>Account Number</th>
                                                    <th>Bank</th>
                                                    <th>Balance</th>
                                                  </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($user->accounts as $account )
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ date('d-m-Y H:i:s',strtotime($account->created_at ))}}</td>
                                                    <td>{{ $account->account_type->name  }}</td> 
                                                    <td>{{ $account->name }}</td> 
                                                    <td>{{ $account->account_number }}</td> 
                                                    <td>{{ $account->bank }}</td> 
                                                    <td>{{ number_format($account->balance) }}</td> 
                                                </tr>
                                                @endforeach
                                             </tbody> 
                                           
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="repayment-tab-pane" role="tabpanel" aria-labelledby="repayment-tab" tabindex="0">
                                <div class="col-md-12" style="padding: 10px 2px 10px 2px">
                                    <h4 class="card-title text-center">User's Transactions</h4>
                                    <div class="table-responsive">
                                        <table id="datatable1" class="table table-bordered dt-responsive  nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Reg Date</th>
                                                    <th>Amount</th>
                                                    <th>Description</th>
                                                    <th>Category</th>
                                                    <th>Account</th>
                                                    <th>Txn Type</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($user->ledgers as $ledger)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ date('d ,M-Y H:i:s',strtotime($ledger->created_at))}}</td>
                                                        <td>{{ number_format($ledger->amount) }}</td>
                                                        <td>{{ $ledger->description}}</td>
                                                        <td>{{ $ledger->category->name_en ?? null}}</td>
                                                        <td>{{ $ledger->account->name ?? null}}</td>
                                                        <td>{{ $ledger->txn_type }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="affordability-tab-pane" role="tabpanel" aria-labelledby="affordability-tab" tabindex="0">
                                <div class="col-md-12" style="padding: 10px 2px 10px 2px">
                                    <h4 class="card-title text-center">User's Budget</h4>
                                    <table id="datatable2" class="table table-bordered dt-responsive  nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Reg Date</th>
                                                <th>Budget Name</th>
                                                <th>Amount</th>
                                                <th>Category</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($user->budgets as $budget)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ date('d ,M-Y H:i:s',strtotime($budget->created_at))}}</td>
                                                    <td>{{ $budget->name }}</td>
                                                    <td>{{ number_format($budget->amount)}}</td>
                                                    <td>{{ $budget->category->name_en ?? "N\A"}}</td>
                                                </tr>
                                                    
                                                @endforeach
                                                
                                            </tbody>
                                    </table>

                                </div>
                            </div>
                            {{-- <div class="tab-pane fade" id="gsm-tab-pane" role="tabpanel" aria-labelledby="gsm-tab" tabindex="0">
                                <div class="col-md-12" style="padding: 10px 2px 10px 2px">
                                    @if ($contract->loan_application->affordability)
                                    @if ($contract->loan_application->affordability->credit_info)
                                    @if ($contract->loan_application->affordability->credit_info->gsm_data)
                                    <table class="table table-bordered dt-responsive  nowrap w-100" style="border-radius: 10px">
                                        <thead>
                                        <tr class="text-center">
                                            <td colspan="6"><h6>Vodacom GSM data</h6></td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Network Reg Date</th>
                                                <td>{{ $contract->loan_application->affordability->credit_info->gsm_data->NETWORK_REGISTRATION_DATE}}</td>
                                                <th>Mpesa Reg Date</th>
                                                <td>{{ $contract->loan_application->affordability->credit_info->gsm_data->MPESA_REGISTRATION_DATE}}</td>
                                                <th>Network Airtime Utilization</th>
                                                <td>{{ number_format($contract->loan_application->affordability->credit_info->gsm_data->NETWORK_AIRTIME_UTILIZATION)}}</td>
                                            </tr>
                                            <tr>
                                                <th>Network TopUp Total Amount</th>
                                                <td>{{ number_format($contract->loan_application->affordability->credit_info->gsm_data->NETWORK_TOPUP_TOTAL_AMOUNT)}}</td>
                                                <th>Airtime Credit No Of Loans</th>
                                                <td>{{ $contract->loan_application->affordability->credit_info->gsm_data->AIRTIME_CREDIT_NUM_OF_LOANS}}</td>
                                                <th>Airtime Credit No Of Overdue</th>
                                                <td>{{ $contract->loan_application->affordability->credit_info->gsm_data->AIRTIME_CREDIT_NUM_OF_OVERDUE}}</td>
                                            </tr>
                                            <tr>
                                                <th>No of Mpesa Deposit </th>
                                                <td>{{ $contract->loan_application->affordability->credit_info->gsm_data->MPESA_DEPOSIT_NUMBER}}</td>
                                                <th>Mpesa Deposit Amount</th>
                                                <td>{{ number_format($contract->loan_application->affordability->credit_info->gsm_data->MPESA_DEPOSIT_AMOUNT)}}</td>
                                                <th>No Of Bank Transfer</th>
                                                <td>{{ $contract->loan_application->affordability->credit_info->gsm_data->TRANSFER_FROM_BANK_NUMBER}}</td>
                                            </tr>
                                            <tr>
                                                <th>Bank Transfer Amount</th>
                                                <td>{{ number_format($contract->loan_application->affordability->credit_info->gsm_data->TRANSFER_FROM_BANK_AMOUNT)	}}</td>
                                                <th>No Of MPESA Received</th>
                                                <td>{{ $contract->loan_application->affordability->credit_info->gsm_data->MPESA_RECEIVED_NUMBER	}}</td>
                                                <th>Mpesa Received Amount</th>
                                                <td>{{ number_format($contract->loan_application->affordability->credit_info->gsm_data->MPESA_RECEIVED_AMOUNT)	}}</td>
                                            </tr>
                                        </tbody>
                                    </table>  
                                    @endif
                                    @endif
                                    @else
                                    <p>No Vodacom GSM Data</p>
                                    @endif

                                </div>
                            </div> --}}
                            {{-- <div class="tab-pane fade" id="salary-tab-pane" role="tabpanel" aria-labelledby="salary-tab" tabindex="0">
                                <div class="col-md-12" style="padding: 10px 2px 10px 2px">
                                    @if ($contract->customer->gvt_employee)
                                    <table class="table table-bordered dt-responsive  nowrap w-100">
                                        <thead>
                                        <tr class="text-center">
                                            <td colspan="6"><h6>Government Data</h6></td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Check Number</th>
                                                <td>{{ $contract->loan_application->customer->gvt_employee->check_number }}</td>
                                                <th>Vote Code</th>
                                                <td>{{ $contract->loan_application->customer->gvt_employee->vote_code }}</td>
                                                <th>Vote Name</th>
                                                <td>{{ $contract->loan_application->customer->gvt_employee->vote_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Date Hired</th>
                                                <td>{{ $contract->loan_application->customer->gvt_employee->date_hired }}</td>
                                                <th>Department Code</th>
                                                <td>{{ $contract->loan_application->customer->gvt_employee->department_code }}</td>
                                                <th>Department Name</th>
                                                <td>{{ $contract->loan_application->customer->gvt_employee->department_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Salary Scale</th>
                                                <td>{{ $contract->loan_application->customer->gvt_employee->salary_scale }}</td>
                                                <th>Basic Salary</th>
                                                <td>{{ $contract->loan_application->customer->gvt_employee->basic_salary }}</td>
                                                <th>Net Amount</th>
                                                <td>{{ number_format($contract->loan_application->customer->gvt_employee->salary_slip->netSalary)}}</td>
                                            </tr>
                                            <tr>
                                                <th>Pay Grade</th>
                                                <td>{{ $contract->loan_application->customer->gvt_employee->pay_grade }}</td>
                                                <th>Total Deduction</th>
                                                <td>{{ number_format($contract->loan_application->customer->gvt_employee->salary_slip->totalDeduction) }}</td>
                                                <th>Total Earnings</th>
                                                <td>{{ number_format($contract->loan_application->customer->gvt_employee->salary_slip->totalEarning ) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    @else
                                      <p>No Employee Details</p>  
                                    @endif 
                                </div>
                            </div> --}}
                          </div>

                    </div>
                   
                </div>
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>

@endsection
@push('scripts')
<script>
    $(document).ready( function () {
    $('#datatable1').DataTable();
    $('#datatable2').DataTable();
} );
</script>
    
@endpush
