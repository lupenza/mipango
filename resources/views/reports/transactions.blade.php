@extends('layouts.master')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Transactions</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">List</a></li>
                            <li class="breadcrumb-item active">Transactions List</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                       <div > <h4 class="card-title text-center"> <span class="bx bx-grid"></span> Transaction</h4> </div>
                       <form action="" method="GET" id="search-form" onsubmit="submitEvent()" style="margin: 5px 0px 10px 0px; border: 1px solid #F6F6F6; padding: 10px; border-radius: 10px;">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="Start Date">Start Date</label>
                                <input type="date" class="form-control"  value="{{ $requests['start_date'] ?? null}}" name="start_date" required>
                            </div>
                            <div class="col-md-4">
                                <label for="Start Date">End Date</label>
                                <input type="date" class="form-control" value="{{ $requests['end_date'] ?? null}}" name="end_date" required>
                            </div>
                            <div class="col-md-4">
                                <label for="Start Date">Category Type</label>
                                <select name="category" class="form-control">
                                    <option value="" selected> Choose Category Type </option>
                                    @foreach ($categories as $item)

                                    @if ($requests['category'] ?? null)
                                       @if ($requests['category'] == $item->id)
                                            <option value="{{ $item->id}}" selected>{{$item->name_en }}</option> 
                                       @else
                                       <option value="{{ $item->id }}">{{ $item->name_en }}</option>  
                                       @endif
                                    @else
                                    <option value="{{ $item->id }}">{{ $item->name_en }}</option>  
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="Start Date">Category Group</label>
                                <select name="category_group"  class="form-control" id="">
                                    <option value="{{ $requests['category_group'] ?? ''}}" selected>{{ $requests['category_group'] ?? "Choose Category Group"}} </option>
                                    <option value="expenses">expenses</option>
                                    <option value="goals">goals</option>
                                    <option value="budget">budget</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="Start Date">Account Type</label>
                                <select name="account" class="form-control">
                                    <option value="" selected> Choose Account Type </option>
                                    @foreach ($accounts as $item)

                                    @if ($requests['account'] ?? null)
                                       @if ($requests['account'] == $item->id)
                                            <option value="{{ $item->id}}" selected>{{$item->name }}</option> 
                                       @else
                                       <option value="{{ $item->id }}">{{ $item->name }}</option>  
                                       @endif
                                    @else
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>  
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="Start Date">Transaction Type</label>
                                <select name="transaction_type"  class="form-control" id="">
                                    <option value="{{ $requests['transaction_type'] ?? ''}}" selected>{{ $requests['transaction_type'] ?? "Choose Transactional Type"}} </option>
                                    <option value="Dr">Dr</option>
                                    <option value="Cr">Cr</option>
                                </select>
                            </div>
                           
                        </div>
                        <div class="form-group row" style="margin-top: 10px" >
                            <div class="col-md-12 text-center" >
                                <button class="btn btn-primary view-button" name="view_button" value="view_button" formaction="{{ route('transactions')}}"  type="submit"><span class="fa fa-search"></span> View Report</button>
                                <button style="margin-left: 10px" name="generate_button" value="generate_button" formaction="{{ route('transaction.reports')}}"  type="submit" class="btn btn-info"><span class="fa fa-file-excel"></span> Generate Report</button>
                            </div>
                        </div>
                    </form>
                       <div class="table-responsive">
                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Reg Date</th>
                                <th>User</th>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Category Group</th>
                                <th>Account</th>
                                <th>Account Type</th>
                                <th>Txn Type</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($ledgers as $ledger)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ date('d ,M-Y H:i:s',strtotime($ledger->created_at))}}</td>
                                    <td>{{ $ledger->user->name ?? null.' '.$ledger->user->last_name ?? null  }}</td>
                                    <td>{{ number_format($ledger->amount) }}</td>
                                    <td>{{ $ledger->description}}</td>
                                    <td>{{ $ledger->category->name_en ?? null}}</td>
                                    <td>{{ $ledger->category->category_group ?? null}}</td>
                                    <td>{{ $ledger->account->name ?? null}}</td>
                                    <td>{{ $ledger->account?->account_type?->name}}</td>
                                    <td>{{ $ledger->txn_type }}</td>
                                </tr>
                                    
                                @endforeach
                                
                            </tbody>
                        </table>
                       </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>
@endsection
@push('scripts')
<script src="{{ asset('assets/js/pages/form-advanced.init.js')}}"></script>
    
@endpush

