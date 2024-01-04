{{-- Akhir Modal Add  --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

{{-- jquery  --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- yajra  --}}
<script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>



<script>
    let table = new DataTable('#myTable',{
        processing:true,
        serverside:true,
        ajax:"{{ url('pegawaiAjax') }}",
        columns:[{
            data:'DT_RowIndex',
            name:'DT_RowIndex',
            orderable:false,
            searchable:false
        },{  
            data:'nama',
            name:'Nama'
        },{
            data:'email',
            name:'Email'
        },{
            data:'aksi',
            name:'Aksi'
        }]
    });


    // GLOBAL SETUP
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });
    // Tambah Data Modal
    $('body').on('click','.tombol-tambah',function(e){
        e.preventDefault();
        $('#modalTambah').modal('show');

        //Tombol Simpan
        $('.tombol-simpan').click(function(){
            simpan();
        });
    });


    //EDIT
    $('body').on('click','.tombol-edit',function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            url:'pegawaiAjax/'+id+'/edit',
            type:'GET',
            success:function(response){
                $('#modalTambah').modal('show');
                $('#nama').val(response.result.nama);
                $('#email').val(response.result.email);
                
                console.log(response.result);

                //Tombol Simpan
            $('.tombol-simpan').click(function(){
                simpan(id);
            });
            }
        });
    });

    //DELETE
    $('body').on('click','.tombol-del',function(e){
     e.preventDefault();
        if(confirm('Hapus Data ?') == true){
            var id = $(this).data('id');
            $.ajax({
                url: 'pegawaiAjax/'+id,
                type:'DELETE',

            });
            $('#myTable').DataTable().ajax.reload();
        }
    });


    //KHUSUS SIMPAN
    function simpan(id=''){
        if(id == ''){
            //Tambah Data
            var var_url = 'pegawaiAjax';
            var var_type = 'POST';

        }else{
            //Edit Data
            var var_url = 'pegawaiAjax/'+id;
            var var_type = 'PUT';
        }
        $.ajax({
                url:var_url,
                type:var_type,
                data:{
                    nama : $('#nama').val(),
                    email : $('#email').val()
                },
                success: function(response){
                    if(response.errors){
                        console.log(response);
                        $('.alert-danger').removeClass('d-none');
                        $('.alert-danger').append("<ul>");
                        $.each(response.errors,function(key,value){
                            $('.alert-danger').find('ul').append("<li>"+value+"</li>");
                        });
                        $('.alert-danger').append("</ul>");
                    }else{
                        $('.alert-success').removeClass('d-none');
                        $('.alert-success').html(response.success);
                    }
                    $('#myTable').DataTable().ajax.reload();
                }

            });
    }


    //CLEAR CACHE INPUT
    $('#modalTambah').on('hidden.bs.modal',function(){
        $('#nama').val('');
        $('#email').val('');

        $('.alert-danger').addClass('d-none');
        $('.alert-danger').html('');

        $('.alert-success').addClass('d-none');
        $('.alert-success').html('');
        
    });

</script>