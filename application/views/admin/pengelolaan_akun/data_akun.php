<table id="pengelolaan_akun" class="table table-bordered table-striped">
    <thead>
        <tr>
                        <th>ID</th>
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Level</th>
                        <th>Aksi</th>
                    </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php foreach($admin->result() as $result) : ?>
        <tr>
        <td><?php echo $result->id ?></td>
            <td><?php echo $no++ ?></td>
            <td><?php echo $result->nama ?></td>
            <td><?php echo $result->username ?></td>
            <td><?php echo $result->password ?></td>
            <td><?php echo $result->level ?></td>
            <td class="text-center">
                <i class="btn btn-xs btn-primary fa fa-edit edit-data" data-id="<?php echo $result->id ?>" data-placement="top" title="Edit"></i>
                <i class="btn btn-xs btn-danger fas fa-trash-alt hapus-data" data-id="<?php echo $result->id ?>" data-placement="top" title="Delete"></i>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
      <div class="modal fade" id="modal-edit">
          <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Data admin</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="form-edit-pengelolaan_akun">
            <input type="hidden" name="id"/>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" autocomplete="off" name="nama" placeholder="Masukkan Nama admin">
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" autocomplete="off" name="username" placeholder="Masukkan Username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" class="form-control" autocomplete="off" name="password" placeholder="Masukkan Password">
                </div>
                <div class="form-group">
                <select class="form-control select2" name="level" style="width: 100%;">
                    <option value="kabiro">Kabiro</option>
                    <option value="staff">Staff</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
      </div>
        <!-- /.modal-dialog -->
      </div>

<script>
  //Menampilkan data diedit
    modal_edit = $("#modal-edit");
    $(".edit-data").click(function(e) {
      id = $(this).data('id');
      $.ajax({
        url: '<?=site_url('pengelolaan_akun/get_by_id')?>',
        type: 'GET',
        dataType: 'json',
        data: {id: id},
      })
      .done(function(data) {
        $("#form-edit-pengelolaan_akun input[name='id']").val(data.object.id);
        $("#form-edit-pengelolaan_akun input[name='nama']").val(data.object.nama);
        $("#form-edit-pengelolaan_akun input[name='username']").val(data.object.username);
        $("#form-edit-pengelolaan_akun input[name='password']").val(data.object.password);
        $("#form-edit-pengelolaan_akun input[name='level']").val(data.object.level);
        modal_edit.modal('show').on('shown.bs.modal', function(e) {
          $("#form-edit-pengelolaan_akun input[name='id']").focus();
        });
      });
    });
    //Proses Update ke Db
    $("#form-edit-pengelolaan_akun").submit(function(e) {
    e.preventDefault();
    form = $(this);
    $.ajax({
      url: '<?=site_url('pengelolaan_akun/crud/update')?>',
      type: 'POST',
      dataType: 'json',
      data: form.serialize(),
      success: function(data){ 
        form[0].reset();
        alert('success!');
        modal_edit.modal('hide');
        $('#pengelolaan_akun').DataTable().clear().destroy();
        refresh_table();
      },
      error: function(response){
          alert(response);
      }
     })
    });
    $(".hapus-data").click(function(e) {
      e.preventDefault();
      id = $(this).data('id');
      if (confirm("Anda yakin menghapus data ini?")) {
        $.ajax({
          url: '<?=site_url('pengelolaan_akun/crud/delete')?>',
          type: 'POST',
          dataType: 'json',
          data: {id: id},
          success: function(data){ 
          $('#pengelolaan_akun').DataTable().clear().destroy();
          refresh_table();
          },
          error: function(response){
          alert(response);
          }
        })
      }
    });
    
</script>