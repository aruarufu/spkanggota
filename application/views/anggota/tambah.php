<div class="page-header">
    <h1>Tambah Anggota</h1>
</div>
<div class="col-md-12">
    <?php echo form_open() ?>
    <div class="row">
        <div class="errors">
            <?php
//            dump($nilaiAnggota);
//            dump($dataView);
//            foreach ($nilaiAnggota as $item => $value) {
//                echo $value->nilai;
//            }
            $errors = $this->session->flashdata('errors');
            if (isset($errors)) {
                foreach ($errors as $error) {
                    ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <?php echo $error; ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-inline">
                    <div class="form-group">
                        <label for="anggota">Nama Anggota</label>
                        <input name="anggota" type="text" class="form-control" id="anggota"
                               value="<?php echo isset($nilaiAnggota[0]->anggota) ? $nilaiAnggota[0]->anggota : ''?>"
                               placeholder="nama anggota">
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th class="col-md-3">Kriteria</th>
                    <th colspan="5" class="text-center col-md-9">Nilai</th>
                </tr>
                <?php
                foreach ($dataView as $item) {
                ?>
                <tr>
                    <td><?php echo $item['nama']; ?></td>
                    <?php
                    $no = 1;
                    foreach ($item['data'] as $dataItem) {

                        ?>
                        <td>
                            <input type="radio" name="nilai[<?php echo $dataItem->kdKriteria ?>]"
                                   value="<?php echo $dataItem->value ?>"
                                    <?php
                                    if(isset($nilaiAnggota)){
                                        foreach ($nilaiAnggota as $item => $value) {
                                            if($value->kdKriteria == $dataItem->kdKriteria){
                                                if($value->nilai ==  $dataItem->value){
                                                    ?>
                                                    checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                    }else{
                                        if($no == 3){
                                            ?>
                                            checked="checked"
                                            <?php
                                        }
                                    }
                                    ?>
                            /> <?php echo $dataItem->subKriteria;
                            $no++;
                           ?>
                        </td>

                        <?php
                    }
                    echo '</tr>';
                    }
                    ?>

            </table>
        </div>

        <div class="pull-right">
            <div class="col-md-12">
                <button class="btn btn-primary" type="submit">Save</button>
                <a class="btn btn-danger" href="<?php site_url('anggota') ?>" role="button">Batal</a>

            </div>
        </div>
    </div>
    <?php echo form_close() ?>
</div>