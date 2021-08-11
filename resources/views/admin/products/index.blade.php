@extends('layout.master')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
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
									<a class="modal-effect btn btn-primary py-1 px-2 add-section" data-effect="effect-scale" data-toggle="modal" href="#modalAdd"><i class="fa fa-plus-circle"></i> اضافة منتج</a>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table text-md-nowrap" id="example1">
										<thead>
											<tr>
												<th class="wd-15p border-bottom-0">#</th>
												<th class="wd-15p border-bottom-0">اسم المنتج</th>
												<th class="wd-15p border-bottom-0">القسم</th>
												<th class="wd-15p border-bottom-0">ملاحظات</th>
												<th class="wd-20p border-bottom-0">العمليات</th>
											</tr>
										</thead>
										<tbody>
                                            @php $i=1; @endphp

                                            @foreach ($products as $product)
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$product->product_name}}</td>
                                                    <td>
                                                        @if (isset($product->section->section_name))
                                                            <label class="badge bg-danger text-white">{{$product->section->section_name}}</label>
                                                        @else
                                                            <label class="badge bg-secondary text-white">لا يوجد أي قسم</label>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($product->note=='')
                                                            <small class="text-secondary">لا يوجد أي ملاحظات</small>
                                                        @else
                                                            {{$product->note}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{-- btn edit section --}}
                                                        <a class="modal-effect btn btn-outline-success btn-sm edit-product" data-effect="effect-scale"
                                                            data-toggle="modal" href="#modalEdit" data-status="edit" 
                                                            data-id="{{ $product->id }}" data-product_name="{{ $product->product_name }}"
                                                            data-description="{{ $product->note }}" data-section_id="{{ $product->section_id }}"
                                                            data-section_name="{{ $product->section->section_name }}"
                                                            data-url='{{url('/admin/products/'.$product->id)}}'
                                                            >
                                                            <i class="fa fa-edit"></i>
                                                            تعديل
                                                        </a>
                                                        {{-- btn delete section --}}
                                                        <a class="modal-effect btn btn-outline-danger btn-sm delete-section" data-effect="effect-scale" data-toggle="modal" href="#modalDelete"
                                                            data-id="{{ $product->id }}" data-url='{{url('/admin/products/'.$product->id)}}'
                                                            >
                                                            <i class="fa fa-trash"></i>
                                                            حذف
                                                        </a>
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

					{{-- modal add section--}}
                    <div class="modal effect-scale" id="modalAdd" style="padding-right: 17px; display: none;" aria-modal="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header bg-info">
                                    <h6 class="modal-title text-white">اضافة منتج</h6><button aria-label="Close" class="close text-white" data-dismiss="modal" type="button"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span></button>
                                </div>
                                {!! Form::open(['route' => 'products.store','autocomplete'=>'off']) !!}
                                @method('post')
                                <div class="modal-body">

                                    {{-- product_name field --}}
                                    <div class="form-group {{$errors->has('product_name') ? 'has-error' : ''}}">
                                        {!! Form::label('product_name', 'اسم المنتج :', ['class'=>'form-label']) !!}
                                        {!! Form::text('product_name', old('product_name'), ['class'=>'form-control',"placeholder"=>"اسم المنتج"]) !!}
                            
                                        @if ($errors->has('product_name'))
                                        <span class="help-block">
                                            <strong>{{$errors->first('product_name')}}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    {{-- section_name field --}}
                                    <div class="form-group {{$errors->has('section_id') ? 'has-error' : ''}}">
                                        {!! Form::label('section_id', 'القسم :', ['class'=>'form-label']) !!}
                                        {!! Form::select('section_id', $sections , null , ['class'=>'form-select d-block select2','placeholder'=>'قسم المنتج']) !!}

                                        @if ($errors->has('section_id'))
                                        <span class="help-block">
                                            <strong>{{$errors->first('section_id')}}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    
                                    {{-- note field --}}
                                    <div class="form-group {{$errors->has('note') ? 'has-error' : ''}}">
                                        {!! Form::label('note', 'ملاحظات :', ['class'=>'form-label']) !!}
                                        {!! Form::textarea('note', old('note'), ['class'=>'form-control',"placeholder"=>"ملاحظات",'rows'=>'3']) !!}
                                        
                                        @if ($errors->has('note'))
                                        <span class="help-block">
                                            <strong>{{$errors->first('note')}}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <div class="ml-auto">
                                        <button class="btn ripple btn-success py-1 px-2" type="submit"><i class="fa fa-check"></i> تأكيد</button>
                                        <button class="btn ripple btn-danger py-1 px-2" data-dismiss="modal" type="button"><i class="fa fa-times"></i> اغلاق</button>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>

					{{-- modal edit section--}}
                    <div class="modal effect-scale" id="modalEdit" style="padding-right: 17px; display: none;" aria-modal="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header bg-success">
                                    <h6 class="modal-title text-white">تعديل القسم</h6><button aria-label="Close" class="close text-white" data-dismiss="modal" type="button"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span></button>
                                </div>
                                {!! Form::open(['autocomplete'=>'off']) !!}
                                @method('PATCH')
                                <div class="modal-body">
                                    {{-- hidden input form url --}}
                                    {!! Form::hidden('url', old('url')) !!}

                                    {{-- product_name field --}}
                                    <div class="form-group {{$errors->has('product_name') ? 'has-error' : ''}}">
                                        {!! Form::label('product_name', 'اسم المنتج :', ['class'=>'form-label']) !!}
                                        {!! Form::text('product_name', old('product_name'), ['class'=>'form-control',"placeholder"=>"اسم المنتج"]) !!}
                            
                                        @if ($errors->has('product_name'))
                                        <span class="help-block">
                                            <strong>{{$errors->first('product_name')}}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    {{-- section_name field --}}
                                    <div class="form-group {{$errors->has('section_id') ? 'has-error' : ''}}">
                                        {!! Form::label('section_id', 'القسم :', ['class'=>'form-label']) !!}
                                        {!! Form::select('section_id', $sections , null , ['class'=>'form-control d-block select2','placeholder'=>'قسم المنتج']) !!}

                                        @if ($errors->has('section_id'))
                                        <span class="help-block">
                                            <strong>{{$errors->first('section_id')}}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    
                                    {{-- note field --}}
                                    <div class="form-group {{$errors->has('note') ? 'has-error' : ''}}">
                                        {!! Form::label('note', 'ملاحظات :', ['class'=>'form-label']) !!}
                                        {!! Form::textarea('note', old('note'), ['class'=>'form-control',"placeholder"=>"ملاحظات",'rows'=>'3']) !!}
                                        
                                        @if ($errors->has('note'))
                                        <span class="help-block">
                                            <strong>{{$errors->first('note')}}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <div class="ml-auto">
                                        <button class="btn ripple btn-success py-1 px-2" type="submit"><i class="fa fa-check"></i> تأكيد</button>
                                        <button class="btn ripple btn-danger py-1 px-2" data-dismiss="modal" type="button"><i class="fa fa-times"></i> اغلاق</button>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>

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
                                        <button class="btn ripple btn-success py-1 px-2" type="submit"><i class="fa fa-check"></i> تأكيد</button>
                                        <button class="btn ripple btn-danger py-1 px-2" data-dismiss="modal" type="button"><i class="fa fa-times"></i> اغلاق</button>
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


