<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <form id="formGrupo" method="post">
                        <div class="card-body">
                            <h3>Cadastro de Produtores nos Grupos</h3>
                            <hr>

                            <!-- Formulário de Cadastro de Produtor -->
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="grupo">Grupo</label>
                                        <select name="grupo" id="grupo" class="form-control" required>
                                            <option value="">Selecione o Grupo</option>
                                            <?php
                                            $grupos = selecionarDoBanco('grupos', 'gru_id, gru_nome', '', []);
                                            foreach ($grupos as $grupo) { ?>
                                                <option value="<?php echo $grupo['gru_id']; ?>"><?php echo $grupo['gru_nome']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="responsavel">Produtor</label>
                                        <select name="responsavel" id="responsavel" class="form-control" required>
                                            <option value="">Selecione o Responsável</option>
                                            <?php
                                            $usuarios = selecionarDoBanco('usuarios', 'usu_id, usu_nome', 'usu_nivel = 3', []);
                                            foreach ($usuarios as $usuario) { ?>
                                                <option value="<?php echo $usuario['usu_id']; ?>"><?php echo $usuario['usu_nome']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group mt-2">
                                        <label class="form-label" for="cadastro"></label>
                                        <button type="submit" id="cadastro" name="cadastro" class="btn btn-primary btn-block" data-acao="salvar">Cadastrar <i class="fa fa-plus ml-2"></i></button>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group mt-2">
                                        <label class="form-label" for="limpar"></label>
                                        <button type="reset" id="limpar" name="limpar" class="btn btn-warning btn-block">Limpar<i class="fa fa-eraser ml-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de Produtores -->
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <h3>Produtores Cadastrados</h3>
                        <div class="col-lg-12 p-0 ">
                            <div class="form-group mt-4">
                                <select name="grupoprodutores" id="grupoprodutores" class="form-control" required>
                                    <option value="">Selecione o Grupo</option>
                                    <?php
                                    $grupos = selecionarDoBanco('grupos', 'gru_id, gru_nome', '', []);
                                    foreach ($grupos as $grupo) { ?>
                                        <option value="<?php echo $grupo['gru_id']; ?>"><?php echo $grupo['gru_nome']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div id="produtoresList"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {

        $("#formGrupo").submit(function(e) {
            e.preventDefault();
            Notiflix.Loading.Pulse('Carregando...');
            var acao = $('#cadastro').data('acao');
            var url = acao === "salvar" ? "/cadastrar-produtor" : "/atualizar-produtor";

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    dados: Dados()
                },
                success: function(data) {
                    if (data.success != '' && acao == "salvar") {
                        Notiflix.Loading.Remove();
                        Notiflix.Notify.Success('Produtor cadastrado com Sucesso!');
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else if (data.success != '' && acao != "salvar") {
                        Notiflix.Loading.Remove();
                        Notiflix.Notify.Success('Produtor atualizado com Sucesso!');
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        Notiflix.Notify.Failure(data.msg);
                        Notiflix.Loading.Remove();
                    }
                },
                error: function(error) {
                    console.error("Erro na requisição AJAX:", error);
                }
            });
        });

        $('#grupoprodutores').on('change', function() {
            let grupoId = $(this).val();

            if (!grupoId) {
                $('#produtoresList').html('');
                return;
            } else {
                $.ajax({
                    type: "POST",
                    url: "/listar-produtores",
                    data: {
                        'grupo_id': grupoId
                    },
                    success: function(data) {
                        var html = '';
                        debugger;
                        if (data != '' && data.length > 0) {
                            html += '<table id="table" class="table table-hover table-sm w-100">';
                            html += '<thead><tr><th class="text-left">ID</th><th>Nome</th><th class="text-left">CPF/CNPJ</th><th>Estado e Cidade</th><th>Celular</th><th>Ações</th></tr></thead><tbody>';
                            data.forEach(function(produtor) {
                                html += `<tr>
                                        <td class="text-left">${produtor.usu_id}</td>
                                        <td class="text-left">${produtor.usu_nome}</td>
                                        <td class="text-left">${produtor.usu_cpf_cnpj}</td>
                                        <td class="text-left">${produtor.usu_estado} - ${produtor.usu_cidade}</td>
                                        <td class="text-left">${produtor.usu_celular}</td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm remover-produtor" onClick="RemoverProdutor(${produtor.usu_id})"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>`;
                            });
                            html += '</tbody></table>';

                        } else {
                            html = '<p class="w-100 text-center mt-4 mb-2">Nenhum produtor encontrado para este grupo.</p>';
                        }
                        $('#produtoresList').html(html);

                        $('#table').DataTable({
                            language: {
                                url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json"
                            }
                        });

                        $('td.text-left').each(function() {
                            var texto = $(this).text();

                            if (texto.length <= 14) {
                                $(this).text(formatarCpfCnpj(texto, 'cpf'));
                            } else {
                                $(this).text(formatarCpfCnpj(texto, 'cnpj'));
                            }
                        });
                    },
                    error: function(error) {
                        console.error("Erro na requisição AJAX:", error);
                    }
                });
            }
        });

    });

    function formatarCpfCnpj(valor, tipo) {
        if (tipo === 'cpf') {
            return valor.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})$/, "$1.$2.$3-$4");
        } else if (tipo === 'cnpj') {
            return valor.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, "$1.$2.$3/$4-$5");
        }
        return valor;
    }

    function Dados() {
        return {
            prod_grupo_id: $('#grupo').val(),
            prod_usu_id: $('#responsavel').val()
        }
    }

    function RemoverProdutor(produtorId) {
        var grupoId = $('#grupoprodutores').val();

        Notiflix.Confirm.Show(
            'Confirmação',
            'Tem certeza que deseja remover este produtor do grupo?',
            'Sim',
            'Não',
            function() {
                Notiflix.Loading.Pulse('Removendo produtor...');
                $.ajax({
                    type: "POST",
                    url: "/removerprodutor-grupo",
                    data: {
                        'produtor_id': produtorId,
                        'grupo_id': grupoId
                    },
                    success: function(data) {
                        Notiflix.Loading.Remove();

                        if (data.success != "") {
                            Notiflix.Notify.Success('Produtor removido com sucesso!');
                            $('#grupoprodutores').trigger('change');
                        } else {
                            Notiflix.Notify.Failure('Erro ao remover produtor!');
                        }
                    },
                    error: function(error) {
                        Notiflix.Loading.Remove();
                        console.error("Erro na requisição AJAX:", error);
                        Notiflix.Notify.Failure('Ocorreu um erro ao tentar remover o produtor.');
                    }
                });
            },
            function() {}
        );
    };
</script>