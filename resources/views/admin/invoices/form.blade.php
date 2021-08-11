<div class="row">
    {{-- invoice number field --}}
    <div class="col-md-4">
        <div class="form-group {{$errors->has('invoice_number') ? 'has-error' : ''}}">
            {!! Form::label('invoice_number', 'رقم الفاتورة :', ['class'=>'form-label']) !!}
            {!! Form::text('invoice_number', old('invoice_number'), ['class'=>'form-control',"placeholder"=>"رقم الفاتورة"]) !!}

            @if ($errors->has('invoice_number'))
            <span class="help-block">
                <strong>{{$errors->first('invoice_number')}}</strong>
            </span>
            @endif
        </div>
    </div>
    {{-- invoice date field --}}
    <div class="col-md-4">
        <div class="form-group {{$errors->has('invoice_date') ? 'has-error' : ''}}">
            {!! Form::label('invoice_date', 'تاريخ الفاتورة :', ['class'=>'form-label']) !!}
            {!! Form::date('invoice_date', old('invoice_date'), ['class'=>'form-control',"placeholder"=>"تاريخ الفاتورة"]) !!}
            @if ($errors->has('invoice_date'))
            <span class="help-block">
                <strong>{{$errors->first('invoice_date')}}</strong>
            </span>
            @endif
        </div>
    </div>
    {{-- invoice date due field --}}
    <div class="col-md-4">
        <div class="form-group {{$errors->has('due_date') ? 'has-error' : ''}}">
            {!! Form::label('due_date', 'تاريخ الاستحقاق :', ['class'=>'form-label']) !!}
            {!! Form::date('due_date', old('invoice_date'), ['class'=>'form-control',"placeholder"=>"تاريخ الاستحقاق"]) !!}
            @if ($errors->has('due_date'))
            <span class="help-block">
                <strong>{{$errors->first('due_date')}}</strong>
            </span>
            @endif
        </div>
    </div>
</div>
{{-- End row --}}

<div class="row">
    {{-- invoice section field --}}
    <div class="col-md-4">
        <div class="form-group {{$errors->has('section_id') ? 'has-error' : ''}}">
            {!! Form::label('section_id', 'القسم :', ['class'=>'form-label']) !!}
            {!! Form::select('section_id', $sections,null, ['class'=>'form-control select2',"placeholder"=>"القسم"]) !!}

            @if ($errors->has('section_id'))
            <span class="help-block">
                <strong>{{$errors->first('section_id')}}</strong>
            </span>
            @endif
        </div>
    </div>
    {{-- invoice product field --}}
    <div class="col-md-4">
        <div class="form-group {{$errors->has('product') ? 'has-error' : ''}}">
            {!! Form::label('product', 'المنتج :', ['class'=>'form-label']) !!}
            {!! Form::select('product', [],null, ['class'=>'form-control select2',"placeholder"=>"المنتج"]) !!}
            @if ($errors->has('product'))
            <span class="help-block">
                <strong>{{$errors->first('product')}}</strong>
            </span>
            @endif
        </div>
    </div>

    {{-- invoice date due field --}}
    <div class="col-md-4">
        <div class="form-group {{$errors->has('amount_collection') ? 'has-error' : ''}}">
            {!! Form::label('amount_collection', 'مبلغ التحصيل:', ['class'=>'form-label']) !!}
            {!! Form::text('amount_collection', old('amount_collection'), ['class'=>'form-control',"placeholder"=>"مبلغ التحصيل (000000:00)"]) !!}
            @if ($errors->has('amount_collection'))
            <span class="help-block">
                <strong>{{$errors->first('amount_collection')}}</strong>
            </span>
            @endif
        </div>
    </div>
</div>
{{-- End row --}}

<div class="row">
    {{-- invoice amount_commission field --}}
    <div class="col-md-4">
        <div class="form-group {{$errors->has('amount_commission') ? 'has-error' : ''}}">
            {!! Form::label('amount_commission', 'مبلغ العمولة :', ['class'=>'form-label']) !!}
            {!! Form::text('amount_commission', old('amount-val'), ['class'=>'form-control',"placeholder"=>"(مبلغ العمولة (000000:00"]) !!}

            @if ($errors->has('amount_commission'))
            <span class="help-block">
                <strong>{{$errors->first('amount_commission')}}</strong>
            </span>
            @endif
        </div>
    </div>
    
    {{-- invoice discount field --}}
    <div class="col-md-4">
        <div class="form-group {{$errors->has('discount') ? 'has-error' : ''}}">
            {!! Form::label('discount', 'الخصم:', ['class'=>'form-label']) !!}
            {!! Form::text('discount', 0, ['class'=>'form-control',"placeholder"=>"(000000:00) الخصم"]) !!}
            @if ($errors->has('discount'))
            <span class="help-block">
                <strong>{{$errors->first('discount')}}</strong>
            </span>
            @endif
        </div>
    </div>
    {{-- invoice rat_vat field --}}
    <div class="col-md-4">
        <div class="form-group {{$errors->has('rat_vat') ? 'has-error' : ''}}">
            {!! Form::label('rat_vat', 'نسبة ضريبة القيمة المضافة :', ['class'=>'form-label']) !!}
            {!! Form::select('rat_vat', rat_vat(),null, ['class'=>'form-control select2',"placeholder"=>"ضريبة القيمة المضافة"]) !!}

            @if ($errors->has('rat_vat'))
            <span class="help-block">
                <strong>{{$errors->first('rat_vat')}}</strong>
            </span>
            @endif
        </div>
    </div>