@if ($errors->any())

    @if (session()->has('edit'))
        <script>
            $(()=>{
                let $modal = $('#modalEdit')
                $modal.modal('show');
                let form = $modal.find('form');
		        form.attr('action', $modal.find("input[name='url']").val());
            })
        </script>
    @else
        <script>
            $(()=>{
                $('#modalAdd').modal('show')
            })
        </script>
    @endif

@endif

<script>
    $(()=>{

        // edit section
        $('.edit-product').on('click', function () {
            // reset form edit errors
            resetForm('#modalEdit');

            // form 
            let form = $('#modalEdit').find('form');
            form.attr('action', $(this).data('url'));

            // fill inputs
            form.find('input[name="id"]').val($(this).data('id'));
            form.find('input[name="url"]').val($(this).data('url'));
            form.find('input[name="product_name"]').val($(this).data('product_name'));
            form.find('select[name="section_id"]').val($(this).data('section_id'));
            form.find('select[name="section_id"]:selected').text($(this).data('section_name'));

            let $section_name = $(this).data('section_name'),
                $select_sections = Object.entries(form.find('select[name="section_id"]').find('option')),
                section_id = $(this).data('section_id');

                // change the text of select2 with section name of product
                $select_sections.forEach(function(el){
                    if(el[0]==section_id){

                        let select_container = $('#select2-section_id-container');

                        select_container.attr('title' ,el[1].text).text(el[1].text);
                    }
                })



            form.find('textarea[name="note"]').text($(this).data('description'));
        });

        // reset form add 
        function resetForm($modal) {
            let form = $($modal).find('form');

            // hide errors
            form.find('.form-group').removeClass('has-error');
            form.find('.form-group').find('.help-block').hide();

            // reset inputs
            form.find('.form-group input').val('');
            form.find('.form-group select').val('');
            form.find('.form-group textarea').text('');
        };

        // add section click reset errors and fields
        $('.add-section').on('click', function () {
            resetForm('#modalAdd');
        })

        // delete section button
        $('.delete-section').on("click", function () {
            let form = $('#modalDelete').find('form');
            form.attr('action', $(this).data('url'));
        });
        
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
