@extends('layout.master')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> أرشيف الفواتير</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
				<!-- row -->
				<div class="row">
                    {{-- datatables --}}
                    <div class="col-xl-12">
						<div class="card">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									{{-- <a class="modal-effect btn btn-primary py-1 px-2 add-section" href="{{ url('admin/invoices/create') }}"><i class="fa fa-plus-circle"></i> اضافة فاتورة</a> --}}
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table text-md-nowrap" id="example1">
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
												<th class="wd-20p border-bottom-0">العمليات</th>
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
                                                    <td>
                                                        <div class="dropdown">
                                                            <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary"
                                                            data-toggle="dropdown" id="dropdownMenuButton" type="button">العمليات <i class="fas fa-caret-down ml-1"></i></button>
                                                            <div  class="dropdown-menu">

                                                                <a class="dropdown-item bg-warning text-white mb-1 modalDelete" href="#"
                                                                    data-url="{{ adminUrl('invoice/restore/'.$invoice->id)}}"
                                                                    data-header-msg="استعادة الفاتورة ."
                                                                    data-body-msg="هل ترغب بالفعل باستعادة الفاتورة من الأرشيف ؟"
                                                                    data-method="Get"
                                                                >
                                                                    <i class="fa fa-archive"></i> استعادة من الأرشيف
                                                                </a>

                                                                @can('حذف فاتورة')
                                                                    <a class="dropdown-item bg-danger text-white modalDelete" href="#"
                                                                        data-url='{{adminUrl('invoices/'.$invoice->id)}}'
                                                                        data-header-msg="حذف الفاتورة ."
                                                                        data-body-msg="هل ترغب بالفعل بحذف الفاتورة ؟"
                                                                        data-method="Delete"
                                                                    >
                                                                        <i class="fa fa-trash"></i> حذف
                                                                    </a>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                        
                                                    </td>
                                                </tr>
                                            
                                                @php $i++; @endphp
                                            @endforeach
                                           
                                         
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

					{{-- modal delete section--}}
                    <div class="modal effect-scale" id="modalDelete" style="padding-right: 17px; display: none;" aria-modal="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header bg-danger">
                                    <h6 class="modal-title text-white">حذف الفاتورة</h6><button aria-label="Close" class="close text-white" data-dismiss="modal" type="button"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span></button>
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
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection

@section('js')


<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>

<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
<!-- Internal Modal js-->

<script>
    $(()=>{

        // delete section button
        $('.modalDelete').click(function(e){
            e.preventDefault();
            
            let modal = $('#modalDelete'),
            form = $('form');
            
            modal.modal('show');
           
           let dataMsgHeader = $(this).data('header-msg'),
               dataMsgBody = $(this).data('body-msg');
               console.log(dataMsgBody);

            modal.find('.modal-title').text(dataMsgHeader);
            modal.find('.message p').text(dataMsgBody);
            
            modal.find('input[name="_method"]').val($(this).data('method'));

            form.attr('action', $(this).data('url'));
        })

        // select2 plugin
        $('.select2').select2();

    })
</script>
@endsection

@section('css')
    <style>
        .select2{
            width: 100% !important
        }
    </style>
@endsection
