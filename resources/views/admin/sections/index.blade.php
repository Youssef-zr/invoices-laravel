@extends('layout.master')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الأقسام</span>
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
									<a class="modal-effect btn btn-primary py-1 px-2 add-section" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8"><i class="fa fa-plus-circle"></i> اضافة قسم</a>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table text-md-nowrap" id="example1">
										<thead>
											<tr>
												<th class="wd-15p border-bottom-0">#</th>
												<th class="wd-15p border-bottom-0">اسم القسم</th>
												<th class="wd-15p border-bottom-0">ملاحظات</th>
												<th class="wd-20p border-bottom-0">العمليات</th>
											</tr>
										</thead>
										<tbody>
                                            @php $i=1; @endphp
                                            
                                            @foreach ($sections as $section)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $section->section_name }}</td>
                                                    <td>{{ $section->note }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="modal-effect btn btn-warning btn-sm edit-section" data-effect="effect-scale"
                                                                data-toggle="modal" href="#modaldemo81" data-status="edit" 
                                                                data-id="{{ $section->id }}" data-section_name="{{ $section->section_name }}" data-description="{{ $section->note }}"
                                                                data-url='{{url('/admin/sections/'.$section->id)}}'
                                                                >
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <a class="modal-effect btn btn-danger btn-sm" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8"><i class="fa fa-trash"></i></a>
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

					{{-- modal add section--}}
                    <div class="modal effect-scale" id="modaldemo8" style="padding-right: 17px; display: none;" aria-modal="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">اضافة قسم</h6><button aria-label="Close" class="close text-danger" data-dismiss="modal" type="button"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span></button>
                                </div>
                                {!! Form::open(['route' => 'sections.store']) !!}
                                @method('post')
                                <div class="modal-body">
                                    {{-- field id for update --}}
                                    {!! Form::hidden('id', old('id')) !!}
                                    {{-- section_name field --}}
                                    <div class="form-group {{$errors->has('section_name') ? 'has-error' : ''}}">
                                        {!! Form::label('section_name', 'اسم القسم :', ['class'=>'form-label']) !!}
                                        {!! Form::text('section_name', old('section_name'), ['class'=>'form-control',"placeholder"=>"اسم القسم"]) !!}
                            
                                        @if ($errors->has('section_name'))
                                        <span class="help-block">
                                            <strong>{{$errors->first('section_name')}}</strong>
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
                    <div class="modal effect-scale" id="modaldemo81" style="padding-right: 17px; display: none;" aria-modal="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">تعديل قسم</h6><button aria-label="Close" class="close text-danger" data-dismiss="modal" type="button"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span></button>
                                </div>
                                {!! Form::open() !!}
                                @method('PATCH')
                                <div class="modal-body">
                                    {{-- field id for update --}}
                                    {!! Form::hidden('id', old('id')) !!}
                                    {!! Form::hidden('url', old('url')) !!}

                                    {{-- section_name field --}}
                                    <div class="form-group {{$errors->has('section_name') ? 'has-error' : ''}}">
                                        {!! Form::label('section_name', 'اسم القسم :', ['class'=>'form-label']) !!}
                                        {!! Form::text('section_name', old('section_name'), ['class'=>'form-control',"placeholder"=>"اسم القسم"]) !!}
                            
                                        @if ($errors->has('section_name'))
                                        <span class="help-block">
                                            <strong>{{$errors->first('section_name')}}</strong>
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
                let $modal = $('#modaldemo81')
                $modal.modal('show');
                let form = $modal.find('form');
		        form.attr('action', $modal.find("input[name='url']").val());
            })
        </script>
    @else
        <script>
            $(()=>{
                $('#modaldemo8').modal('show')
            })
        </script>
    @endif

@endif

@endsection