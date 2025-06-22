<?php

$userData = selecionarDoBanco("usuarios", "*", "usu_id =" . $IdUser, [], ["inner join tipo_usuario on tp_id = usu_nivel"])[0];

?>

<div class="content-wrapper">
    <section class="content pt-4">
        <div class="container-fluid">
            <form id="formUsu" method="post">
                <div class="row">
                    <div class="col-md-9">
                        <div class="card card-outline card-primary">
                            <div class="card-body">
                                <h3>Dados do Usuário</h3>
                                <hr>
                                <div class="row">
                                    <input type="hidden" id="id" name="id" value="<?php echo $IdUser ?>" />
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="nome">Nome</label>
                                            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $userData['usu_nome'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="email">E-mail</label>
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $userData['usu_email'] ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="celular">Celular</label>
                                            <input type="text" class="form-control" id="celular" name="celular" value="<?php echo $userData['usu_celular'] ?>" placeholder="<?php echo $pais == 1 ? '(99) 99999-9999' : '(999) 999-9999' ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="sexo">Sexo</label>
                                            <select class="form-control" id="sexo" name="sexo">
                                                <option value="masculino" <?php echo ($userData['usu_sexo'] == 'masculino') ? "selected" : ""; ?>>Masculino</option>
                                                <option value="feminino" <?php echo ($userData['usu_sexo'] == 'feminino') ? "selected" : ""; ?>>Feminino</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="tipo">Tipo de Usuário</label>
                                            <input type="text" class="form-control" id="tipo" name="tipo" value="<?php echo $userData['tp_nome'] ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="senha">Senha</label>
                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control" id="senha" name="senha" value="">
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary" type="button" onclick="toggleSenha()"><i class="far fa-eye"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <input type="hidden" id="Acao" name="Acao" value="atualizar">
                                <button type="submit" class="btn btn-primary my-2">Salvar <i class="fa fa-save ml-2"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h5 for="cadastro" class="m-0">Imagem de Perfil</h5>
                            </div>
                            <div class="card-body pt-0">
                                <input type="hidden" id="imagemNome" name="imagemNome" value="<?php echo $userData['usu_imagem_nome'] ?>">
                                <input type="hidden" id="dadosImagem" name="dadosImagem" value="">
                                <img src="" id="imagemPreview" name="imagemPreview" class="img-fluid w-100 rounded-circle">
                                <img src="<?php echo $userData['usu_imagem_url'] ?>" id="imagemBanco" class="img-fluid w-100 rounded-circle">
                            </div>
                            <div class="card-footer">
                                <label class="btn btn-primary btn-block">Upload <i class="fa fa-upload ml-2"></i>
                                    <input type="file" id="imagem" name="image" class="image" hidden>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<!-- Modal de Corte de Imagem -->
<div class="modal fade" id="modalImagem" tabindex="-1" role="dialog" aria-labelledby="modalImagemLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImagemLabel">Cortar Imagem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="image" src="" alt="Imagem para Cortar" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" id="crop" class="btn btn-primary">Cortar</button>
            </div>
        </div>
    </div>
</div>


<script>
    function toggleSenha() {
        var senhaInput = document.getElementById("senha");
        if (senhaInput.type === "password") {
            senhaInput.type = "text";
        } else {
            senhaInput.type = "password";
        }
    }

    $(document).ready(function() {
        $("#celular").inputmask("(99) 99999-9999");
        $("#telefone").inputmask("(99) 9999-9999");
    });

    $(document).ready(function() {

        var bs_modal = $('#modalImagem');
        var image = document.getElementById('image');
        var cropper, reader, file;

        $("body").on("change", ".image", function(e) {
            var files = e.target.files;
            var done = function(url) {
                image.src = url;
                bs_modal.modal('show');
            };

            if (files && files.length > 0) {
                var file = files[0];

                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        bs_modal.on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: 1 / 1,
                viewMode: 1,
                preview: '.preview',
                responsive: true,
                autoCropArea: 0.65
            });
        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
        });


        $("#crop").click(function() {
            var canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 400,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high'
            });

            canvas.toBlob(function(blob) {
                var url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result;

                    $("#imagemPreview").attr("src", base64data);
                    $("#dadosImagem").val(base64data);
                    $("#imagemBanco").addClass("d-none");

                    $.ajax({
                        type: "POST",
                        url: "/imagem-perfil",
                        data: {
                            'dadosImagem': base64data,
                            'id': $("#id").val()
                        },
                        success: function(data) {
                            if (data.acao == 'ok') {
                                Notiflix.Loading.Remove();
                                Notiflix.Notify.Success('Imagem atualizada com sucesso!');
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
                };
            });
        });
    });

    $("#formUsu").submit(function(e) {
        e.preventDefault();
        Notiflix.Loading.Pulse('Carregando...');

        $.ajax({
            type: "POST",
            url: "/atualizar-usuario",
            data: new FormData($("#formUsu")[0]),
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.acao == 'ok') {
                    Notiflix.Loading.Remove();
                    Notiflix.Notify.Success('Usuário atualizado com Sucesso!');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    Notiflix.Notify.Failure(data.msg);
                    Notiflix.Loading.Remove();
                }
            },
            error: function(error) {
                debugger;
                console.error("Erro na requisição AJAX:", error);
            }
        });
    });
</script>