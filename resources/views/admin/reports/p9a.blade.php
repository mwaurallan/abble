@extends('admin.adminlayouts.adminlayout')

@section('head')

    <style>

        @media print {
            .no-print, .no-print * {
                display: none !important;
            }
        }
    </style>
    <style type="text/css">

        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }

            table.details tr th {
                background-color: #F2F2F2 !important;
            }

            .print_bg {
                background-color: #F2F2F2 !important;
            }

        }

        .print_bg {
            background-color: #F2F2F2 !important;
        }

        body {
            font-family: "Open Sans", helvetica, sans-serif;
            font-size: 13px;
            color: #000000;
        }

        table.logo {
            -webkit-print-color-adjust: exact;
            border-collapse: inherit;
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border-bottom: 2px solid #25221F;

        }

        table.emp {
            width: 100%;
            margin-bottom: 10px;
            padding: 40px;
        }

        table.details, table.payment_details {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table.payment_total {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 10px;
        }

        table.emp tr td {
            width: 30%;
            padding: 10px
        }

        table.details tr th {
            border: 1px solid #000000;
            background-color: #F2F2F2;
            font-size: 15px;
            padding: 10px
        }

        table.details tr td {
            vertical-align: top;
            width: 30%;
            padding: 3px
        }

        table.payment_details > tbody > tr > td {
            border: 1px solid #000000;
            padding: 5px;
        }

        table.payment_total > tbody > tr > td {
            padding: 5px;
            width: 60%
        }

        table.logo > tbody > tr > td {
            border: 1px solid transparent;
        }
    </style>
@stop


@section('mainarea')

    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title no-print">
            <h1>
                P9A Report
            </h1>
        </div>
        <div class="page-toolbar no-print">
            <div class="btn-group pull-right">
                <button type="button" class="btn btn-fit-height red-sunglo dropdown-toggle" data-toggle="dropdown"
                        data-hover="dropdown" data-delay="1000" data-close-others="true">
                    @lang("core.actions") <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu pull-right" role="menu">
                    <li>
                        <a href="javascript:;" onclick="window.print()"><i class="fa fa-print"></i> @lang("core.print")
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<br>
<br>
    <div class="portlet light bordered no-print">
        <div class="portlet-body">
            <div class="table-toolbar">
                <form method="post" action="{{ url('admin/p9a') }}">
                    @csrf
                <div class="row ">
                    <div class="col-md-2 col-md-offset-3">
                        <label>Employee</label>
                        <select class="form-control select2me" name="employee_id" id="employeeID" required>
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->full_name}} (@lang('core.empId'): {{ $employee->employeeID }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>From</label>
                        <input name="from" required class="form-control" type="date" value="{{ \Carbon\Carbon::today()->startOfYear()->toDateString() }}">
                    </div>
                    <div class="col-md-2">
                        <label>To</label>
                        <input name="to" required class="form-control" type="date" value="{{ \Carbon\Carbon::today()->endOfYear()->toDateString() }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-primary" style="margin-top: 27px">Search
                        <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
                </form>
            </div>

        </div>
    </div>
    @if(isset($reports))

                
    <div class="portlet light">
        <div class="portlet-body">
            <table class="logo">
                <tr>
                    <td>

                    </td>
                    <td><p style="text-align: right;">
                            {!!  HTML::image($company->logo_image_url,'Logo',['class'=>'logo-default','height'=>'40px']) !!}
                        </p>

                        <p style="text-align: right;">

                            <b>{{$company->company_name}}</b><br/>
                            {{$company->address}}<br/>
                            <b>Contact</b>: {{$company->contact}}
                            {{$company->email}}

                        </p>
                    </td>
                    
                </tr>
                <tr>
                    <td>NAME:</td>
                    <td>
                        {{ $person->full_name }}

                    </td>
                </tr>
                <tr>
                    
                    @foreach($pin2 as $pin)
                      <td>PIN</td>
                      <td>{{$pin->tax_payer_id}}</td>
                    @endforeach
                  </tr>
            </table>
            <table class="payment_details">
                <thead>
                {{-- <tr>
                    <td>Name</td>
                    <td>{{ $person->full_name }}</td>
                </tr>
                <tr>
                    
                  @foreach($pin2 as $pin)
                    <td>PIN</td>
                    <td>{{$pin->tax_payer_id}}</td>
                         @endforeach
                </tr> --}}
                <tr>
                    <th>Month/Year</th>
                    <th>Basic Pay</th>
                    <th>Benefits</th>
                    <th>GrossPay</th>
                    <th>30%</th>
                    <th>NSSF</th>
                    <th>Permissible Limit</th>
                    <th>H.O.S.P</th>
                    <th>Pension</th>
                    <th>Chargeble Pay</th>
                    <th>Tax Payable</th>
                    <th>Relief</th>
                    @if(count($deductions))
                        @foreach($deductions as $deduction)
                            <th>{{ $deduction }}</th>
                        @endforeach
                    @endif
                </tr>
                </thead>
                
                @if(count($reports))
                    @php
                        $totalAdditions = [];
                        $totalDeductions = [];
                    @endphp
                    {{-- {{$reports}} --}}
                    @foreach($reports as $report)

                        @php
                            $totalAdditions[] = json_decode($report->allowances);
                            $totalDeductions[] = json_decode($report->deductions);
                        @endphp
                        <tr>
                            <td> {{ \Carbon\Carbon::parse('2020/'.$report->month.'/01')->monthName }}</td>
                            <td>{{ number_format($report->basic,2) }}</td>
                            <td>{{ number_format($report->total_allowance,2) }}</td>
                            <td>{{ number_format($g = $report->basic +$report->total_allowance,2) }}</td>
                            <td>{{ number_format($report->basic * 0.3,2) }}</td>
                            <td>200</td>
                            <td class="text-right">20,000</td>
                            <td></td>
                            <td>200</td>
                            <td>{{ number_format($chargableP =$g - 200,2) }}</td>
                            @if(count($deductions))
                                @foreach($deductions as $deduction)
                                    @php
                                        $dd = collect($dds = json_decode($report->deductions))->get($deduction);
                                    @endphp
{{--                                    {{ ($dd != '' || $dd != 0)? number_format($dd,2) : '-' }}--}}
                                @endforeach
                            @endif
                            <td>{{ ($dd > 0)? number_format($dd + 2400,2) : 0 }}</td>
                            <td>{{ ($chargableP> 24000)? '2,400' : 0 }}</td>
                            <td>{{ number_format($dd,2) }}</td>
                        </tr>

                    @endforeach
                        <tr>
                            <td>Totals</td>
                            <td>{{ number_format($reports->sum('basic'),2) }}</td>
                            <td>{{ number_format($reports->sum('total_allowance'),2) }}</td>
                            <td>{{ number_format($reports->sum('total_allowance') + $reports->sum('basic'),2) }}</td>
                            <td></td>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            @if(count($deductions))
                                @foreach($deductions as $deduction)
                                    @php
                                        $total = collect($totalDeductions)->sum($deduction);
                                    @endphp
                                    <td>{{ number_format($total,2) }}</td>
                                @endforeach
                            @endif
                        </tr>
                @endif

            </table>
        </div>
    </div>
    @endif
@stop

@section('footerjs')
<script>
    $.fn.select2.defaults.set("theme", "bootstrap");
    $('.select2me').select2({
        placeholder: "Select",
        width: '100%',
        allowClear: false
    });
</script>
@stop
