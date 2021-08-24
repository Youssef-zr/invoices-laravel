<div class="row">
    {{-- User name field --}}
    <div class="col-md-6">
        <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
            {!! Form::label('name', 'اسم المستخدم :', ['class'=>'form-label']) !!}
            {!! Form::text('name', old('name'), ['class'=>'form-control',"placeholder"=>"اسم المستخدم"]) !!}

            @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{$errors->first('name')}}</strong>
            </span>
            @endif
        </div>
    </div>

    {{-- User email field --}}
    <div class="col-md-6">
        <div class="form-group {{$errors->has('email') ? 'has-error' : ''}}">
            {!! Form::label('email', 'البريد الالكتروني :', ['class'=>'form-label']) !!}
            {!! Form::text('email', old('email'), ['class'=>'form-control',"placeholder"=>"البريد الالكتروني"]) !!}

            @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{$errors->first('email')}}</strong>
            </span>
            @endif
        </div>
    </div>
</div>
{{-- End row --}}

<div class="row">
    {{-- User password field --}}
    <div class="col-md-6">
        <div class="form-group {{$errors->has('password') ? 'has-error' : ''}}">
            {!! Form::label('password', 'كلمة المرور :', ['class'=>'form-label']) !!}
            {!! Form::password('password', ['class'=>'form-control',"placeholder"=>"كلمة المرور"]) !!}

            @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{$errors->first('password')}}</strong>
            </span>
            @endif
        </div>
    </div>

    {{-- User confirm-password field --}}
    <div class="col-md-6">
        <div class="form-group {{$errors->has('confirm-password') ? 'has-error' : ''}}">
            {!! Form::label('confirm-password', 'تأكيد كلمة السر :', ['class'=>'form-label']) !!}
            {!! Form::password('confirm-password', ['class'=>'form-control',"placeholder"=>"تأكيد كلمة السر"]) !!}

            @if ($errors->has('confirm-password'))
            <span class="help-block">
                <strong>{{$errors->first('confirm-password')}}</strong>
            </span>
            @endif
        </div>
    </div>
</div>
{{-- End row --}}

<div class="row">
    {{-- User status field --}}
    <div class="col-md-6">
        <div class="form-group {{$errors->has('status') ? 'has-error' : ''}}">
            {!! Form::label('status', 'الحالة :', ['class'=>'form-label']) !!}
            {!! Form::select("status", user_status(), null, ["class"=>"form-control"]) !!}

            @if ($errors->has('status'))
            <span class="help-block">
                <strong>{{$errors->first('status')}}</strong>
            </span>
            @endif
        </div>
    </div>

    {{-- User roles_name field --}}
    <div class="col-md-6">
        <div class="form-group {{$errors->has('roles_name') ? 'has-error' : ''}}">
            {!! Form::label('roles_name', 'صلاحية المستخدم :', ['class'=>'form-label']) !!}
            {!! Form::select("roles_name[]", $roles, null, ["class"=>"form-control",'multiple']) !!}

            @if ($errors->has('roles_name'))
            <span class="help-block">
                <strong>{{$errors->first('roles_name')}}</strong>
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

        
    })
</script>

{{-- get current date invoice add --}}
@if (!isset($editMode))
    <script>
        $(()=>{

            // get current date in filed invoice date
            Date.prototype.toDateInputValue = (function() {
                var local = new Date(this);
                local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
                return local.toJSON().slice(0,10);
            });

            $('#invoice_date').val(new Date().toDateInputValue());
        })
    </script>
@endif

@stop