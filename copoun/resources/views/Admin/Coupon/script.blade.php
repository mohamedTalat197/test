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

        order: [],

        buttons: ['copy', 'excel', 'pdf'],

        ajax: "{{ route('Coupon.allData',['user_id'=>$user_id])}}",

        columns: [
            {data: 'checkBox', name: 'checkBox'},
            {data: 'id', name: 'id'},
            {data: 'storeLogo', name: 'storeLogo'},
            {data: 'storeName', name: 'storeName'},
            {data: 'name', name: 'name'},
            {data: 'cat_id', name: 'cat_id'},
            {data: 'status', name: 'status'},
            {data: 'activeCount', name: 'activeCount'},
            {data: 'unActiveCount', name: 'unActiveCount'},
            {data: 'endDate', name: 'endDate'},
            {data: 'rate', name: 'rate'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#formSubmit').submit(function (e) {
        e.preventDefault();
        saveOrUpdate( save_method == 'add' ?"{{ route('Coupon.create') }}" : "{{ route('Coupon.update') }}");
    });


    function editFunction(id) {

        save_method = 'edit';

        $('#err').slideUp(200);

        $('#loadEdit_' + id).css({'display': ''});

        $.ajax({
            url: "{{get_baseUrl()}}/Admin/Coupon/edit/" + id,
            type: "GET",
            dataType: "JSON",

            success: function (data) {

                $('#loadEdit_' + id).css({'display': 'none'});

                $('#save').text('تعديل');

                $('#titleOfModel').text(' تعديل');

                $('#formSubmit')[0].reset();

                $('#formModel').modal();

                $('#name').val(data.name);
                $('#storeName').val(data.storeName);
                $('#code').val(data.code);
                $('#link').val(data.link);
                $('#cat_id').val(data.cat_id);
                $('#country_id').val(data.country_id);
                $('#description').val(data.description);
                $('#isSpecial').val(data.isSpecial);
                $('#endDate').val(data.endDate);
                $('#id').val(data.id);
            }
        });
    }

    function deleteFunction(id,type) {
        if (type == 2 && checkArray.length == 0) {
            alert('برجاء تحديد عناصر للحذف');
        } else if (type == 1){
            url =  "{{get_baseUrl()}}/Admin/Coupon/destroy/" + id;
            deleteProccess(url);
        }else{
            url= "{{get_baseUrl()}}/Admin/Coupon/destroy/" + checkArray + '?type=2';
            deleteProccess(url);
            checkArray=[];
        }
    }


</script>

<script>
    function ChangeStatus(status,id) {
        Toset('طلبك قيد التنفيذ','info','',false);
        $.ajax({
            url : '{{get_baseUrl()}}/Admin/Coupon/ChangeStatus/' +id +'?status='+status,
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
        table.ajax.url('{{get_baseUrl()}}/Admin/Coupon/allData?' + formData);
        table.ajax.reload();
        TosetV2('تمت العملية بنجاح', 'success', '', 5000);

    })
</script>

<script>
    function ChangeStatus(status,id) {
        Toset('{{trans('dash.request_process')}}','info','',false);
        $.ajax({
            url : '/Admin/Coupon/ChangeStatus/' +id +'?status='+status,
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
            url : '/Admin/Coupon/edit/' +id,
            type : 'get',
            success : function(data){
                var link= '<a target="_blank" href="'+data.link+'">اضغط هنا</a>'
                $('#codeS').text(data.code);
                $('#nameS').text(data.name);
                $('#storeNameS').text(data.storeName);
                $('#created_at').text(data.created_at);
                $('#country_idS').text(data.country_name);
                $('#cat_idS').text(data.cat_name);
                $('#emailS').text(data.email);
                $('#dateOfBirthS').text(data.dateOfBirth);
                $('#user_idS').text(data.user_name);
                $('#linkS').append(link);
                $('#idS').text(id);
                $('#unActiveCount').text(data.unActiveCount ? data.unActiveCount : 0);
                $('#activeCount').text(data.activeCount ? data.activeCount : 0);
                $('#loadShow_'+id).css({'display' : 'none'});
                $('#showData').modal();
                $.toast().reset('all');
            }
        })
    }
</script>

<script>
    $('#seachForm').submit(function(e){
        e.preventDefault();
        var formData=$('#seachForm').serialize();
        table.ajax.url('/Admin/Coupon/allData?'+formData);
        table.ajax.reload();
        Toset('تمت العملية بنجاح','success','',5000);

    });


</script>