</div>
{{-- End row --}}

<div class="row">
    {{-- invoice value_vat field --}}
    <div class="col-md-6">
        <div class="form-group {{$errors->has('value_vat') ? 'has-error' : ''}}">
            {!! Form::label('value_vat', 'قيمة ضريبة القيمة المضافة:', ['class'=>'form-label']) !!}
            {!! Form::text('value_vat', 0, ['class'=>'form-control',"placeholder"=>"قيمة ضريبة القيمة المضافة","readonly"=>"readonly"]) !!}

            @if ($errors->has('value_vat'))
            <span class="help-block">
                <strong>{{$errors->first('value_vat')}}</strong>
            </span>
            @endif
        </div>
    </div>
    {{-- invoice total due field --}}
    <div class="col-md-6">
        <div class="form-group {{$errors->has('total') ? 'has-error' : ''}}">
            {!! Form::label('total', 'الاجمالي شامل الضريبة:', ['class'=>'form-label']) !!}
            {!! Form::text('total', 0, ['class'=>'form-control',"placeholder"=>"الاجمالي شامل الضريبة","readonly"=>"readonly"]) !!}

            @if ($errors->has('total'))
            <span class="help-block">
                <strong>{{$errors->first('total')}}</strong>
            </span>
            @endif
        </div>
    </div>
    {{-- invoice note due field --}}
    <div class="col-md-12">
        <div class="form-group {{$errors->has('note') ? 'has-error' : ''}}">
            {!! Form::label('note', 'ملاحظات:', ['class'=>'form-label']) !!}
            {!! Form::textarea('note', old('note'), ['class'=>'form-control',"placeholder"=>"ملاحظات",'rows'=>'5']) !!}

            @if ($errors->has('note'))
            <span class="help-block">
                <strong>{{$errors->first('note')}}</strong>
            </span>
            @endif
        </div>
    </div>
</div>
{{-- End row --}}

<div class="row">
    <div class="col-md-12">
        <div class="form-group {{$errors->has('attachments') ? 'has-error' : ''}}">
            {!! Form::label('', '* صيغة المرفق pdf , jpeg , jpg , gif , png', ['class'=>'form-label text-danger']) !!}
            {!! Form::label('attachments', 'المرفقات:', ['class'=>'form-label']) !!}
         
            {!! Form::file('attachments', ['class'=>'form-control dropify',"placeholder"=>"المرفقات",'rows'=>'5',
                                            "multiple"=>'multiple',"data-max-file-size"=>"3M", "data-show-errors"=>"true", 
                                            "data-allowed-file-extensions"=>"pdf png jpg jpeg gif",
            ]) !!}
        
            @if ($errors->has('attachments'))
            <span class="help-block">
                <strong>{{$errors->first('attachments')}}</strong>
            </span>
            @endif
        </div>
    </div>
</div>
{{-- End row --}}

<div class="row justify-content-center">
    <div class="col-md-2">
        <div class="form-group">
            <button class="btn btn-info btn-block"> حفظ <i class="fa fa-floppy-o float"></i></button>
        </div>
    </div>
</div>

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"/>
<style>
    
    .btn{
        position:relative;
        font-size: 16px
    }

    .btn i.float{
        margin-right: 10px
    }

</style>
@stop


@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>

<script>
    $(()=>{

        // library of images
        let event = $('.dropify').dropify({
            messages: {
                'default': 'قم بسحب وافلات ملف هنا أو انقر',
                'replace': 'قم بالسحب والإفلات أو النقر للاستبدال',
                'remove':  'حذف',
                'error':   'عفوًا ، حدث خطأ ما.'
            }
        });

        // get products of a section
        $('select[name="section_id"]').on('change',function(){

            console.log('hds')
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

        // clculate the sum total   
        let calc_commision=()=>{

            let amount_commission = $('#amount_commission').val(),
            discount = $('#discount').val(),
            rat_vat = $('#rat_vat').val(),
            value_vat = $('#value_vat');
            
            let amount_commission2 = amount_commission-discount;
            
            if(typeof amount_commission === "undefined" || !amount_commission){
                alert('المرجوا ادخال مبلغ العمولة')
                $('#rat_vat').val("");
                $('#select2-rat_vat-container').attr('title',"");
                $('#select2-rat_vat-container').text("ضريبة القيمة المضافة");

            }else{
                let result = amount_commission2 * rat_vat /100,
                result2 = result + amount_commission2,
                sumq = parseFloat(result).toFixed(2), // sum commission
                sumt = parseFloat(result2).toFixed(2); // sum total

                value_vat.val(sumq);
                $('#total').val(sumt);
                
            }
        }

        $('#rat_vat').on('change',()=>{
            calc_commision();
        })

        // get current date in filed invoice date
        Date.prototype.toDateInputValue = (function() {
            var local = new Date(this);
            local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
            return local.toJSON().slice(0,10);
        });

        $('#invoice_date').val(new Date().toDateInputValue());
        
    })
</script>
@stop