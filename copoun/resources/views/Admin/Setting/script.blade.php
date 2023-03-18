@include('Admin.includes.scripts.dataTableHelper')

<script type="text/javascript">
        @if($type ==1)
    var columes = [
            {data: 'checkBox', name: 'checkBox'},
            {data: 'telgram', name: 'telgram'},
            {data: 'whatsApp', name: 'whatsApp'},
            {data: 'facebook', name: 'facebook'},
            {data: 'twitter', name: 'twitter'},
            {data: 'snap', name: 'snap'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ];
        @elseif($type ==3)
    var columes = [
            {data: 'checkBox', name: 'checkBox'},
            {data: 'terms_ar', name: 'terms_ar'},
            {data: 'terms_en', name: 'terms_en'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ];
        @elseif($type ==15)
    var columes = [
            {data: 'checkBox', name: 'checkBox'},
            {data: 'terms_ar', name: 'terms_ar'},
            {data: 'terms_en', name: 'terms_en'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ];
        @else
    var columes = [
            {data: 'checkBox', name: 'checkBox'},
            {data: 'companyLogo', name: 'companyLogo'},
            {data: 'aboutImage', name: 'aboutImage'},
            {data: 'phone', name: 'phone'},
            {data: 'whatsApp', name: 'whatsApp'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ];
        @endif
    var table = $('#datatable').DataTable({
            bLengthChange: false,
            searching: true,
            responsive: true,
            'processing': true,
            'language': {
                'loadingRecords': '&nbsp;',
                'processing': '<div class="spinner"></div>',
                'sSearch': 'بحث :',
                "paginate": {
                    "next": "التالي",
                    "previous": "السابق"
                },
                "sInfo": "عرض صفحة _PAGE_ من _PAGES_",
            },
            serverSide: true,

            order: [[0, 'desc']],

            buttons: ['copy', 'excel', 'pdf'],

            ajax: "{{ route('Setting.allData',['type'=>$type])}}",

            columns: columes
        });

    $('#formSubmit').submit(function (e) {
        e.preventDefault();
        saveOrUpdate("{{ route('Setting.update') }}");
    });


    function editFunction(id) {

        save_method = 'edit';

        $('#err').slideUp(200);

        $('#loadEdit_' + id).css({'display': ''});

        $.ajax({
            url: "/Admin/Setting/edit/" + id,
            type: "GET",
            dataType: "JSON",

            success: function (data) {

                $('#loadEdit_' + id).css({'display': 'none'});

                $('#save').text('تعديل');

                $('#titleOfModel').text('تعديل ');

                $('#formSubmit')[0].reset();

                $('#formModel').modal();

                $('#twitter').val(data.twitter);
                $('#terms_ar').val(data.terms_ar);
                $('#terms_en').val(data.terms_en);
                $('#about_ar').val(data.about_ar);
                $('#about_en').val(data.about_en);
                $('#aboutCompany_ar').val(data.aboutCompany_ar);
                $('#aboutCompany_en').val(data.aboutCompany_en);
                $('#phone').val(data.phone);
                $('#facebook').val(data.facebook);
                $('#snap').val(data.snap);
                $('#whatsApp').val(data.whatsApp);
                $('#telgram').val(data.telgram);
                $('#phoneD').val(data.phoneD);
                $('#emailD').val(data.emailD);
                $('#id').val(data.id);
            }
        });
    }


</script>

