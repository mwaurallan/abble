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
            width: 50%;
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
            width: 50%;
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
<table class="logo" style="width: 50%">
    <tr >
        <td>

        </td>
        <td><p style="text-align: right;">
                {!!  HTML::image($employee->company->logo_image_url,'Logo',['class'=>'logo-default','height'=>'40px']) !!}
            </p>

            <p style="text-align: right;">

                <b>{{$employee->company->company_name}}</b><br/>
                {{$employee->company->address}}<br/>
                <b>Contact</b>: {{$employee->company->contact}}
                {{$employee->company->email}}

            </p>
        </td>
    </tr>
</table>
<table class="emp" style="width: 50%">
    <tbody>
    <tr>
        <td colspan="3" style="text-align: center; font-size: 18px;"><strong>@lang("core.payslip") <br>
                @lang("core.salaryMonth"): {{ date('F', mktime(0, 0, 0, $payroll->month, 10))}}, {{$payroll->year}}
            </strong></td>
    </tr>
    <tr>
        <td><strong>@lang("core.employeeID"):</strong> {{ $payroll->employee->employeeID }} </td>
        <td><strong>@lang("core.name"):</strong> {{$payroll->employee->full_name}}</td>
        {{-- <td><strong>@lang("core.payslipNumber"):</strong> {{$payslip_num}}</td> --}}
    </tr>

    <tr>
        <td><strong>@lang("core.department"):</strong> {{ $payroll->employee->getDesignation->department->name}}</td>
        <td><strong>@lang("core.designation"):</strong> {{ $payroll->employee->getDesignation->designation}}</td>
        {{-- <td><strong>@lang("core.joining_date")
                :</strong> {!! date('d-M,Y',strtotime($payroll->employee->joining_date)) !!}</td> --}}
    </tr>
    </tbody>
</table>


    <table class="payment_details" style="border: none">
        <tr>
            <th colspan="2">EARNINGS</th>
        </tr>

        <tr>
            <td style="width: 50%">@lang("core.basic")</td>
            <td> {{$employee->company->currency}} {{number_format($payroll->basic, 2)}}</td>
        </tr>



        @if($payroll->overtime_pay > 0)
            <tr>
                <td style="width: 50%">@lang("core.hourlyPayment")</td>

                <td> {{$employee->company->currency}} {{number_format($payroll->overtime_pay, 2)}} </td>
            </tr>
        @endif

        @if($payroll->expense > 0)
            <tr>
                <td>@lang("core.expenseClaim")</td>
                <td> {{$employee->company->currency}} {{number_format($payroll->expense, 2)}} </td>
            </tr>
        @endif
        @foreach(json_decode($payroll->allowances) as $index=>$value)
            <tr>
                <td> {{ $index }}</td>

                <td> {{$employee->company->currency}} {{number_format($value, 2)}} </td>
            </tr>
        @endforeach
        <tr>
            <td style="width: 50%">Gross Pay</td>
            <td> {{$employee->company->currency}} {{number_format($gp = $payroll->basic + $payroll->total_allowance + $payroll->expense, 2)}}</td>
        </tr>
    </table>

    <table class="payment_details">
        <tr>
            <th colspan="2">DEDUCTIONS</th>
        </tr>
        @foreach(json_decode($payroll->deductions) as $index=>$value)
            @if($index != 'PAYE')
            <tr>
                <td> {{ $index }}</td>

                <td> {{$employee->company->currency}} {{number_format($value, 2)}} </td>
            </tr>
            @endif
        @endforeach

    </table>
    <table class="payment_details">
        <tr>
            <th colspan="2">TAX CALCULATION</th>
        </tr>
        <tr>
            <td>Defined Contribution</td>

            <td>{{$employee->company->currency}} (200) </td>
        </tr>

        <tr>
            <td>Taxable Pay</td>

            <td> {{$employee->company->currency}} {{number_format($gp - 200, 2)}}</td>
        </tr>
        @foreach(json_decode($payroll->deductions) as $index=>$value)
            @if($index == 'PAYE')
                <tr>
                    <td> Tax Charged</td>

                    <td> {{$employee->company->currency}} {{number_format($value, 2)}} </td>
                </tr>
            @endif
        @endforeach

{{--        @if($payroll->basic > 24000 )--}}
        <tr>
            <td>Tax Relief</td>

            <td> {{$employee->company->currency}} {{ ($payroll->basic > 24000)? number_format(2400, 2): number_format(0,2)}}</td>
        </tr>

        <tr>
            <td>Net Pay</td>

            <td> {{$employee->company->currency}} {{ number_format($payroll->net_salary,2)}}</td>
        </tr>
{{--        @endif--}}
    </table>

    <table class="payment_details">
        <tr>
            <th colspan="2">PERSONAL INFORMATION</th>
        </tr>
        <tr>
            <td>ID#</td> <td>{{$employee->id_number}} </td>
        </tr>
        <tr>
            <td>PIN#</td> <td>{{$employee->PIN}} </td>
        </tr>
        <tr>
            <td>NSSF#</td> <td>{{$employee->NSSF}} </td>
        </tr>
        <tr>
            <td>NHIF#</td> <td>{{$employee->NHIF}} </td>
        </tr>
    </table>
<!-- Table for Details -->
<hr>
<!-- TotalTotal -->

<!-- TotalTotal -->
</body>




