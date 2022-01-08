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
        <th>No</th>
        <th>Employee ID</th>
        <th>Employee Name</th>
    </tr>
    </thead>
    @if(count($employees))
        @php
            $count= 1;
        @endphp
        @foreach($employees as $employee)

          
            <tr>
                <td>{{ $count }}</td>
                <td>{{ $employee->employeeID}}</td>

                <td>{{ $employee->full_name }}</td>

            </tr>
            @php $count++ @endphp
        @endforeach
    @endif

</table>

</body>




