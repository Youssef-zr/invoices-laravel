@extends('layout.master')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الفواتير/ تفاصيل الفاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
            <!-- row -->
            <div class="row">
                <div class="bg-white panel panel-primary tabs-style-3">
                    <div class="tab-menu-heading">
                        <div class="tabs-menu ">
                            <!-- Tabs -->
                            <ul class="nav panel-tabs">
                                <li class=""><a href="#tab11" class="active" data-toggle="tab"><i class="fa fa-list"></i> معلومات الفاتورة</a></li>
                                <li><a href="#tab12" data-toggle="tab"><i class="fa fa-dollar"></i> حالات الدفع</a></li>
                                <li><a href="#tab13" data-toggle="tab"><i class="fa fa-cogs"></i> المرفقات</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body tabs-menu-body">
                        <div class="tab-content">
                            {{-- معلومات الفاتورة --}}
                            <div class="tab-pane active" id="tab11">
                                <table class="table table-striped text-center">
                                    <tbody>
                                        
                                        <tr>
                                            <th scope="row">رقم الفاتورة</th>
                                            <td>{{$invoice->invoice_number}}</td>
    
                                            <th scope="row">تاريخ الاصدار</th>
                                            <td>{{$invoice->invoice_date}}</td>
    
                                            <th scope="row">تاريخ الاستحقاق</th>
                                            <td>{{$invoice->due_date}}</td>
    
                                            <th scope="row">القسم</th>
                                            <td>{{$invoice->section->section_name}}</td>
    
                                            <th scope="row">المنتج</th>
                                            <td>{{$invoice->product}}</td>
                                        </tr>
    
                                        <tr>
                                            <th scope="row">مبلغ التحصيل</th>
                                            <td>{{$invoice->amount_collection}}</td>
    
                                            <th scope="row">مبلغ العمولة</th>
                                            <td>{{$invoice->amount_commission}}</td>
    
                                            <th scope="row">الخصم</th>
                                            <td>{{$invoice->discount}}</td>
    
                                            <th scope="row">نسبة الضريبة</th>
                                            <td>{{$invoice->rat_vat}}%</td>
    
                                            <th scope="row">قيمة الضريبة</th>
                                            <td>{{$invoice->value_vat}}</td>
                                        </tr>
    
                                        <tr>
                                            <th scope="row">الاجمالي مع الضريبة</th>
                                            <td>{{$invoice->total}}</td>
    
                                            <th scope="row">الحالة</th>
                                            <td>
                                                @if ($invoice->value_status == 1)
                                                    <span class="badge badge-pill badge-success">{{$invoice->status}}</span>
                                                @elseif($invoice->value_status==2)
                                                    <span class="badge badge-pill badge-danger">{{$invoice->status}}</span>
                                                @else
                                                    <span class="badge badge-pill badge-warning">{{$invoice->status}}</span>
                                                @endif
                                            </td>
    
                                            <th scope="row">المستخدم</th>
                                            <td><span class="badge badge-pill badge-info">{{$invoice->user}}</span></td>
    
                                            <th scope="row">ملاحظات</th>
                                            <td>{{$invoice->note}}</td>
                                        </tr>

                                    </tbody>
                                </table>

                            </div>
                            {{-- حالات الدفع --}}
                            <div class="tab-pane" id="tab12">
                                <table class="table table-bordered table-striped table-hover text-center">
                                    @php  $i=1; @endphp

                                    <thead>
                                        <th>#</th>
                                        <th>رقم الفاتورة</th>
                                        <th>نوع المنتج</th>
                                        <th>القسم</th>
                                        <th>حالة الدفع</th>
                                        <th>تاريخ الدفع</th>
                                        <th>ملاحظات</th>
                                        <th>تاريخ الاضافة</th>
                                        <th>المستخدم</th>
                                    </thead>

                                    <tbody>
                                        @foreach ($invoice_details as $details)
                                            <tr>
                                                <td>
                                                    {{ $i }}
                                                </td>

                                                <td>
                                                    {{ $details->invoice_number }}
                                                </td>

                                                <td>
                                                    {{ $details->product }}
                                                </td>

                                                <td>
                                                    {{ $details->section->section_name }}
                                                </td>
                                                
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
                                                    @if ($invoice->status == 1)
                                                        {{ $details->updated_at }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                <td>
                                                    {{ $details->note }}
                                                </td>

                                                <td>
                                                    {{ $details->created_at }}
                                                </td>

                                                <td>
                                                    <span class="badge badge-pill badge-info">
                                                        {{ $details->user }}
                                                    </span>
                                                </td>

                                            </tr>

                                            @php  $i++; @endphp

                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            {{-- المرفقات --}}
                            <div class="tab-pane" id="tab13">
                                <table class="table table-bordered table-striped table-hover text-center">
                                    <thead>
                                        <th>#</th>
                                        <th>اسم الملف</th>
                                        <th>قام بالاضافة</th>
                                        <th>تاريخ الاضافة</th>
                                        <th>العمليات</th>
                                    </thead>
                                    <tbody>
                                        @php $index=1; @endphp

                                        @foreach ($Attachments as $Attachment)
                                            <tr>
                                                <td>{{ $index }}</td>
                                                <td>{{ $Attachment->file_name }}</td>
                                                <td><span class="badge badge-pill badge-info">{{ $Attachment->create_by }}</span></td>
                                                <td>{{ $Attachment->created_at }}</td>
                                                <td>
                                                    <a href="" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> عرض</a>
                                                    <a href="" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> تعديل</a>
                                                    <a href="" class="btn btn-danger btn-sm modalDelete"
                                                       data-url='{{adminUrl('invoiceDetails/attachments/'.$Attachment->invoice_id."/".$Attachment->id)}}'>
                                                       <i class="fa fa-trash"></i> حذف
                                                    </a>
                                                </td>
                                            </tr>

                                            @php $index=1; @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->

            {{-- modal delete section--}}
            <div class="modal effect-scale" id="modalDelete" style="padding-right: 17px; display: none;" aria-modal="true">
                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header bg-danger">
                            <h6 class="modal-title text-white">حذف المنتج</h6><button aria-label="Close" class="close text-white" data-dismiss="modal" type="button"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span></button>
                        </div>
                        {!! Form::open() !!}
                        @method('Delete')
                        <div class="modal-body">
                            <div class="message">
                                <div class="icon">
                                    <i class="fa fa-question-circle-o fa-4x"></i>
                                </div>    
                                <div class="message mt-2">
                                    <p style="font-size:20px">
                                        هل تريد الاستمرار؟
                                    </p>
                                </div>
                            </div>                                
                        </div>
                        <div class="modal-footer">
                            <div class="ml-auto">
                                <button class="btn ripple btn-danger py-1 px-2" data-dismiss="modal" type="button"><i class="fa fa-times"></i> اغلاق</button>
                                <button class="btn ripple btn-success py-1 px-2" type="submit"><i class="fa fa-check"></i> تأكيد</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
		</div>
		<!-- main-content closed -->
@endsection

@section('css')
    <style>
        #tab11 tbody tr td{
            background:white
        }

        #tab11 tbody tr th{
            background:#0b6ef0;
            color: white
        }

       .panel-tabs .active{
            background: #0b6ef0 !important;
        }
    </style>
@endsection


@section('js')
<script>

    $(()=>{
        $('.modalDelete').click(function(e){

           e.preventDefault();

           let modal = $('#modalDelete'),
               form = $('form');

            modal.modal('show');
            form.attr('action', $(this).data('url'));
        })
    })
</script>
@endsection