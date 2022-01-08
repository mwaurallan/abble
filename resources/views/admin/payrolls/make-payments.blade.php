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
                Make Payment(s)
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
                <form method="post" action="{{ url('admin/makePayments') }}">
                    @csrf
                <div class="row ">
                    <div class="col-md-2 col-md-offset-3">
                        <div class="form-group">
                            <label>Month</label>
                            <select name="month" class="form-control" required>
                                @if($months)
                                    @foreach($months as $month)
                                        <option value="{{ $month }}">{{ \Carbon\Carbon::parse('2020/'.(strlen($month == 1)? '0'.$month : $month).'/01')->format('M') }}</option>

                                    @endforeach
                                    @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Year</label>
                            <select name="year" class="form-control" required>
                                @if($years)
                                    @foreach($years as $month)
                                        <option value="{{ $month }}">{{ $month }}</option>
                                    @endforeach
                                    @endif
                            </select>
                        </div>
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
    @if(isset($status))
    <div class="portlet light">
        <div class="portlet-body">
            <div class="alert alert-success">
                <strong>Success!</strong> Payments Submitted for processing
            </div>
        </div>
    </div>
    @endif
    @if(isset($payrolls))
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
            <form method="post" id="selectedPaymentsform" action="{{ url('admin/paySelectedPayrolls') }}">
                @csrf
                <table class="payment_details">
                    <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Month/Year</th>
                        <th class="text-right">Basic Pay</th>
                        <th class="text-right">Payment Amount</th>
                        <th class="text-center">Payment Status</th>
                        <th class="text-center">Select All <input type="checkbox" id="select-all"> </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($payrolls))
                        @php
                            $totalAdditions = [];
                            $totalDeductions = [];
                        @endphp
                        @foreach($payrolls as $report)

                            @php
                                $totalAdditions[] = json_decode($report->allowances);
                                $totalDeductions[] = json_decode($report->deductions);
                            @endphp
                            <tr>
                                <td>{{ $report->employee->full_name }}</td>
                                <td>{{ $report->month }}/{{ $report->year }}</td>
                                <td class="text-right">{{ number_format($report->basic,2) }}</td>
                                <td class="text-right">{{ number_format($report->net_salary,2) }}</td>
                                <td class="text-center">
                                    @if($report->status == 'paid') <label class="label label-success">Paid</label>@else <label class="label label-danger">Un paid</label>@endif
                                </td>
                                <td class="text-center">@if($report->status != 'paid') <input type="checkbox" class="selectable" name="selected[]" value="{{$report->id}}">@else <label class="label label-success">Paid</label> @endif </td>

                            </tr>
                        @endforeach
                        <tr>
                            <th></th>
                            <td>Totals</td>
                            <td class="text-right bold">{{ number_format($payrolls->sum('basic'),2) }}</td>
                            <td class="text-right bold">{{ number_format($payrolls->sum('net_salary'),2) }}</td>
                            <th></th>
                        </tr>
                    @endif
                    </tbody>


                </table>
                <br>
                <br>
                <div class="form-group">
                    <button class="btn btn-success pull-right">Pay Selected</button>
                </div>
                <br>
                <br>
            </form>

        </div>
    </div>
    @endif

    <div id="submitModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Submit Payments</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-offset-6">
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>
                    <div class="col-md-offset-5" ><span style="margin: 17px">Processing</span></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
@stop

@section('footerjs')
<script>
    $.fn.select2.defaults.set("theme", "bootstrap");
    $('.select2me').select2({
        placeholder: "Select",
        width: '100%',
        allowClear: false
    });

    $('#select-all').on('change',function(){
        let s =$(this).parent('span').attr('class')
        if(s === 'checked'){
            $('.selectable').each(function (index,element) {
                if($(element).parent('span').attr('class') !== 'checked'){
                    $(element).trigger('click')
                }
            });
        }else{
            $('.selectable').each(function (index,element) {
                if($(element).parent('span').attr('class') === 'checked'){
                    $(element).trigger('click')
                }
            });
        }

    });

    $(document).ready(function (){
        $('#selectedPaymentsform').on('submit',function (e){
            e.preventDefault();
            $('#submitModal').modal()
            let data = $('#selectedPaymentsform').serializeArray()
            for (let i = 0; i < data.length; i++) {
                console.log(data[i].name)
                if(data[i].name !== '_token'){
                    $.ajax({
                        url: '{{ url('admin/paySelectedPayrolls') }}'+'/'+data[i].value,
                        dataType: 'json',
                        type: "GET",
                        success: function(data){

                        }
                    })
                }
            }
        })
    })

</script>
@stop
