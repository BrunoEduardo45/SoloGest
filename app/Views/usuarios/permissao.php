<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content pt-4">
        <div class="container-fluid">
            <form id="form" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Default box -->
                        <div class="card card-outline card-primary">
                            <div class="card-body">
                                <h3><?php echo __('usuario.configurar_permissao') ?></h3>
                                <hr>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="usuario"><?php echo __('usuario.tipo_usuario') ?></label>
                                        <select class="form-control" id="usuario" name="usuario">
                                            <option value=""><?php echo __('usuario.selecione_tipo_usuario') ?></option>
                                            <?php

                                            $list = selecionarDoBanco('tipo_usuario', '*', 'tp_status = :status', [':status' => 1], []);
                                            foreach ($list as $values) {

                                            ?>
                                                <option value="<?php echo $values['tp_id'] ?>"><?php echo $values['tp_nome'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="col-lg-6">
                        <div class="card card-outline card-primary">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm w-100">
                                        <thead>
                                            <tr>
                                                <th><?php echo __('usuario.tela') ?></th>
                                                <th><?php echo __('usuario.permissao') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="row_position">
                                            <?php
                                            $result = selecionarDoBanco('tela', '*', 'tl_status = :status', [':status' => 1]);
                                            foreach ($result as $row) { ?>
                                                <tr>
                                                    <td><?php echo $row['tl_nome'] ?> </td>
                                                    <td><input type="radio" name="permissao[<?php echo $row['tl_id'] ?>]" value="1"> <?php echo __('usuario.sim') ?>
                                                        <input type="radio" name="permissao[<?php echo $row['tl_id'] ?>]" value="0"> <?php echo __('usuario.nao') ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <input type="hidden" name="acao" value="permissao">
                                <button type="submit" class="btn btn-primary"><?php echo __('usuario.salvar_permissoes') ?></button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>


<script>
    $(document).ready(function() {
        $('#usuario').change(function() {
            debugger;
            var usuario_id = $(this).val();
            $.ajax({
                url: '/obter-permissoes',
                type: 'post',
                data: {
                    usuario: usuario_id                
                },
                dataType: 'json',
                success: function(data) {
                    debugger;
                    // Atualiza a tabela de permissões com os dados obtidos
                    $.each(data, function(key, value) {
                        $('input[name="permissao[' + key + ']"][value="' + value + '"]').prop('checked', true);
                    });
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });
    });


    $("#form").submit(function(e) {
        e.preventDefault();
        Notiflix.Loading.Pulse('Carregando...');

        $.ajax({
            type: "POST",
            url: "/editar-permissao",
            data: $("#form").serialize(),
            success: function(data) {
                //debugger;
                if (data.success != "") {
                    Notiflix.Loading.Remove();
                    Notiflix.Notify.Success(data.success);
                    setTimeout(function() {
                        window.location.href = "./permissao";
                    }, 2000);
                } else {
                    Notiflix.Notify.Failure(data.error);
                    Notiflix.Loading.Remove();
                }
            },
            error: function(error) {
                // Lida com erros, se houverem
                debugger;
                console.error("Erro na requisição AJAX:", error);
            }
        });
    });
</script>