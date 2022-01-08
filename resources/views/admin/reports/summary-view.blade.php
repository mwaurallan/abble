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
    <tr>
        <th>#</th>
        <th>Employee ID</th>
        <th>Employee Name</th>
{{--        <th>Department</th>--}}
{{--        <th>Designation</th>--}}
        <th>Month/Year</th>
        <th class="text-right">Basic Pay</th>
        <th class="text-right">Expense Claim</th>
        @if(count($additions))
            @foreach($additions as $addition)
                <th class="text-right">{{ $addition }}</th>
            @endforeach
            @endif
        @if(count($deductions))
            @foreach($deductions as $deduction)
                <th class="text-right"> {{ $deduction }}</th>
            @endforeach
            @endif
        <th class="text-right">Total Additions</th>
        <th class="text-right">Total Deductions</th>
        <th class="text-right">Net Pay</th>
    </tr>
    </thead>
    @if(count($reports))
        @php
            $totalAdditions = [];
            $totalDeductions = [];
            $count= 1;
        @endphp
        @foreach($reports as $report)

            @php
                $totalAdditions[] = json_decode($report->allowances);
                $totalDeductions[] = json_decode($report->deductions);
            @endphp
            <tr>
                <td>{{ $count }}</td>
                <td>{{ $report->employee->employeeID }}</td>
                <td>{{ $report->employee->full_name }}</td>
                <td>{{ $report->month }}/{{ $report->year }}</td>
                <td class="text-right">{{ number_format($report->basic,2) }}</td>
                <td class="text-right">{{number_format($report->expense)}}</td>
                @if(count($additions))
                    @foreach($additions as $addition)
                        @php $add = collect(json_decode($report->allowances))->get($addition) @endphp
                        <td class="text-right">{{ number_format($add,2) ?? '-' }}</td>
                    @endforeach
                @endif
                @if(count($deductions))
                    @foreach($deductions as $deduction)
                        @php $dd = collect(json_decode($report->deductions))->get($deduction) @endphp
                        <td class="text-right">{{ number_format($dd,2) }}</td>
                    @endforeach
                @endif
                <td class="text-right">{{ number_format($report->total_allowance,2) }}</td>
                <td class="text-right">{{ number_format($report->total_deduction,2) }}</td>
                <td class="text-right">{{ number_format($report->net_salary,2) }}</td>

            </tr>
            @php $count++ @endphp
        @endforeach
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <td>Totals</td>
                <td class="text-right bold">{{ number_format($reports->sum('basic'),2) }}</td>
                <td class="text-right bold">{{number_format($reports->sum('expense'),2)}}</td>
                @if(count($additions))
                    @foreach($additions as $addition)
                        @php
                            $total = collect($totalAdditions)->sum($addition);
                        @endphp
                        <td class="text-right bold">{{ number_format($total,2) }}</td>
                    @endforeach
                @endif
                @if(count($deductions))
                    @foreach($deductions as $deduction)
                        @php
                            $total = collect($totalDeductions)->sum($deduction);
                        @endphp
                        <td class="text-right bold">{{ number_format($total,2) }}</td>
                    @endforeach
                @endif
                <td class="text-right bold">{{ number_format($reports->sum('total_allowance'),2) }}</td>
                <td class="text-right bold">{{ number_format($reports->sum('total_deduction'),2) }}</td>
                <td class="text-right bold">{{ number_format($reports->sum('net_salary'),2) }}</td>
            </tr>
    @endif

</table>

</body>




