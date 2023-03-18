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

        Contact: [[0, 'desc']],

        buttons: ['copy', 'excel', 'pdf'],

        ajax: "{{ route('Contact.allData')}}",

        columns: [
            {data: 'checkBox', name: 'checkBox'},
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'message', name: 'message'},
            {data: 'action', name: 'action', Contactable: false, searchable: false},
        ]
    });

    function editFunction(id) {

        save_method = 'edit';

        $('#err').slideUp(200);

        $('#loadEdit_' + id).css({'display': ''});

        $.ajax({
            url: "{{get_baseUrl()}}/Admin/Contact/edit/" + id,
            type: "GET",
            dataType: "JSON",

            success: function (data) {

                $('#loadEdit_' + id).css({'display': 'none'});

                $('#save').text('اضافة رصيد');

                $('#titleOfModel').text(' اضافة رصيد');

                $('#formSubmit')[0].reset();

                $('#formModel').modal();
                $('#balance').val(data.balance);
                $('#id').val(data.id);
            }
        });
    }



    function deleteFunction(id,type) {
        if (type == 2 && checkArray.length == 0) {
            alert('برجاء تحديد عناصر للحذف');
        } else if (type == 1){
            url =  "{{get_baseUrl()}}/Admin/Contact/destroy/" + id;
            deleteProccess(url);
        }else{
            url= "{{get_baseUrl()}}/Admin/Contact/destroy/" + checkArray + '?type=2';
            deleteProccess(url);
            checkArray=[];
        }
    }
</script>

{{-- Search Form --}}
<script>
    $('#seachForm').submit(function (e) {
        e.preventDefault();
        var formData = $('#seachForm').serialize();
        table.ajax.url('{{get_baseUrl()}}/Admin/Contact/allData?' + formData);
        table.ajax.reload();
        TosetV2('تمت العملية بنجاح', 'success', '', 5000);

    })
</script>


<script>
    function ChangeStatus(status,id) {
        Toset('برجاء الانتظار','info','',false);
        $.ajax({
            url : '/Admin/Contact/ChangeStatus/' +id +'?status='+status,
            type : 'get',
            success : function(data){
                $.toast().reset('all');
                table.ajax.reload();
                Toset('تمت العملية بنجاح','success','',5000);
            }
        })
    }
</script>



