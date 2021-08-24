@extends('layout.master')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{ adminUrl('roles') }}">الصلاحيات</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ بيانات الصلاحية</span>
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
                            <div class="row">
                                {{-- User name field --}}
                                <div class="col-md-4 col-lg-2">
                                    <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
                                        {!! Form::label('name', 'اسم الصلاحية :', ['class'=>'form-label']) !!}
                                        {!! Form::text('name', $role->name, ['class'=>'form-control',"placeholder"=>"اسم الصلاحية","disabled"]) !!}
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
                                                <ul>
                                                    @foreach ($rolePermissions as $permission)
                                                    <li>
                                                        {{$permission->name}}
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
                        </div>
                    </div>
                </div>
                {{-- End row --}}
            </div>
            <!-- row closed -->
        </div>
        <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection

@push('css')
    <link rel="stylesheet" href="{{url('assets/plugins/treeview/treeview-rtl.css')}}">
@endpush

@section('js')
    <script src="{{url('assets/plugins/treeview/treeview.js')}}"></script>
@stop
