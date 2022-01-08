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
                Statutory Deductions Report
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
                <form method="post" action="{{ url('admin/statutoryDeductions') }}">
                    @csrf
                <div class="row ">
                    <div class="col-md-2 col-md-offset-2">
                        <label>Employee</label>
                        <select class="form-control select2me" name="employee_id" id="employeeID" required>
                            <option value="all">All Employee(s)</option>
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
                    <div class="col-md-2 ">
                        <label>Employee</label>
                        <select class="form-control select2me" name="deduction"  required>
                            <option value="all">All Dedeuctions(s)</option>
                            @foreach($deductions as $deduction)
                                <option value="{{$deduction}}">{{ $deduction }}</option>
                            @endforeach
                        </select>
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
            </table>
            <table class="payment_details">
                <thead>
                <tr>
                    <th>Employee</th>
                    <th>Month/Year</th>
                    @if(count($deductions))
                            @if($deductionFilter != 'all')
                                <th class="text-right">{{ $deductionFilter }}</th>
                            @else
                            @foreach($deductions as $deduction)
                            <th class="text-right">{{ $deduction }}</th>
                            @endforeach
                        @endif
                    @endif
                </tr>
                </thead>
                @if(count($reports))
                    @php
                        $totalDeductions = [];
                    @endphp
                    @foreach($reports as $report)
                        @php
                            $totalDeductions[] = json_decode($report->deductions);
                        @endphp
                        <tr>
                            <td>{{ $report->employee->full_name }}</td>
                            <td>{{ $report->month }}/{{ $report->year }}</td>
                            @if(count($deductions))
                                @if($deductionFilter != 'all')
                                    @php $dd = collect(json_decode($report->deductions))->get($deductionFilter) ;
                                    @endphp
                                    <td class="text-right">{{ number_format($dd,2) }}</td>
                                @else
                                    @foreach($deductions as $deduction)
                                        @php $dd = collect(json_decode($report->deductions))->get($deduction) ;
                                        @endphp
                                        <td class="text-right">{{ number_format($dd,2) }}</td>
                                    @endforeach
                                    @endif
                            @endif

                        </tr>
                    @endforeach
                    <tr>
                        <th></th>
                        <td class="bold">Totals</td>
                        @if(count($deductions))
                            @if($deductionFilter != 'all')
                                @php
                                    $total = collect($totalDeductions)->sum($deductionFilter);
                                @endphp
                                <td class="bold text-right">{{ number_format($total,2) }}</td>
                            @else
                                @foreach($deductions as $deduction)
                                    @php
                                        $total = collect($totalDeductions)->sum($deduction);
                                    @endphp
                                    <td class="bold text-right">{{ number_format($total,2) }}</td>
                                @endforeach
                            @endif

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
