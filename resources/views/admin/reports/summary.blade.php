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
        <div class="page-title no-print">
            <h1>
                Show Payroll Summary
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
                    @if(isset($reports))
                    <li>
                        <a href="{{ url('admin/downloadSummary').'/'.$m.'/'.$y }}"><i class="fa fa-print"></i> Download To Excel
                        </a>
                    </li>
                    @endif
                    {{--				<li>--}}
                    {{--					<a   href="{{ route('admin.payrolls.edit',$payroll->id)}}" ><i class="fa fa-edit"></i> @lang('core.edit')</a>--}}
                    {{--				</li>--}}

                    {{--				<li class="divider">--}}
                    {{--				</li>--}}
                    {{--				<li>--}}
                    {{--					<a   href="{{ route('admin.payrolls.downloadpdf',$payroll->id)}}" ><i class="fa fa-download"></i> @lang('core.btnDownload') PDF</a>--}}
                    {{--				</li>--}}
                </ul>
            </div>
        </div>
    </div>
<br>
    <div class="portlet light bordered no-print">
        <div class="portlet-body">
            <div class="table-toolbar">
                <form method="post" action="{{ url('admin/payrollSummary') }}">
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
                            <div class="form-group">
                                <label>Department</label>
                                <select name="department_id" class="form-control select2" required>
                                    <option value="all">All Departments</option>
                                    @if($departments)
                                        @foreach($departments as $dep)
                                            <option value="{{ $dep->id }}">{{ $dep->name }}</option>
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
    @if(isset($reports))
    <div class="portlet light">
        <div class="portlet-body">
            @include('admin.reports.summary-view')
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
