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
        table.payment_details > thead > tr > td {
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
</head>
<body>
<table class="logo">
    <tr>
        <td>

        </td>
        <td><p style="text-align: center;">
                {!!  HTML::image($company->logo_image_url,'Logo',['class'=>'logo-default','height'=>'40px']) !!}
            </p>

            <p style="text-align: center;">
                {{-- {{$company}} --}}
                <b>{{$company->company_name}}</b><br/>
                {{$company->address}}<br/>
                {{$company->billing_address}}<br/>
                <b>Contact</b>: {{$company->contact}}<br/>
                {{$company->email}}

            </p>
        </td>
    </tr>
</table>
<table class="payment_details">
    <thead>
    <tr style="border: 1px">
        <th>#</th>
        <th>Customer Ref</th>
        <th>Beneficiary Name</th>
        <th>Beneficiary Bank Code</th>
        <th class="text-right">Branch Code</th>
        <th class="text-right">Beneficiary Account No.</th>
        <th class="text-right">Payment Amount</th>
        <th class="text-right">Transaction Type Code</th>
        <th>Purpose Of Payment</th>
        <th class="text-right">Beneficiary address</th>
        <th class="text-right">Charge Type</th>
        <th class="text-right">Currency</th>
        <th>Bank Details</th>
        <th>Payment Type</th>

{{--        <th class="text-right">KRA PIN</th>--}}

    </tr >
    </thead>
    @if(count($reports))
 
        @php
            $totalAdditions = [];
            $totalDeductions = [];
            $count=1;
        @endphp
        @foreach($reports as $report)
            {{-- @unless (empty($report->employee->bank_details)) --}}
                <tr>
                    <td>{{$count++}}</td>
                    <td>{{ $report->employee->employeeID }}</td>
                    <td>{{ $report->employee->full_name }}</td>
                    <td>{{ $report->employee->bank_details->bin ?? ''}}</td>
                    {{-- $user->role->name ?? 'No Role' --}}
                    <td>{{$report->employee->bank_details->branch ?? ''}}</td>
                    <td>{{$report->employee->bank_details->account_number ?? ''}}</td>
                    <td class="text-right">{{ number_format($report->net_salary,2) }}</td>
                    <td>{{$report->employee->bank_details->transaction_type_code ?? ''}}</td>
                    <td>{{\Carbon\Carbon::parse($report->year."-".$report->month."-".'01')->format('M')}} {{"Salaries"}}</td>
                    <td>{{$report->employee->permanent_address}}</td>
                    <td>OUR</td>
                    <td> KES</td>
                    <td>{{$report->employee->bank_details->bank ?? ''}}</td>
                    <td>{{$report->employee->bank_details->payment_type ?? ''}}</td>
                    {{-- {{$t=$count}} --}}
                </tr>
            {{-- @endunless --}}
        @endforeach
        <tr>
            {{-- <th>{{number_format($t,2)}}</th> --}}
            <th></th>
            <td>Totals</td>
            <td></td>
            <td></td>

            <td class="text-right bold">{{ number_format($reports->sum('net_salary'),2) }}</td>
        </tr>
    @endif

</table>

</body>
