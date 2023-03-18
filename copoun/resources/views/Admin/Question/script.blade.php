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

        ajax: "{{ route('Question.allData')}}",

        columns: [
            {data: 'checkBox', name: 'checkBox'},
            {data: 'id', name: 'id'},
            {data: 'question_ar', name: 'question_ar'},
            {data: 'question_en', name: 'question_en'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#formSubmit').submit(function (e) {
        e.preventDefault();
        saveOrUpdate( save_method == 'add' ?"{{ route('Question.create') }}" : "{{ route('Question.update') }}");
    });


    function editFunction(id) {

        save_method = 'edit';

        $('#err').slideUp(200);

        $('#loadEdit_' + id).css({'display': ''});

        $.ajax({
            url: "{{get_baseUrl()}}/Admin/Question/edit/" + id,
            type: "GET",
            dataType: "JSON",

            success: function (data) {

                $('#loadEdit_' + id).css({'display': 'none'});

                $('#save').text('تعديل');

                $('#titleOfModel').text(' تعديل');

                $('#formSubmit')[0].reset();

                $('#formModel').modal();

                $('#question_ar').val(data.question_ar);
                $('#question_en').val(data.question_en);
                $('#answer_en').val(data.answer_en);
                $('#answer_ar').val(data.answer_ar);
                $('#id').val(data.id);
            }
        });
    }

    function deleteFunction(id,type) {
        if (type == 2 && checkArray.length == 0) {
            alert('برجاء تحديد عناصر للحذف');
        } else if (type == 1){
            url =  "{{get_baseUrl()}}/Admin/Question/destroy/" + id;
            deleteProccess(url);
        }else{
            url= "{{get_baseUrl()}}/Admin/Question/destroy/" + checkArray + '?type=2';
            deleteProccess(url);
            checkArray=[];
        }
    }


</script>

<script>
    function ChangeStatus(status,id) {
        Toset('طلبك قيد التنفيذ','info','',false);
        $.ajax({
            url : '{{get_baseUrl()}}/Admin/Question/ChangeStatus/' +id +'?status='+status,
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
        table.ajax.url('{{get_baseUrl()}}/Admin/Question/allData?' + formData);
        table.ajax.reload();
        TosetV2('تمت العملية بنجاح', 'success', '', 5000);

    })
</script>
