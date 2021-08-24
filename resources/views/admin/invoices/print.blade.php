@extends('layout.master')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{ adminUrl('invoices') }}">الفواتير</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">معاينة طباعة فاتورة </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
				<!-- row -->
				<div class="row">
                    <div class="col-md-12 col-xl-8 ml-xl-auto">
						<div class="main-content-body-invoice" id="printContent">
							<div class="card card-invoice">
								<div class="card-body">
									<div class="invoice-header">
										<h1 class="invoice-title">فاتورة تحصيل</h1>
										<div class="billed-from">
											<h6>شركة الوفاء</h6>
											<p>شارع الحسن الأول, طنجة<br>
											رقم الهاتف : 212762927783+<br>
											البريد الالكتروني : yn-neinaa@hotmail.com</p>
										</div><!-- billed-from -->
									</div><!-- invoice-header -->
									<div class="row mg-t-20">
										<div class="col-md">
											<label class="tx-gray-600">فاتورة إلى السيد</label>
											<div class="billed-to">
												<h6>سمير نصري</h6>
												<p>حي النهضة. عمارة الشرفاء رقم 256 الرباط<br>
												رقم الهاتف: 212668526312+<br>
												البريد الالكتروني: sm-nasri@yahoo.com</p>
											</div>
										</div>
										<div class="col-md">
											<label class="tx-gray-600">معلومات الفاتورة</label>
											<p class="invoice-info-row"><span>رقم الفاتورة</span> <span> {{ $invoice->invoice_number }} </span></p>
											<p class="invoice-info-row"><span>تاريخ الاصدار</span> <span> {{ $invoice->invoice_date }} </span></p>
											<p class="invoice-info-row"><span>تاريخ الاستحقاق</span> <span> {{ $invoice->due_date }} </span></p>
											<p class="invoice-info-row"><span>القسم</span> <span> {{ $invoice->section->section_name }} </span></p>
										</div>
									</div>
									<div class="table-responsive mg-t-40">
										<table class="table table-invoice border text-md-nowrap mb-0">
											<thead>
												<tr>
													<th class="wd-20p">#</th>
													<th class="wd-40p">المنتج</th>
													<th class="tx-center">مبلغ التحصيل</th>
													<th class="tx-right">مبلغ العمولة</th>
													<th class="tx-right">الاجمالي</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>
													<td class="tx-12">{{$invoice->product}}</td>
													<td class="tx-center">{{ number_format($invoice->amount_collection,2) }}$</td>
													<td class="tx-right">{{ number_format($invoice->amount_commission,2) }}$</td>
                                                    @php
                                                        $total = $invoice->amount_collection + $invoice->amount_commission;
                                                    @endphp
													<td class="tx-right">{{ number_format($total,2) }}$</td>
												</tr>
												<tr>
													<td class="valign-middle" colspan="2" rowspan="4">
														<div class="invoice-notes">
															<label class="main-content-label tx-13">ملاحظات :</label>
                                                            @if ($invoice->note !="" )
                                                                <p class="text-dark">
                                                                    {{ $invoice->note }}
                                                                </p>
                                                            @else    
                                                                <p class="text-dark">
                                                                   لا يوجد أي ملاحظات
                                                                </p>
                                                            @endif
														</div><!-- invoice-notes -->
													</td>
													<td class="tx-right">الاجمالي</td>
													<td class="tx-right" colspan="2">{{ number_format($total,2)}}$</td>
												</tr>
												<tr>
													<td class="tx-right">نسبة الضريبة  (%)</td>
													<td class="tx-right" colspan="2"> {{ number_format($invoice->rat_vat,2) }}% </td>
												</tr>
												<tr>
													<td class="tx-right">قيمة الخصم</td>
													<td class="tx-right" colspan="2">{{ number_format($invoice->discount,2) }}$</td>
												</tr>
												<tr>
													<td class="tx-right tx-uppercase tx-bold tx-inverse">الاجمالي شامل الضريبة</td>
													<td class="tx-right" colspan="2">
														<h4 class="tx-primary tx-bold">{{ number_format($invoice->total,2) }}$</h4>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<hr class="mg-b-40">
								
									<a href="#" class="btn btn-danger float-left mt-3 mr-2" id="printInvoice">
										<i class="mdi mdi-printer ml-1"></i>طباعة
									</a>
									
								</div>
							</div>
						</div>
					</div><!-- COL-END -->

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
        $('#printInvoice').click((e)=>{
            e.preventDefault();
            let contentPrinted = $('#printContent').html(),
                originalContent= $('body').html();

            $("body").html(contentPrinted);

            window.print();
            $('body').html(originalContent);

            location.reload();

            // hide print btn in @media print style chek style in the bottom
        })
    })
</script>
@endsection

@section('css')
    <style>
        @media print {
            #printInvoice{
                display:none
            }
        }
    </style>
@endsection