<div class="session-msg">
    @if (session()->has('msgSuccess'))
        <script>
            new Noty({
                "theme": 'relax',
                "type":"success",
                "layout":'topRight',
                "text":"{{session('msgSuccess')}}",
                "timeout":2000,
                "killer":true,
                "progressBar": true,
            }).show();
        </script>
    
    @elseif (session()->has('msgDanger'))
        <script>
            new Noty({
                "theme": 'relax',
                "type":"error",
                "layout":'topRight',
                "text":"{{session('msgDanger')}}",
                "timeout":2000,
                "killer":true,
                "progressBar": true,
            }).show();
        </script>
    @elseif (session()->has('msgWarning'))
        <script>
            new Noty({
                "theme": 'relax',
                "type":"warning",
                "layout":'topRight',
                "text":"{{session('msgWarning')}}",
                "timeout":2000,
                "killer":true,
                "progressBar": true,
            }).show();
        </script>
    @endif
    
    </div>

@push('js')

@endpush