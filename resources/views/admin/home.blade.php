@extends('layout.master')
@section('css')
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
            {{-- start row --}}
                <div class="card">
                    <div class="card-body">
				        <div class="row row-sm">
                            @foreach ($invoices_info as $invoice)

                            {{-- stats card --}}
                                <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                                    <div class="card overflow-hidden sales-card {{ $invoice['style']['card_bg'] }}">
                                        <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                            <div class="">
                                                <h6 class="mb-3 tx-12 text-white"> {{ $invoice['invoice_status'] }} </h6>
                                            </div>
                                            <div class="pb-0 mt-0">
                                                <div class="d-flex">
                                                    <div class="">
                                                        <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                                            {{ $invoice['sum_total_mony']}} 
                                                        </h4>
                                                        
                                                        @php
                                                        
                                                            $invoices_count = $invoice['nb_invoices']
                                                        @endphp

                                                        <p class="mb-0 tx-12 text-white op-7">
                                                            {{$invoices_count}}

                                                            @if ($invoices_count==1)
                                                                فاتورة 
                                                            @else
                                                                فواتير
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <span class="float-right my-auto mr-auto">
                                                        <i class="fas  {{ $invoice['style']['chevron'] }} text-white"></i>
                                                        <span class="text-white op-7">
                                                            {{ $invoice['percentage'] }}
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <span id="{{ $invoice['style']['id_chart'] }}" class="pt-2">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
				</div>
            <!-- row closed -->

            <!-- row opened -->
				<div class="row row-sm">
					<div class="col-md-12 col-lg-12 col-xl-7">
						<div class="card">
							<div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mb-0">احصائيات عدد الفواتير</h4>
									<i class="mdi mdi-dots-horizontal text-gray"></i>
								</div>
								{{-- <p class="tx-12 text-muted mb-0">Order Status and Tracking. Track your order from ship date to arrival. To begin, enter your order number.</p> --}}
							</div>
							<div class="card-body">
                                <div class="mx-auto" style="width:70%">
                                    {!! $chartJs->render() !!}
                                </div>
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
    <!--Internal  index js -->
    <script src="{{ url('assets/js/chart.min.js') }}"></script>
    <script src="{{URL::asset('assets/js/index.js')}}"></script>
@endsection