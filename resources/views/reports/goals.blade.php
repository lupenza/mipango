@extends('layouts.master')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Goals</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">List</a></li>
                            <li class="breadcrumb-item active">Goals List</li>
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
                       <div > <h4 class="card-title text-center"> <span class="bx bx-money"></span> Transaction</h4> </div>
                       <form action="" method="GET" onsubmit="submitEvent()" style="margin: 5px 0px 10px 0px; border: 1px solid #F6F6F6; padding: 10px; border-radius: 10px;">
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
                                <label for="Start Date">Categories Type</label>
                                <select name="" class="form-control" id="">
                                    <option value="" selected>Choose Type</option>
                                    <option value="">Motor vehicle</option>
                                    <option value="">Construction</option>
                                    <option value="">Business</option>
                                    <option value="">Othersco</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="Start Date">Phone Number</label>
                                <input type="text" class="form-control" value="{{ $requests['scoring_end_date'] ?? null}}" placeholder="Write Phone Number">
                            </div>
                        </div>
                        <div class="form-group row" style="margin-top: 10px" >
                            <div class="col-md-12 text-center" >
                                <button class="btn btn-primary view-button"  type="submit"><span class="fa fa-search"></span> View Report</button>
                                <button style="margin-left: 10px"  type="submit" class="btn btn-info"><span class="fa fa-file-excel"></span> Generate Report</button>

                            </div>

                        </div>
                    </form>
                       <div class="table-responsive">
                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Reg Date</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Amount</th>
                                <th>Category</th>
                                {{-- <th>Scoring Status</th>
                                <th>Loan Status</th> --}}
                                <th>Action</th>
                            </tr>
                            </thead>
                            {{-- <tbody>
                                @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ date('d ,M-Y H:i:s',strtotime($customer->created_at))}}</td>
                                    <td>{{ $customer->first_name .' '.$customer->last_name}} <br>{{ $customer->phone }}</td>
                                    <td>{{ $customer->id_number }}</td>
                                    <td>{{ $customer->acquisition->name}}</td>
                                    @if ($customer->channel)
                                    <td>{{ $customer->channel->name }}</td>  
                                    @else
                                        <td>Channel</td>
                                    @endif
                                   
                                   @if ($customer->affordability)
                                        <td>{{ number_format($customer->affordability->loan_amount) }}</td>
                                   @else
                                      <td>Pending</td> 
                                   @endif
                                  @if ($customer->loan_contract)
                                      <td>
                                        <button class="btn btn-primary btn-sm">Loan Profile</button>
                                      </td>
                                  @else
                                    <td>No Loan</td>  
                                  @endif
                                    <td>
                                        <button class="btn btn-success btn-sm" ><span class="fa fa-user"></span></button>
                                    </td>
                                </tr>
                                    
                                @endforeach
                                
                            </tbody> --}}
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

