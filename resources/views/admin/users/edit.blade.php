@extends('layout.master')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{ adminUrl('users') }}">المستخدمين</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل مستخدم</span>
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
                            {!! Form::model($user,['route'=>['users.update',$user->id],'method'=>'patch']) !!}
                                @include('admin.users.form')
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
