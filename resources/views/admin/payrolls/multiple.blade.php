@extends('admin.adminlayouts.adminlayout')

@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style("assets/global/plugins/select2/css/select2.css")!!}
    {!! HTML::style("assets/global/plugins/select2/css/select2-bootstrap.min.css")!!}
    {!! HTML::style("assets/global/plugins/jquery-multi-select/css/multi-select.css")!!}
    <!-- BEGIN THEME STYLES -->
@stop


@section('mainarea')


    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                @lang("pages.payroll.createTitle")
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{route('admin.dashboard.index')}}')">{{trans('core.dashboard')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a onclick="loadView('{{ route('admin.payrolls.index') }}')">@lang("pages.payroll.indexTitle")</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span class="active">@lang("pages.payroll.createTitle")</span>
            </li>
        </ul>

    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    {!! Form::open(array('class'=>'form-horizontal','method'=>'POST','id'=>'salary-form'))!!}
    <div class="row">
        {{--Employee info--}}
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->

            {{--INLCUDE ERROR MESSAGE BOX--}}
            <div id="error"></div>
            {{--END ERROR MESSAGE BOX--}}

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        {{ trans("core.employeeInfo") }}
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-md-9">
                                    <select class="form-control select2me" name="employee_id" id="employeeID">
                                        @foreach($employees as $employee)
                                            <option value="{{$employee->id}}">{{$employee->full_name}} (@lang('core.empId'): {{ $employee->employeeID }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-md-9">
                                    <select class="form-control  select2me" name="month" id="month">

                                        <option value="1"
                                                @if (1 == date("n")) selected="selected"@endif>{{trans('core.January')}}</option>
                                        <option value="2"
                                                @if (2 == date("n")) selected="selected"@endif>{{trans('core.February')}}</option>
                                        <option value="3"
                                                @if (3 == date("n")) selected="selected"@endif>{{trans('core.March')}}</option>
                                        <option value="4"
                                                @if (4 == date("n")) selected="selected"@endif>{{trans('core.April')}}</option>
                                        <option value="5"
                                                @if (5 == date("n")) selected="selected"@endif>{{trans('core.May')}}</option>
                                        <option value="6"
                                                @if (6== date("n")) selected="selected"@endif >{{trans('core.june')}}</option>
                                        <option value="7"
                                                @if (7 == date("n")) selected="selected"@endif>{{trans('core.July')}}</option>
                                        <option value="8"
                                                @if (8 == date("n")) selected="selected"@endif>{{trans('core.August')}}</option>
                                        <option value="9"
                                                @if (9 == date("n")) selected="selected"@endif>{{trans('core.September')}}</option>
                                        <option value="10"
                                                @if (10 == date("n")) selected="selected"@endif>{{trans('core.October')}}</option>
                                        <option value="11"
                                                @if (11 == date("n")) selected="selected"@endif>{{trans('core.November')}}</option>
                                        <option value="12"
                                                @if (12 == date("n")) selected="selected"@endif>{{trans('core.December')}}</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-md-9">
                                    {!!  Form::selectYear('year', 2017, date('Y')+1,date('Y'),['class' => 'form-control select2me','id'=>'year'])  !!}
                                </div>

                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn green"
                                    onclick="check(); return false;">{{ trans("core.btnGo") }}</button>
                        </div>
                        <!--/span-->
                    </div>
                </div>
            </div>
        </div>

        <div id="load"></div>

    </div>

    {!!  Form::close()  !!}
    <!-- END FORM-->




    {{--Confirm Box Model--}}
    <div id="confirmBox" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">@lang("core.confirmation")</h4>
                </div>
                <div class="modal-body" id="info">
                    <p>
                        {{--Confirm Message Here from Javascript--}}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal"
                            class="btn dark btn-outline">@lang("core.btnCancel")</button>
                    <button type="button" data-dismiss="modal" class="btn green" id="show"><i
                                class="fa fa-edit"></i> @lang("core.btnModify")</button>
                </div>
            </div>
        </div>
    </div>

    {{--Confirm Box MODAL--}}
    <!-- END PAGE CONTENT-->

@stop

@section('footerjs')

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! HTML::script("assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js")!!}
    {!! HTML::script("assets/global/plugins/select2/js/select2.min.js")!!}
    {!! HTML::script("assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js")!!}
    <!-- END PAGE LEVEL PLUGINS -->

    <script>

        $.fn.select2.defaults.set("theme", "bootstrap");
        $('.select2me').select2({
            placeholder: "Select",
            width: '100%',
            allowClear: false
        });

        function check() {
            $('#load').html();
            var employeeID = $('#employeeID').val();
            var month = $('#month').val();
            var year = $('#year').val();
            $.ajax({
                type: 'POST',
                url: "{{route('admin.payrolls.check')}}",
                dataType: "JSON",
                data: {'employee_id': employeeID, 'month': month, 'year': year},
                success: function (response) {
                    if (response.success == 'fail') {
                            // console.log(response.content);
                        $('#load').html(response.content);
                        $("#net_salary").val($("#expense_claim").val());
                    } else {
                        $('#confirmBox').appendTo("body").modal('show');
                        $("#confirmBox").find('#info').html('@lang("messages.salarySlipExistsMessage")');
                        $("#show").click(function () {
                            $('#load').html(response.content);
                            $('#load').append('<input type="hidden" name="type" value="edit">');
                            InitializeAdd();
                            $("#basic").trigger("change");
                        })
                    }

                    InitializeAdd();

                    // calculateNhif($("#basic").val())
                    $('#nssf-value').val(300).change()
                    $("#basic").trigger("change");

                },
                error: function (xhr, textStatus, thrownError) {

                }
            });
        }


        function submitData() {
            $.easyAjax({
                url: "{{route('admin.payrolls.store')}}",
                type: "POST",
                data: $("#salary-form").serialize(),
                container: "#salary-form",
            });
        }

        $(document).on("change keydown paste input", function () {
            var allowance = 0.0;
            var hours = 0;
            var hourly_rate = 0.0;
            var deduc = 0.0;
            var basic = 0.0;
            var expense_claim = 0.0;
            var overtime = 0.0;
            basic = $("#basic").val();
            expense_claim = $("#expense_claim").val();

            hourly_rate = $("#hourly_rate").val();
            hours = $("#overtime_hours").val();

            //add nhif and other deductions
            calculateNhif(basic);
            calculatePayee(basic);
            // calculateHAllowance(basic)

            $("#overtime_pay").val(hourly_rate * hours);

            overtime = $("#overtime_pay").val();

            $(".allowance").each(function () {
                if ($(this).val() !== "") {
                    allowance += parseFloat($(this).val());
                }
            });

            $(".deduction").each(function () {
                if ($(this).val() !== "") {
                    deduc += parseFloat($(this).val());
                }

            });
            // alert(deduc)

            $("#total_allowance").val(allowance.toFixed(2));
            $("#total_deduction").val(deduc.toFixed(2));

            net_salary = (allowance - deduc) + parseFloat(basic) + parseFloat(overtime) + parseFloat(expense_claim);
            $("#net_salary").val((net_salary.toFixed(2)));


        });

        function InitializeAdd() {
            onlyNum('only-num');
            var $insertBeforeA = $('#insertBeforeA');
            var i = $(".allowance").length;
            $('#plusButtonA').click(function () {
                i = i + 1;
                $('<div class="form-group" id="allowance' + i + '">' +
                    '<div class="control-label col-md-2"></div>' +
                    '<div class="col-md-4 margin-bottom-10">' +
                    '<input type="text" class="form-control" name="allowanceTitle[]" placeholder="@lang("core.allowance") ' + i + '">' +
                    '</div>' +
                    '<div class="col-md-3  margin-bottom-10">' +
                    '<input type="text" class="allowance form-control" name="allowance[]" placeholder="@lang("core.value")">' +
                    '</div>' +
                    '<label class="control-label col-md-1">{{$loggedAdmin->company->currency}}</label> ' +
                    ' <div class="col-md-2"> <button type="button" onclick="$(\'#allowance' + i + '\').remove();$(\'#basic\')" class="btn red btn-sm delete">' +
                    '<i class="fa fa-close"></i>' +
                    '</button></div>' +
                    '</div>').insertBefore($insertBeforeA);
                onlyNum('allowance');

            });
            var $insertBeforeD = $('#insertBeforeD');
            var j = $(".deduction").length;
            $('#plusButtonD').click(function () {
                j = j + 1;
                $('<div class="form-group" id="deduction' + j + '">' +
                    '<div class="control-label col-md-2"></div>' +
                    '<div class="col-md-4 margin-bottom-10">' +
                    '<input type="text" class="form-control" name="deductionTitle[]" placeholder="@lang("core.deduction") ' + j + '">' +
                    '</div>' +
                    '<div class="col-md-3  margin-bottom-10">' +
                    '<input type="text" class="deduction form-control" name="deduction[]" placeholder="@lang("core.value")">' +
                    '</div>' +
                    '<label class="control-label col-md-1">{{$loggedAdmin->company->currency}}</label> ' +
                    '<div class="col-md-2"> <button type="button" onclick="$(\'#deduction' + j + '\').remove();" class="btn red btn-sm delete">' +
                    '<i class="fa fa-close"></i>' +
                    '</button></div>' +
                    '</div>').insertBefore($insertBeforeD);
                onlyNum('deduction');

            });
            onlyNum('allowance');
            onlyNum('deduction');
        }

        function calculateNhif(gross){
            if(parseFloat(gross) > 0){
                let amount= 0;
                switch (true){
                    case (gross < 5999):   amount = 150;break;
                    case gross >= 6000 && gross < 8000 :   amount = 300 ;break;
                    case gross >= 8000 && gross < 12000 :  amount = 400;break;
                    case gross >= 12000 && gross < 15000 :  amount = 500;break;
                    case gross >= 15000 && gross < 20000 :  amount = 600;break;
                    case gross >= 20000 && gross < 25000 :  amount = 750;break;
                    case gross >= 25000 && gross < 30000 :  amount = 850;break;
                    case gross >= 30000 && gross < 35000 :  amount = 900;break;
                    case gross >= 35000 && gross < 40000 :  amount = 950;break;
                    case gross >= 40000 && gross < 45000 :  amount = 1000;break;
                    case gross >= 45000 && gross < 50000 :  amount = 1100;break;
                    case gross >= 50000 && gross < 60000 :  amount = 1200;break;
                    case gross >= 60000 && gross < 70000 :  amount = 1300;break;
                    case gross >= 70000 && gross < 80000 :  amount = 1400;break;
                    case gross >= 80000 && gross < 90000 :  amount = 1500;break;
                    case gross >= 90000 && gross < 100000 :  amount = 1600;break;
                    default :  amount = 1700;
                }

                $('#nhif-value').val(amount);
            }else{
                $('#nhif-value').val(0)
            }
        }
        function calculatePayee(gross){
            if(gross > 0){
                let amount = 0;
                switch (true){
                    case gross <= 24000 :  amount = 0;break;
                    case gross >24000  && gross <= 40667 :  amount = gross * 0.15;break;
                    case gross >40667  && gross <= 57333 :  amount = gross * 0.2;break;
                    default:  amount = gross * 0.25;
                }
                $('#paye-value').val(amount)
            }else{
                $('#paye-value').val(0)
            }
        }
        function calculateHAllowance(gross){
            if(gross > 0){
                $('#h-allowance').val(gross * 0.15);
            }else{
                $('#h-allowance').val(0);
            }
        }
    </script>
@stop
