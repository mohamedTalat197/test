@include('Admin.includes.scripts.dataTableHelper')
<script>
    var table = $('#datatable').DataTable({

        bLengthChange: false,

        searching: true,

        responsive: true,

        'processing': true,

        serverSide: true,

        order: [[0, 'desc']],

        "language": {
            "search": "بحث :"
        },

        ajax: "/Admin/Rate/allData?id={{$product->id}}&type={{$type}}",

        columns:
            [
                {data: 'checkBox', name: 'checkBox'},
                {data: 'id', name: 'id'},
                {data: 'user_id', name: 'user_id'},
                {data: 'rate', name: 'rate'},
                {data: 'comment', name: 'comment'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action'},
            ]
    });
</script>


{{--Delete --}}
<script>
    function deleteFunction(id,type) {
        if (type == 2 && checkArray.length == 0) {
            alert('برجاء تحديد عناصر للحذف');
        } else if (type == 1){
            url =  "{{get_baseUrl()}}/Admin/Rate/destroy/" + id;
            deleteProccess(url);
        }else{
            url= "{{get_baseUrl()}}/Admin/Rate/destroy/" + checkArray + '?type=2';
            deleteProccess(url);
            checkArray=[];
        }
    }
</script>


{{-- Search Form --}}
<script>
    $('#seachForm').submit(function(e){
        e.preventDefault();
        var formData=$('#seachForm').serialize();
        table.ajax.url('/manage/Product/view?'+formData);
        table.ajax.reload();
        TosetV2('تمت العملية بنجاح','success','',5000);

    })
</script>

<script>
    function ChangeStatus(status,id) {
        TosetV2('{{ trans("main.proccess") }}','info','',false);
        $.ajax({
            url : '/manage/Product/ChangeStatus/' +id +'?status='+status,
            type : 'get',
            success : function(data){
                $.toast().reset('all');
                table.ajax.reload();
                TosetV2('تمت العملية بنجاح','success','',5000);
            }
        })
    }
</script>
