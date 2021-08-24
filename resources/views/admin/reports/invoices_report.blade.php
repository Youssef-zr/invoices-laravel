@extends('layout.master')

@section('css')
<style>
    
    .text-radio{
        font-size:15px;
        font-weight:normal !important;
        margin-right:6px
    }
</style>
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">فواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اخر الاحصائيات</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
            <!-- row -->
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <div class="invoices-checkbox">
                                <div class="chcekbox mb-1">
                                    <input type="radio" name="status" class="stat_invoice" checked data-form="#form_status_invoice">
                                    <span class="text-radio">
                                        بحث بنوع الفاتورة
                                    </span>
                                </div>
                                
                                <div class="chcekbox">
                                    <input type="radio" name="status" class="inv_nb" data-form="#form_invoice_number">
                                    <span class="text-radio">
                                        بحث برقم الفاتورة
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- start form search by status --}}
                            <div id="form_status_invoice">
                                {!! Form::open(["route"=>'invoices_report'],['method'=>'Post',"class"=>"form-horizontal"]) !!}
                                    @csrf
                                    @method("Post")
    
                                    <div class="row">
                                        <div class="col-md-4 col-lg-3">
                                            <div class="form-group">
                                                {!! Form::label("invoice_type", "تحديد نوع الفاتورة", ["class"=>"form-label"]) !!}
                                                {!! Form::select("invoice_type", invoice_type(), $invoice_type ?? "حدد نوع الفاتورة" , ["class"=>"form-control","placeholder"=>"حدد نوع الفاتورة"]) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-3">
                                            <div class="form-group">
                                                {!! Form::label("start_at", "من تاريخ", ["class"=>"form-label"]) !!}
                                                {!! Form::date('start_at', $start_at ?? '' , ['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-3">
                                            <div class="form-group">
                                                {!! Form::label("end_at", "الى تاريخ", ["class"=>"form-label"]) !!}
                                                {!! Form::date('end_at', $end_at ?? '' , ['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        
                                    </div>
    
                                    <div class="form-group">
                                        <button class="btn btn-info"><i class="fa fa-search float"></i> بحث</button>
                                    </div>
    
                                {!! Form::close() !!}
                            </div>

                            {{-- start form search by status --}}
                            <div id="form_invoice_number" style="display: none">
                                {!! Form::open(["route"=>'invoices_report'],['method'=>'Post',"class"=>"form-horizontal"]) !!}
                                    @csrf
                                    @method("Post")
                                    {!! Form::hidden('form_invoice_number') !!}
                                    <div class="row">
                                        <div class="col-md-4 col-lg-3">
                                            <div class="form-group">
                                                {!! Form::label("invoice_number", "رقم الفاتورة", ["class"=>"form-label"]) !!}
                                                {!! Form::text("invoice_number", $invoice_number ?? "", ["class"=>"form-control","placeholder"=>'رقم الفاتورة']) !!}
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="form-group">
                                        <button class="btn btn-info"><i class="fa fa-search float"></i> بحث</button>
                                    </div>
                                {!! Form::close() !!}
                            </div>

                            {{-- Invoices List --}}
                            @if (isset($invoices))
                            <div class="table-responsive">
                                <table class="table text-center text-md-nowrap" id="example1">
                                    <thead>
                                        <tr>
                                            <th class="wd-15p border-bottom-0">#</th>
                                            <th class="wd-15p border-bottom-0">رقم الفاتورة</th>
                                            <th class="wd-15p border-bottom-0">تاريخ الفاتورة</th>
                                            <th class="wd-15p border-bottom-0">تاريخ الاستحقاق</th>
                                            <th class="wd-20p border-bottom-0">المنتج</th>
                                            <th class="wd-20p border-bottom-0">القسم</th>
                                            <th class="wd-20p border-bottom-0">الخصم</th>
                                            <th class="wd-20p border-bottom-0">نسبة الضريبة</th>
                                            <th class="wd-20p border-bottom-0">قيمة الضريبة</th>
                                            <th class="wd-20p border-bottom-0">الاجمالي</th>
                                            <th class="wd-20p border-bottom-0">الحالة</th>
                                            <th class="wd-20p border-bottom-0">ملاحظات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i=1; @endphp
                                        
                                        @foreach ($invoices as $invoice)
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td>{{$invoice->invoice_number}}</td>
                                                <td>{{$invoice->invoice_date}}</td>
                                                <td>{{$invoice->due_date}}</td>
                                                <td>{{$invoice->product}}</td>
                                                <td>
                                                    <a href="{{ adminUrl('invoices/'.$invoice->id)}}">
                                                        {{$invoice->section->section_name}}
                                                    </a>
                                                </td>
                                                <td>{{$invoice->discount}}</td>
                                                <td>{{$invoice->rat_vat}}%</td>
                                                <td>{{$invoice->value_vat}}</td>
                                                <td>{{$invoice->total}}</td>
                                                <td>
                                                    @if ($invoice->value_status==1)
                                                        <span class="text-success">{{$invoice->status}}</span>
                                                    @elseif($invoice->value_status==2)
                                                        <span class="text-danger">{{$invoice->status}}</span>
                                                    @else
                                                        <span class="text-warning">{{$invoice->status}}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($invoice->note!="")
                                                        {{$invoice->note}}
                                                    @else
                                                        <small class="text-info">-</small>
                                                    @endif
                                                </td>
                                            </tr>
                                        
                                            @php $i++; @endphp
                                        @endforeach
                                       
                                     
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- row closed -->
        </div>
        <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection

@section('js')

<script>
    $(()=>{
        $('input[name="status"]').change(function(){
            $('#form_status_invoice,#form_invoice_number').hide();
           $($(this).data('form')).show();
        })
    })
</script>

@if (isset($form_invoice_number) and $form_invoice_number==1){
    <script>
        $(()=>{
            $('#form_status_invoice').hide();

            $("#form_invoice_number").show();
            $(".stat_invoice").removeAttr('checked')
            $(".inv_nb").attr('checked',"checked")
        })
    </script>
}
    
@endif
@endsection