@extends('admin.adminlayouts.adminlayout')

@section('head')

    <style>

        @media print {
            .no-print, .no-print * {
                display: none !important;
            }
        }
    </style>
@stop

@section('mainarea')


    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title no-print"><h1>Invoice</h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{ route('admin.dashboard.index') }}')">{{ trans('core.home') }}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ url('super-admin/invoices') }}"> {{$pageTitle}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>Invoice</li>

        </ul>

    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title no-print">
                    <div class="caption font-dark">
                        <i class="fa fa-file-image-o font-dark"></i> Invoice
                    </div>
                    <div class="page-toolbar no-print">
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-fit-height red-sunglo dropdown-toggle"
                                    data-toggle="dropdown" data-hover="dropdown" data-delay="1000"
                                    data-close-others="true">
                                @lang("core.actions") <i class="fa fa-angle-down"></i>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li>
                                    <a href="javascript:;" onclick="window.print()"><i
                                            class="fa fa-print"></i> @lang("core.print")</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="portlet-body">
                    <head>
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
                                margin-bottom: 5px;
                                padding: 5px;
                                border-bottom: 2px solid #25221F;

                            }

                            table.emp {
                                width: 100%;
                                margin-bottom: 10px;
                                padding: 20px;
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
                                width: 100%;
                                padding: 3px
                            }

                            table.payment_details > tbody > tr > td {
                                border: 1px solid #000000;
                                padding: 5px;
                                width: 50%;
                            }

                            table.payment_total > tbody > tr > td {
                                padding: 5px;
                                width: 60%
                            }

                            table.logo > tbody > tr > td {
                                border: 1px solid transparent;
                            }
                        </style>
                    </head>
                    <body>
                    <table class="logo" style="width: 100%">
                        <tr>
                            <td>
                                <p style="text-align: left;">
                                    {!!  HTML::image($setting->logo_image_url,'Logo',['class'=>'logo-default','height'=>'40px']) !!}
                                </p>

                                <p style="text-align: left;">

                                    <b>{{$setting->main_name}}</b><br/>
                                    {{$setting->address}}<br/>
                                    <b>Contact</b>: {{$setting->contact}}<br/>
                                    <b>Email</b>: {{$setting->email}}
                                </p>
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>
                                <p style="text-align: right;">
                                    {!!  HTML::image($invoice->company->logo_image_url,'Logo',['class'=>'logo-default','height'=>'40px']) !!}
                                </p>

                                <p style="text-align: right;">

                                    <b>{{$invoice->company->company_name}}</b><br/>
                                    {{$invoice->company->address}}<br/>
                                    <b>Contact</b>: {{$invoice->company->contact}}<br/>
                                    <b>Email</b>: {{$invoice->company->email}}
                                </p>
                            </td>
                        </tr>
                    </table>
                    <table class="emp" style="width: 100%">
                        <tbody>
                        <tr>
                            <td colspan="3" style="text-align: center; font-size: 18px;"><strong>Invoice <br>
                                    Due Date: {{ \Carbon\Carbon::parse($invoice->pay_date)->toFormattedDateString() }}
                                </strong></td>
                        </tr>

                        </tbody>
                    </table>


                    <table class="payment_details" style="border: none">
                        <tr>
                            <th colspan="2">Plan</th>
                        </tr>

                        <tr>
                            <td>{{ $invoice->plan->plan_name }}</td>
                            <td class="text-right"> {{ number_format($invoice->amount) }}</td>
                        </tr>
                        <tr>
                            <td class="text-right"><h3>Total</h3></td>
                            <td class="text-right">{{ number_format($invoice->amount) }}</td>
                        </tr>
                    </table>
                    <br>
                    <p>
                        <strong>
                            Note:
                        </strong>
                        Account Name: AMG Capital Limited
                        Bank:Sidian
                        Branch: Sameer
                        Account number: 01051020000511

                        You can also pay via M-PESA Paybill 111999
                        Account no. 01051020000511

                    </p>
                    <hr>
                    </body>


                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->

        </div>
    </div>
    <!-- END PAGE CONTENT-->
@stop



@section('footerjs')


    <!-- BEGIN PAGE LEVEL PLUGINS -->

@stop
