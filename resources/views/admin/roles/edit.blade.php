@extends('layout.master')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{ adminUrl('roles') }}">الصلاحيات</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل صلاحية</span>
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
                        <div class="card-body">
                            {!! Form::open(['route'=>['roles.update',$role->id],'method'=>'patch']) !!}
                            <div class="row">
                                {{-- User name field --}}
                                <div class="col-md-4 col-lg-2">
                                    <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
                                        {!! Form::label('name', 'اسم الصلاحية :', ['class'=>'form-label']) !!}
                                        {!! Form::text('name', $role->name, ['class'=>'form-control',"placeholder"=>"اسم الصلاحية"]) !!}
                            
                                        @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{$errors->first('name')}}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- End row --}}
                            
                            <div class="row">
                                {{-- User permission list --}}
                                <div class="col-md-6">
                                    <div class="form-group {{$errors->has('permission') ? 'has-error' : ''}}">
                                        <ul id="treeview1" class="tree">
                                            <li class="branch"><a href="#">الصلاحيات</a>
                                                <ul class="mt-3">
                                                    @foreach ($permission as $perm)
                                                    <li>
                                                        {!! Form::checkbox("permission[]", $perm->name, in_array($perm->id,$rolePermissions), ["class"=>'form-checkbox d-none']) !!}
                                                        <div class="main-toggle d-inline-block">
                                                            <span></span>
                                                        </div>
                                                        <span class="permission">
                                                            {{$perm->name}}
                                                        </span>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        </ul>
                            
                                        @if ($errors->has('permission'))
                                        <span class="help-block">
                                            <strong>{{$errors->first('permission')}}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- End row --}}
                            
                            <div class="row justify-content-start mt-4">
                                <div class="form-group">
                                    <button class="btn btn-success btn-block"> حفظ <i class="fa fa-floppy-o float"></i></button>
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

@push('css')
    <link rel="stylesheet" href="{{url('assets/plugins/treeview/treeview-rtl.css')}}">
    <style>
        li.branch .permission{
            transform: translateY(-7px);
            display: inline-block;
            margin-right: 8px;
        }
    </style>
@endpush

@section('js')
    <script src="{{url('assets/plugins/treeview/treeview.js')}}"></script>
    
    <script>
        $(()=>{
            
            Object.entries($('.form-checkbox')).forEach(element => {
                let $element = $($(element)[1]);

               if($element.attr('checked')!=undefined && $element.attr('checked')=="checked"){

                    $element.siblings('.main-toggle').addClass('on')
                    $element.siblings('.permission').addClass('text-success')
                    
                } else{
                    $element.siblings('.permission').addClass('text-danger')
                }
            });
                
            $('.main-toggle').click(function(){
                let custom_checkbox = $(this);
                custom_checkbox.toggleClass('on');
                
                if (custom_checkbox.hasClass('on')){
                    custom_checkbox.siblings('input[type="checkbox"]').attr('checked',"checked");
                    custom_checkbox.siblings('.permission').toggleClass('text-success text-danger')
                } else{
                    custom_checkbox.siblings('input[type="checkbox"]').removeAttr('checked');
                    custom_checkbox.siblings('.permission').toggleClass('text-danger text-success')
                }
            })
        })
    </script>
@stop
