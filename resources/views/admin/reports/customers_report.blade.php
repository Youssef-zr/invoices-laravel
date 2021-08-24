@extends('layout.master')

@section('css')
<style>
    
    .text-radio{
        font-size:16px;
        margin-right:6px
    }
</style>
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">التقارير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تقرير العملاء</span>
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
                            {{-- start form search by status --}}
                            <div id="form_status_invoice">
                                {!! Form::open(["route"=>'customers_report'],['method'=>'Post',"class"=>"form-horizontal"]) !!}
                                    @csrf
                                    @method("Post")
    
                                    <div class="row">
                                        {{-- invoice section field --}}
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                {!! Form::label('section_id', 'القسم :', ['class'=>'form-label']) !!}
                                                {!! Form::select('section_id', $sections,$section_id??'', ['class'=>'form-control select2',"placeholder"=>"القسم"]) !!}
                                            </div>
                                        </div>
                                        {{-- invoice product field --}}
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                {!! Form::label('product', 'المنتج :', ['class'=>'form-label']) !!}
                                                {!! Form::select('product', [],$product??'', ['class'=>'form-control select2',"placeholder"=>"المنتج"]) !!}
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                {!! Form::label("start_at", "من تاريخ", ["class"=>"form-label"]) !!}
                                                {!! Form::date('start_at', $start_at ?? '' , ['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group">
                                                {!! Form::label("end_at", "الى تاريخ", ["class"=>"form-label"]) !!}
                                                {!! Form::date('end_at', $end_at ?? '' , ['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        
                                    </div>
    
                                    <div class="form-group">
                                        <button class="btn btn-info"> بحث <i class="fa fa-floppy-o float"></i></button>
                                    </div>
    
                                {!! Form::close() !!}
                            </div>

                            {{-- Invoices List --}}
                            @if (isset($invoices))
                            <div class="table-responsive">
                                <table class="table text-center text-md-nowrap" id="example1">
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
                                            </tr>
                                        
                                            @php $i++; @endphp
                                        @endforeach
                                       
                                     
                                    </tbody>
                                </table>
                            </div>
                            @endif
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
<script>
    $(()=>{
        // get products of a section
        $('select[name="section_id"]').on('change',function(){
        
            let $section_id = $(this).val(),
                product_select_box = $('select[name="product"]');
        
           if($section_id){
               $.ajax({
                    url:"{{url('admin/section')}}/"+$section_id,
                    type:"get",
                    dataType:"json",
                    success:function(data){
        
                        // clear all products in the select products
                        product_select_box.empty();
        
                        // get the products of this section
                        let products = data['products'];
        
                        // fill product select box by options
                        let $result ='';
        
                        Object.entries(products).forEach(element => {
                            const id = element[0],
                                  product_name=element[1];
        
                            $result+=`<option val='${id}'>${product_name}</option>`;
        
                        });
                        
                        product_select_box.append($result);
        
                    }
               })
        
           }else{
               // clear all products in the select products
               product_select_box.empty();
        
               // show alert error
               alert('ajax load did not work');
            
           }
        });
    })
</script>

@endsection