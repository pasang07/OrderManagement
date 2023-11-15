<!-- Required Js -->
<script src="{{asset('resources/super-admin/js/vendor-all.min.js')}}"></script>
<script src="{{asset('resources/super-admin/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('resources/super-admin/js/menu-setting.min.js')}}"></script>
<script src="{{asset('resources/super-admin/js/pcoded.min.js')}}"></script>
<!-- amchart js -->
<script src="{{asset('resources/super-admin/plugins/amchart/js/amcharts.js')}}"></script>
<script src="{{asset('resources/super-admin/plugins/amchart/js/gauge.js')}}"></script>
<script src="{{asset('resources/super-admin/plugins/amchart/js/serial.js')}}"></script>
<script src="{{asset('resources/super-admin/plugins/amchart/js/light.js')}}"></script>
<script src="{{asset('resources/super-admin/plugins/amchart/js/pie.min.js')}}"></script>
<script src="{{asset('resources/super-admin/plugins/amchart/js/ammap.min.js')}}"></script>
<script src="{{asset('resources/super-admin/plugins/amchart/js/usaLow.js')}}"></script>
<script src="{{asset('resources/super-admin/plugins/amchart/js/radar.js')}}"></script>
<script src="{{asset('resources/super-admin/plugins/amchart/js/worldLow.js')}}"></script>
<!-- notification Js -->
<script src="{{asset('resources/super-admin/plugins/notification/js/bootstrap-growl.min.js')}}"></script>
<!-- parsley Validation -->
<script src="{{asset('resources/super-admin/plugins/parsleyjs/dist/parsley.min.js')}}"></script>
<!-- dashboard-custom js -->
<script src="{{asset('resources/super-admin/js/pages/dashboard-custom.js')}}"></script>
<!-- ckeditor -->
<script src="{{asset('resources/super-admin/plugins/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
<!--Tag Inputs -->
<script src="{{asset('resources/super-admin/plugins/tagsinput/jquery.tagsinput.min.js')}}"></script>
<!-- light-box -->
<script src="{{asset('resources/super-admin/js/ekko-lightbox.js')}}"></script>
<script src="{{asset('resources/super-admin/plugins/bootstrap-datetimepicker/js/bootstrap-datepicker.min.js')}}"></script>

<script src="{{asset('resources/super-admin/js/pages/ac-datepicker.js')}}"></script>

<script src="{{asset('resources/super-admin/plugins/data-tables/js/datatables.min.js')}}"></script>
<script src="{{asset('resources/super-admin/js/pages/tbl-datatable-custom.js')}}"></script>

<!-- Smart Wizard Js -->
<script src="{{asset('resources/super-admin/plugins/smart-wizard/js/jquery.smartWizard.min.js')}}"></script>
<script src="{{asset('resources/super-admin/js/pages/wizard-custom.js')}}"></script>

<script src="{{asset('resources/super-admin/js/lessmore.js')}}"></script>

<script src="{{asset('resources/super-admin/js/jquery.repeater.js')}}"></script>
<script type="text/javascript">
    $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
</script>
<script>
    if ($(".tagsinput").length > 0) {
        $('.tagsinput').each(function (e) {
            $(this).tagsInput({
                width : 'auto',
                height: 'auto'
            });
        });
    }
</script>
<script>
    $(function () {
        CKEDITOR.replace('editor');
    });
</script>
<script type="text/javascript">
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
</script>
<script>
    $('.dropdown-menu #active').click(function () {
        var ids = $('input[name=id]:checked').map(function()
        {
            return $(this).val();
        }).get();
        var name=$(this).data('id');
        $.ajax({
            method: 'POST',
            url: '{{ route('change.status') }}',
            data: {
                '_token': '{{ csrf_token() }}',
                status:'1',
                name: name,
                id: ids,
            },
            dataType: "json",
            success: function (response) {
                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown)
            }
        });
    });
</script>
<script>
    $('.dropdown-menu #deactive').click(function () {
        var ids = $('input[name=id]:checked').map(function()
        {
            return $(this).val();
        }).get();
        var name=$(this).data('id');
        $.ajax({
            method: 'POST',
            url: '{{ route('change.status') }}',
            data: {
                '_token': '{{ csrf_token() }}',
                status:'0',
                name: name,
                id: ids,
            },
            dataType: "json",
            success: function (response) {
                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown)
            }
        });
    });
</script>
<script>
    $('.dropdown-menu #delete').click(function () {
        var ids = $('input[name=id]:checked').map(function()
        {
            return $(this).val();
        }).get();
        var name=$(this).data('id')
        $.ajax({
            method: 'POST',
            url: '{{ route('delete.post') }}',
            data: {
                '_token': '{{ csrf_token() }}',
                name:name,
                id: ids,
            },
            dataType: "json",
            success: function (response) {
                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown)
            }
        });
    });
</script>
{{--for sorttable table--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/TableDnD/0.9.1/jquery.tablednd.js" integrity="sha256-d3rtug+Hg1GZPB7Y/yTcRixO/wlI78+2m08tosoRn7A=" crossorigin="anonymous"></script>
@yield('page-specific-scripts')
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
{!! Toastr::render() !!}

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@if (Session::has('sweet_alert.alert'))
    <script>
        swal({!! Session::get('sweet_alert.alert') !!});
    </script>
@endif


<!--Flatpickr Date-->
<script src="{{asset('resources/super-admin/plugins/flatpickr/flatpickr.min.js')}}"></script>
<script>
    flatpickr("#estimate_date", {
        enableTime: false,
        dateFormat: "Y-m-d",
        minDate: "today"

    });
</script>
<script>
    $('.count').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 4000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
</script>





</body>



</html>
