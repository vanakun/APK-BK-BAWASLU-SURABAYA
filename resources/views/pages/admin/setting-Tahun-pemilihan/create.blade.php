@extends('../layout/' . $layout)

@section('subhead')
    <title>Dashboard - Tinker - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
           <br>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('SettingTahunPemilihan') }}">Back</a>
            </div>
            <br>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('storeTahunPemilihan') }}" method="POST">
    @csrf

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group" style="margin-bottom: 20px;">
                <strong>Tahun Pemilihan:</strong>
                <input type="text" id="datepicker" name="tahun_pemilihan" class="form-control" placeholder="Input Tahun Pemilihan">
            </div>
        </div>
        <br>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>

</div>

<script>
    $(function() {
        $("#datepicker").datepicker({
            dateFormat: "yy", // Format tahun yang diinginkan (YYYY)
            changeYear: true, // Mengaktifkan pemilihan tahun
            showButtonPanel: true, // Menampilkan panel tombol
            onClose: function(dateText, inst) {
                var year = $("#ui-datepicker-div .ui-datepicker-year option:selected").val();
                $(this).datepicker("setDate", new Date(year, 1));
            }
        });
    });
</script>
@endsection
