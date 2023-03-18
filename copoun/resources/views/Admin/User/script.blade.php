@include('Admin.includes.scripts.dataTableHelper')

<script type="text/javascript">

    var table = $('#datatable').DataTable({
        bLengthChange: false,
        searching: true,
        responsive: true,
        'processing': true,
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': '<div class="spinner"></div>',
            'sSearch' : 'بحث :',
            "paginate": {
                "next": "التالي",
                "previous": "السابق"
            },
            "sInfo": "عرض صفحة _PAGE_ من _PAGES_",
        },
        serverSide: true,

        order: [[0, 'desc']],

        buttons: ['copy', 'excel', 'pdf'],

        ajax: "{{ route('User.allData')}}",

        columns: [
            {data: 'checkBox', name: 'checkBox'},
            {data: 'id', name: 'id'},
            {data: 'image', name: 'image'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#formSubmit').submit(function (e) {
        e.preventDefault();
        saveOrUpdate( save_method == 'add' ?"{{ route('User.create') }}" : "{{ route('User.update') }}");
    });


    function editFunction(id) {

        save_method = 'edit';

        $('#err').slideUp(200);

        $('#loadEdit_' + id).css({'display': ''});

        $.ajax({
            url: "{{get_baseUrl()}}/Admin/User/edit/" + id,
            type: "GET",
            dataType: "JSON",

            success: function (data) {

                $('#loadEdit_' + id).css({'display': 'none'});

                $('#save').text('تعديل');

                $('#titleOfModel').text(' تعديل');

                $('#formSubmit')[0].reset();

                $('#formModel').modal();

                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#gender').val(data.gender);
                $('#dateOfBirth').val(data.dateOfBirth);
                $('#phone').val(data.phone);
                $('#id').val(data.id);
            }
        });
    }

    function deleteFunction(id,type) {
        if (type == 2 && checkArray.length == 0) {
            alert('برجاء تحديد عناصر للحذف');
        } else if (type == 1){
            url =  "{{get_baseUrl()}}/Admin/User/destroy/" + id;
            deleteProccess(url);
        }else{
            url= "{{get_baseUrl()}}/Admin/User/destroy/" + checkArray + '?type=2';
            deleteProccess(url);
            checkArray=[];
        }
    }


</script>

<script>
    function ChangeStatus(status,id) {
        Toset('طلبك قيد التنفيذ','info','',false);
        $.ajax({
            url : '{{get_baseUrl()}}/Admin/User/ChangeStatus/' +id +'?status='+status,
            type : 'get',
            success : function(data){
                $.toast().reset('all');
                table.ajax.reload();
                Toset('تمت العملية بنجاح','success','',5000);
            }
        })
    }
</script>




{{-- Search Form --}}
<script>
    $('#seachForm').submit(function (e) {
        e.preventDefault();
        var formData = $('#seachForm').serialize();
        table.ajax.url('{{get_baseUrl()}}/Admin/User/allData?' + formData);
        table.ajax.reload();
        TosetV2('تمت العملية بنجاح', 'success', '', 5000);

    })
</script>

<script>
    function ChangeStatus(status,id) {
        Toset('{{trans('dash.request_process')}}','info','',false);
        $.ajax({
            url : '/Admin/User/ChangeStatus/' +id +'?status='+status,
            type : 'get',
            success : function(data){
                $.toast().reset('all');
                table.ajax.reload();
                swal(data.message, {
                    icon: "success",
                });
                Toset('تمت العملية بنجاح','success','',5000);
            }
        })
    }


</script>


<script>
    function showData(id)
    {
        Toset('{{ trans("main.proccess") }}','info','',false);
        $('#loadShow_'+id).css({'display' : ''});
        save_method='edit';
        $('#save').text('تعديل');
        $('#title').text('تعديل');

        $.ajax({
            url : '/Admin/User/edit/' +id,
            type : 'get',
            success : function(data){

                $('#nameInstitutionS').text(data.nameInstitution);
                $('#nameS').text(data.name);
                $('#created_at').text(data.created_at);
                $('#phoneS').text(data.phone);
                $('#genderS').text(data.gender =1 ? 'ذكر' : 'انثى');
                $('#emailS').text(data.email);
                $('#dateOfBirthS').text(data.dateOfBirth);
                $('#idS').text(id);
                $('#loadShow_'+id).css({'display' : 'none'});
                $('#showData').modal();
                $.toast().reset('all');
            }
        })
    }
</script>

