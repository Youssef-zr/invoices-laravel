@extends('layout.master')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{adminUrl('invoices')}}">الفواتير</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل  فاتورة</span>
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
                                {!! Form::model($invoice,['route'=>['invoices.update',$invoice->id],'method'=>'patch','files'=>true]) !!}
                                    @include('admin.invoices.form')
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
                $select_sections = Object.entries(form.find('select[name="section_id"]').find('option'));


                $select_sections.forEach(function(el){
                    console.log($(el)[0]);
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
            console.log(form.attr('action'));
        });

    })
</script>
@endsection

@section('css')
    <style>
        .select2{
            width: 100% !important
        }
        .text-underline{
            text-decoration: underline
        }
    </style>
@endsection
