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
                   
                </ul>
            </div>
        </div>
    </div>
<br>
    <div class="portlet light bordered no-print">
        <div class="portlet-body">
            <div class="table-toolbar">
                <form method="post" action="{{ url('admin/employeeReport') }}">
                    @csrf
                    <div class="row ">
                        <div class="col-md-4 col-md-offset-3">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control  select2me" required>
                                    <option value="all">All Status</option>
                                    <option value="active">active</option>
                                    <option value="inactive">Terminated</option>
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
    @if(isset($employees))
    <div class="portlet light">
        <div class="portlet-body">
            @include('admin.reports.employee-view')
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
