@extends('layouts.master')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Budgets</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">List</a></li>
                            <li class="breadcrumb-item active">Budgets List</li>
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
                       <div > <h4 class="card-title text-center"> <span class="bx bx-money"></span> Budgets</h4> </div>
                       <form action="" method="GET" id="search-form" onsubmit="submitEvent()" style="margin: 5px 0px 10px 0px; border: 1px solid #F6F6F6; padding: 10px; border-radius: 10px;">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="Start Date">Start Date</label>
                                <input type="date" class="form-control"  value="{{ $requests['start_date'] ?? null}}" name="start_date">
                            </div>
                            <div class="col-md-3">
                                <label for="Start Date">End Date</label>
                                <input type="date" class="form-control" value="{{ $requests['end_date'] ?? null}}" name="end_date">
                            </div>
                            <div class="col-md-3">
                                <label for="Start Date">Category Type</label>
                                <select name="category" class="form-control">
                                    <option value="" selected> Choose Type </option>
                                    @foreach ($categories as $item)

                                    @if ($requests['category'] ?? null)
                                       @if ($requests['category'] == $item->id)
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
                            <div class="col-md-3">
                                <label for="Start Date">Amount</label>
                                <select name="amount" id="" class="form-control">
                                    <option value="{{ $requests['amount'] ?? ""}}">{{ $requests['amount'] ?? "Amount Range"}}</option>
                                    <option value="0-499999">0-499999</option>
                                    <option value="500000-999999">500000-999999</option>
                                    <option value="1000000 +">1000000 +</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" style="margin-top: 10px" >
                            <div class="col-md-12 text-center" >
                                <button class="btn btn-primary view-button" name="view_button" value="view_button" formaction="{{ route('budgets')}}"  type="submit"><span class="fa fa-search"></span> View Report</button>
                                <button style="margin-left: 10px" name="generate_button" value="generate_button" formaction="{{ route('budget.reports')}}"  type="submit" class="btn btn-info"><span class="fa fa-file-excel"></span> Generate Report</button>

                            </div>

                        </div>
                    </form>
                       <div class="table-responsive">
                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Reg Date</th>
                                <th>User Details</th>
                                <th>Budget Name</th>
                                <th>Amount</th>
                                <th>Category</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($budgets as $budget)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ date('d ,M-Y H:i:s',strtotime($budget->created_at))}}</td>
                                    <td>{{ $budget->user->name .' '.$budget->user->last_name }}</td>
                                    <td>{{ $budget->name }}</td>
                                    <td>{{ number_format($budget->amount)}}</td>
                                    <td>{{ $budget->category->name_en ?? "N\A"}}</td>
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

