@extends('layout.master')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
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
                            <div class="d-flex justify-content-start">
                                @can('اضافة مستخدم')
                                    <a class="modal-effect btn btn-primary py-1 px-2 ml-2" href="{{ adminUrl('users/create') }}"><i class="fa fa-plus-circle"></i> اضافة مستخدم</a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                               <table class="table text-md-nowrap text-center"  id="example1">
                                   <thead>
                                       <tr>
                                           <th>#</th>
                                           <th>اسم المستخدم</th>
                                           <th>البريد الالكتروني</th>
                                           <th>حالة المستخدم</th>
                                           <th>نوع المستخدم</th>
                                           <th>العمليات</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       @php
                                           $i=1;
                                       @endphp

                                       @foreach ($users as $user)
                                           <tr>
                                               <td> {{ $i }} </td>
                                               <td> {{ $user->name }} </td>
                                               <td> {{ $user->email }} </td>
                                               <td> 
                                                   @if ($user->status=="مفعل")
                                                       <span class="badge badge-pill badge-success" style="position: relative;"><span class="pulse" style="right:-15px"></span> {{ $user->status }}</span>
                                                    @else
                                                       <span class="badge badge-pill badge-danger" style="position: relative;"><span class="pulse-danger" style="right:-15px"></span> {{ $user->status }}</span>
                                                   @endif
                                                </td>
                                                <td>
                                                    @foreach ($user->roles_name as $role)
                                                        <span class="badge badge-pill badge-info mr-1">
                                                            {{$role}}
                                                        </span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @can('تعديل مستخدم')
                                                        <a href="{{adminurl('users/'.$user->id.'/edit')}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                                    @endcan

                                                    @can('حذف مستخدم')
                                                        @if ($user->id != 1)
                                                            <a href="#" class="btn btn-danger btn-sm delete_user"
                                                                data-url="{{ adminUrl('users/'.$user->id)}}"
                                                                >
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        @endif
                                                     @endcan
                                                </td>
                                           </tr>
                                           @php
                                               $i++;
                                           @endphp
                                       @endforeach
                                   </tbody>
                               </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- modal delete user --}}
                @can('حذف مستخدم')
                    <div class="modal effect-scale" id="modalDelete" style="padding-right: 17px; display: none;" aria-modal="true">
                        <div class="modal-dialog modal-dialog-centered " role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header bg-danger">
                                    <h6 class="modal-title text-white">حذف مستخدم .</h6>
                                    <button aria-label="Close" class="close text-white" data-dismiss="modal" type="button"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span></button>
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
                                                هل أنت متأكد من حذف هذا المستخدم ؟
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
                @endcan

            </div>
            <!-- row closed -->
        </div>
        <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection

@section('js')
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
<!-- Internal Modal js-->

<script>
    $(()=>{
        // delete section button
        $('.delete_user').click(function(e){
            e.preventDefault();
            
            let modal = $('#modalDelete'),
            form = $('form');
            
            modal.modal('show');
            
            form.attr('action', $(this).data('url'));
        })
    })
</script>
@endsection