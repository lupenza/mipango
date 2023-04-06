@extends('layouts.master')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">App Users</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">List</a></li>
                            <li class="breadcrumb-item active">App Users List</li>
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
                       <div > <h4 class="card-title text-center"> <span class="bx bx-user"></span> App Users</h4> </div>
                       <form action="" method="GET" onsubmit="submitEvent(event)" id="search-form" style="margin: 5px 0px 10px 0px; border: 1px solid #F6F6F6; padding: 10px; border-radius: 10px;">
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
                                <label for="Start Date">Device Type</label>
                                <select name="device_type" class="form-control" id="">
                                    <option value="{{ $requests['device_type'] ?? null}}" selected>{{ $requests['device_type'] ?? "Choose  Device Type"}}</option>
                                    <option value="android">android</option>
                                    <option value="ios">ios</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="Start Date">Phone Number</label>
                                <input type="text" class="form-control" value="{{ $requests['scoring_end_date'] ?? null}}" placeholder="Write Phone Number">
                            </div>
                        </div>
                        <div class="form-group row" style="margin-top: 10px" >
                            <div class="col-md-12 text-center" >
                                <button class="btn btn-primary view-button" name="view_button" value="view_button"  type="submit"><span class="fa fa-search"></span> View Report</button>
                                <button style="margin-left: 10px" name="generate_button" value="generate_button" formaction="{{ route('user.report')}}" type="submit" class="btn btn-info"><span class="fa fa-file-excel"></span> Generate Report</button>

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
                                <th>Address</th>
                                <th>Device Type</th>
                                <th>Accounts</th>
                                <th>Transactions</th>
                                <th>Budget</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ date('d ,M-Y H:i:s',strtotime($user->created_at))}}</td>
                                    <td>{{ $user->name ?? null .' '.$user->last_name ?? null}}</td>
                                    <td>{{ $user->email }} <br>{{ $user->phone }}</td>
                                    <td>{{ $user->device_type}}</td>
                                    <td>{{ $user->accounts->count()}}</td>
                                    <td>{{ $user->ledgers->count()}}</td>
                                    <td>{{ $user->budgets->count()}}</td>
                                    <td>
                                        <button class="btn btn-success btn-sm" ><span class="fa fa-user"></span></button>
                                    </td>
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

