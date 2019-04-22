<?php
if (!session_id())session_start();

if (empty($_SESSION['nip']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
  echo "<script>alert('Kembalilah Kejalan yg benar!!!'); window.location = 'index.php';</script>";
}
    else{
include '../system/koneksi.php';
include '../system/tgl_indo.php';
  $module="modul/mod_materi/materi_c.php?module=materi";


?>


	    <div class="page-head">
	      <h2 class="pull-left"><i class="fa fa-file-text"></i> Materi</h2> 
        <div class="bread-crumb pull-right">
          <a href="media.php?module=home"><i class="fa fa-home"></i> Home</a>
          <span class="divider">/</span> 
          <a href="media.php?module=materi" class="bread-current">Materi</a>
        </div>
        <div class="clearfix"></div>
	    </div>

	    <div class="matter">
        <div class="container">
          <div class="row">

            <div class="col-md-12">            
             <div class="widget">
                <div class="widget-head">
                  <div class="pull-left">Data Materi</div>
                  <div class="widget-icons pull-right">
                    <a href="dynamic-tables.html#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
                    <a href="dynamic-tables.html#" class="wclose"><i class="fa fa-times"></i></a>
                  </div>  
                  <div class="clearfix"></div>
                </div>
                <div class="widget-content">

                  <div class="padd">
                  <div style="padding-bottom: 10px;" align="right"><a href="#add" data-toggle="modal" class="btn btn-primary"><i class="fa fa-plus"></i> Materi</a></div>    
              <!-- Table Page -->
              <div class="page-tables">
                <!-- Table -->
                <div class="table-responsive">
                  <table cellpadding="0" cellspacing="0" border="0" id="data-table-1" width="99%">
                    <thead>
                      <tr>
                        <th><b>No</b></th>
                        <th><b>Nama Materi</b></th>
                        <th><b>Pelajaran</b></th>
                        <th><b>Kelas</b></th>
                        <th><b>File</b></th>
                        <th><b>Tipe file</b></th>
                        <th><b>Tanggal Upload</b></th>
                        <th><b>Aksi</b></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $no = 1;
                      $grnm = $_SESSION['nama']; 
                      $data = mysql_query("SELECT * FROM materi where guru_nama ='$grnm'");
                      while ($row = mysql_fetch_assoc($data)) {
                        $p = mysql_query("SELECT * FROM pelajaran where pelajaran_id='$row[pelajaran_id]'");
                        $pel = mysql_fetch_array($p);
                        
                        $k= mysql_query("SELECT * FROM kelas where kelas_id='$row[kelas_id]'");
                        $kls = mysql_fetch_array($k);
                        // print_r($row);
                       ?>
                      <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $row['nama_file']; ?></td>
                        <td><?php echo $pel['pelajaran_nama']; ?></td>
                        <td><?php echo $kls['kelas_nama']; ?></td>
                        <td><?php echo $row['file']; ?></td>
                        <td><?php echo $row['tipe_file']; ?></td>
                        <td><?php echo tanggal_indo($row['tanggal_upload'],TRUE) ?></td>

                        <td width="200px">
                          <div class="btn-group1">

                          <a href="#edit<?php echo $row[id]; ?>" data-toggle="modal"><button type="button" class="btn btn-sm btn-warning" title="Edit"><i class="fa fa-pencil"></i></button></a>

                          <a href="#hapus<?php echo $row[id]; ?>" data-toggle="modal"><button type="button" class="btn btn-sm btn-danger" title="Hapus"><i class="fa fa-trash"></i></button></a>

                          <a href="http:/elearning/image/materi/<?php echo $row[file]; ?>" download data-toggle="modal"><button type="button" class="btn btn-sm btn-download" title="Download"><i class="fa fa-download"></i></button></a>

                          

                        </div>
                        </td>
                      </tr>
                      <?php $no++; } ?>
                      
                    </tbody>
                    
                  </table>
                  <div class="clearfix"></div>
                </div>
                </div>
              </div>

          
                  </div>
                  <div class="widget-foot">
                    <!-- Footer goes here -->
                  </div>
                </div>

            </div>




            </div>
          </div>
        </div>




<!-- Tambah Data -->
    
      <div id="add" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog" style="width: 500px;">
            <div class="modal-content">
                      <div class="modal-header biru">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
                        <h4 class="title"> <i class="fa fa-plus"></i> Tambah Data Materi</h4>
                      </div>
                      <div class="modal-body">
                        <form method="POST" action="<?php echo $module; ?>&act=insert" enctype="multipart/form-data">
                     

                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4"><label>Nama Materi</label></div>
                          <div class="col-md-6">
                            <input type="text" class="form-control" name="nama" required>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4"><label>Pelajaran</label></div>
                          <div class="col-md-6">  
                            <select name="pelajaran" class="form-control selectlive" required readonly>
                            <option value="">-pilih- </option>
                            <?php
                            $id_guru = $_SESSION['id_guru']; 
                            $data = mysql_query("SELECT * FROM pelajaran,guru WHERE pelajaran.pelajaran_id=guru.pelajaran_id AND guru.guru_id='$id_guru' ");
                            while ($pljr = mysql_fetch_array($data)) { ?>
                              <option value="<?php echo $pljr['pelajaran_id']; ?>"><?php echo $pljr[pelajaran_nama]; ?></option>
                            <?php }?>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4"><label>Kelas</label></div>
                          <div class="col-md-6">  
                            <select name="kelas" class="form-control selectlive" required>
                            <option value="">-pilih- </option>
                            <?php
                            $id_guru = $_SESSION[id_guru]; 
                            $data = mysql_query("SELECT * FROM kelas ");
                            while ($pljr = mysql_fetch_array($data)) { ?>
                              <option value="<?php echo $pljr[kelas_id]; ?>"><?php echo $pljr[kelas_nama]; ?></option>
                            <?php }?>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4"><label>Uploader</label></div>
                          <div class="col-md-6"> 
                            <?php
                            $id_guru = $_SESSION[id_guru]; 
                            $data = mysql_fetch_assoc(mysql_query("SELECT guru_nama FROM guru WHERE guru_id = '$_SESSION[id_guru]' "));
                            // var_dump($data);
                            ?>
                              <input type="text" name="guru" class="form-control" readonly value="<?php echo $data[guru_nama] ?>">
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4"><label>Upload Materi</label></div>
                          <div class="col-md-6"> 
                              <input requirede type="file" name="file" accept=".pdf, .docx, .doc" />
                          </div>
                        </div>
                      </div>
                     
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                      </div>
                      </form>
                      
                    </div>
      </div>
     </div>
    <!-- End Tambah Data -->


<!-- Edit Data -->
    <?php
    $result= mysql_query("SELECT * FROM materi,pelajaran,kelas WHERE materi.pelajaran_id=pelajaran.pelajaran_id AND materi.kelas_id=kelas.kelas_id");
    while ($row= mysql_fetch_assoc($result)) {
       // echo "<pre>";
       // print_r($row);
       // echo "</pre>";
       ?>
      <div id="edit<?php echo $row[id]; ?>" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog" style="width: 500px;">
            <div class="modal-content">
                      <div class="modal-header kuning">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
                        <h4 class="title"><i class="fa fa-pencil"></i> Edit Data Materi</h4>
                      </div>
                      <div class="modal-body">
                        <form method="POST" action="<?php echo $module; ?>&act=update"  enctype="multipart/form-data">
                      

                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4"><label>Nama Materi</label></div>
                          <div class="col-md-6">
                            <input type="hidden" name="id" value="<?php echo $row[id]; ?>">
                            <input type="text" class="form-control" name="nama" value="<?php echo $row[nama_file]?>" required>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4"><label>Pelajaran</label></div>
                          <div class="col-md-6">  
                            <select name="pelajaran" class="form-control selectlive" required>
                            <option value="">-pilih- </option>
                            <?php
                            $id_guru = $_SESSION[id_guru]; 
                            $data = mysql_query("SELECT * FROM pelajaran,materi WHERE pelajaran.pelajaran_id=materi.pelajaran_id AND materi.id='$row[id]' ");
                            while ($pljr = mysql_fetch_array($data)) { ?>
                              <option selected value="<?php echo $pljr[pelajaran_id]; ?>"><?php echo $pljr[pelajaran_nama]; ?></option>
                            <?php }?>
                            </select>
                          </div>
                        </div>
                      </div>


                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4"><label>Kelas</label></div>
                          <div class="col-md-6">  
                            <select name="kelas" class="form-control selectlive" required>
                            <option value="">-pilih- </option>
                              <option selected value="<?php echo $row[kelas_id]; ?>"><?php echo $row[kelas_nama]; ?></option>
                            <?php
                            $id_guru = $_SESSION[id_guru]; 
                            $data = mysql_query("SELECT * FROM kelas WHERE NOT kelas_id='$row[kelas_id]'");
                            while ($pljr = mysql_fetch_array($data)) { ?>
                              <option value="<?php echo $pljr[kelas_id]; ?>"><?php echo $pljr[kelas_nama]; ?></option>
                            <?php }?>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4"><label>Uploader</label></div>
                          <div class="col-md-6"> 
                            <?php
                            $id_guru = $_SESSION[id_guru]; 
                            $data = mysql_fetch_assoc(mysql_query("SELECT guru_nama FROM guru WHERE guru_id = '$_SESSION[id_guru]' "));
                            // var_dump($data);
                            ?>
                              <input type="text" name="guru" class="form-control" readonly value="<?php echo $data[guru_nama] ?>">
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-4"><label>Upload Materi</label></div>
                          <div class="col-md-6"> 
                              <input type="file" name="file" accept=".pdf, .docx, .doc" />
                          </div>
                        </div>
                      </div>
                     
                      
                      </div>
                       <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Batal</button>
                        <button type="submit" class="btn btn-warning">Update</button>
                      </div>
                      </form>
                    </div>
      </div>
     </div>
       <?php
    }           
            
    ?>    
    <!-- End Edit Data -->


<!-- Blokir Data -->
    <?php 
                      
                      $data = mysql_query("SELECT * FROM materi ");
                      while ($row = mysql_fetch_array($data)) {                      
    ?>    
      <div id="hapus<?php echo $row[id]; ?>" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog" style="width: 500px;">
            <div class="modal-content">
                      <div class="modal-header merah">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
                        <h4 class="title"><i class="fa fa-trash"></i> Hapus Data Materi</h4>
                      </div>
                      <div class="modal-body">
                      
                      <form method="POST" action="<?php echo $module; ?>&act=delete">
                      
                      <div class="alert alert-danger">
                      <h4><i class="icon fa fa-ban"></i> <b>Peringatan!</b></h4>
                      Apakah Anda ingin menghapus data materi <b><?php echo $row[nama_file]; ?></b>?
                      </div>

                      <input type="hidden" name="id" value="<?php echo $row[id]; ?>">


                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Batal</button>
                        <button type="submit" class="btn btn-danger"> <i class="fa fa-trash"></i> Hapus</button>

                      </div>
                      </form> 
                    </div>
      </div>
     </div>
     <?php } ?>
    <!-- End Blokir Data -->
        <?php } ?>  