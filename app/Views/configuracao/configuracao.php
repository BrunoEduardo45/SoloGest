<?php

$stmt = $pdo->prepare("SELECT * FROM sistema LIMIT 1");
$stmt->execute();

$config = $stmt->fetchall(PDO::FETCH_ASSOC);
foreach ($config as $values) {
  $nomeSite       = (isset($values['sis_nome']) ? $values['sis_nome'] : "");
  $descricaoSite  = (isset($values['sis_descricao']) ? $values['sis_descricao'] : "");
  $empresa        = (isset($values['sis_empresa']) ? $values['sis_empresa'] : "");
  $versao         = (isset($values['sis_versao']) ? $values['sis_versao'] : "");
  $siteEmpresa    = (isset($values['sis_url_empresa']) ? $values['sis_url_empresa'] : "");
  $emailEmpresa   = (isset($values['sis_email']) ? $values['sis_email'] : "");
  $corPrimaria    = (isset($values['sis_cor_primaria']) ? $values['sis_cor_primaria'] : "");
  $corSecundaria  = (isset($values['sis_cor_secundaria']) ? $values['sis_cor_secundaria'] : "");
}

?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-8">
          <h1>Configuração do Sistema</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-8">
          <form id="form" method="post">
            <div class="card card-secondary">
              <div class="card-header ">
                <h3 class="card-title">Configurações</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label for="sis_nome">Nome do Sistema</label>
                      <input type="text" class="form-control" id="sis_nome" name="sis_nome" value="<?php echo $nomeSite ?>" maxlength="50" required>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="sis_descricao">Descrição</label>
                      <input type="text" class="form-control" id="sis_descricao" name="sis_descricao" value="<?php echo $descricaoSite ?>" maxlength="200" required>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="form-group">
                      <label for="sis_versao">Versão</label>
                      <input type="text" class="form-control" id="sis_versao" name="sis_versao" value="<?php echo $versao ?>" maxlength="10" required>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label for="sis_empresa">Nome da Empresa</label>
                      <input type="text" class="form-control" id="sis_empresa" name="sis_empresa" value="<?php echo $nomeEmpresa ?>" maxlength="50" required>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label for="sis_url_empresa">Site da Empresa</label>
                      <input type="link" class="form-control" id="sis_url_empresa" name="sis_url_empresa" value="<?php echo $siteEmpresa ?>" maxlength="50" required>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label for="sis_email">E-mail da Empresa</label>
                      <input type="link" class="form-control" id="sis_email" name="sis_email" value="<?php echo $emailEmpresa ?>" maxlength="50" required>
                    </div>
                  </div>
                  <div class="col-lg-6 color">
                    <label for="sis_cor_primaria">Cor Principal</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="sis_cor_primaria" name="sis_cor_primaria" value="<?php echo $corPrimaria ?>">
                      <span class="input-group-append">
                        <span class="input-group-text colorpicker-input-addon"><i></i></span>
                      </span>
                    </div>
                  </div>
                  <div class="col-lg-6 color">
                    <label for="sis_cor_secundaria">Cor Secundária</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="sis_cor_secundaria" name="sis_cor_secundaria" value="<?php echo $corSecundaria ?>">
                      <span class="input-group-append">
                        <span class="input-group-text colorpicker-input-addon"><i></i></span>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer text-right border-top">
                <input type="hidden" id="Acao" name="Acao" value="<?php echo $nomeSite != '' ? 'atualizar' : 'salvar' ?>">
                <button id="cadastrarOferta" type="submit" class="btn btn-primary my-2">Salvar Configurações <i class="fa fa-plus ml-2"></i></button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-md-4">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Imagem do Sistema</h3>
            </div>
            <div class="card-body">
              <div class="form-group m-0">
                <?php
                $stmt = $pdo->prepare("SELECT * FROM sistema");
                $stmt->execute();
                $list = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $nome = $list[0]['sis_nome'] ?? "";
                $URL = $list[0]['sis_url_logo'] ?? "";
                ?>
                <?php if ($URL != "") { ?>
                  <img class="w-100 rounded p-3" style="background-color: #343a40" src="<?php echo $baseUrl . $URL ?>" alt="<?php echo $nome ?>">
                <?php } ?>
              </div>
            </div>
            <div class="card-footer border-top">
                <form method="post">
                  <label class="btn btn-primary btn-block m-0 my-2">Upload Imagem <i class="fa fa-upload ml-2"></i>
                    <input type="file" name="image" class="image" hidden>
                  </label>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<div class="modal fade" id="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Cortar imagem</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="img-container">
          <div class="row">
            <img id="image" class="cropper-hidden" style="max-width:100%">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="crop">Cortar</button>
      </div>
    </div>
  </div>
</div>


<script>
  $(function() {
    $('.color').colorpicker({
      useAlpha: false
    });
  });

  function Dados() {
    var dados = {
      'sis_nome': $('#sis_nome').val() ?? null,
      'sis_descricao': $('#sis_descricao').val() ?? null,
      'sis_email': $('#sis_email').val() ?? null,
      'sis_empresa': $('#sis_empresa').val() ?? null,
      'sis_versao': $('#sis_versao').val() ?? null,
      'sis_url_empresa': $('#sis_url_empresa').val() ?? null,
      'sis_cor_primaria': $('#sis_cor_primaria').val() ?? null,
      'sis_cor_secundaria': $('#sis_cor_secundaria').val() ?? null,
    }
    return dados;
  }

  $("#form").submit(function(e) {
    e.preventDefault();
    Notiflix.Loading.Pulse('Carregando...');

    $.ajax({
      type: "POST",
      url: "/atualizar-configuracao",
      data: {
        dados: Dados()
      },
      success: function(data) {
        //debugger;
        if (data.success != "") {
          Notiflix.Loading.Remove();
          Notiflix.Notify.Success(data.success);
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

  $(document).ready(function() {

    var bs_modal = $('#modal');
    var image = document.getElementById('image');
    var cropper, reader, file;

    $("body").on("change", ".image", function(e) {
      var files = e.target.files;
      var done = function(url) {
        image.src = url;
        bs_modal.modal('show');
      };

      if (files && files.length > 0) {
        file = files[0];

        if (URL) {
          done(URL.createObjectURL(file));
        } else if (FileReader) {
          reader = new FileReader();
          reader.onload = function(e) {
            done(reader.result);
          };
          reader.readAsDataURL(file);
        }
      }
    });

    bs_modal.on('shown.bs.modal', function() {
      cropper = new Cropper(image, {
        // aspectRatio: 16 / 9,
        viewMode: 1,
        preview: '.preview'
      });
    }).on('hidden.bs.modal', function() {
      cropper.destroy();
      cropper = null;
    });

    $("#crop").click(function() {
      canvas = cropper.getCroppedCanvas({
        width: 230 * 2,
        height: 90 * 2,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high'
      });
      canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function() {
          var base64data = reader.result;
          Notiflix.Loading.Pulse('Carregando...');
          $.ajax({
            type: "POST",
            dataType: "json",
            url: "/atualizarimg-configuracao",
            data: {
              imagem: base64data
            },
            success: function(data) {
              $('#modal').modal('hide');
              Notiflix.Loading.Remove();
              Notiflix.Notify.Success(data.Success);
              setTimeout(function() {
                location.reload();
              }, 2000);
            },
            error: function(error) {
              $('#modal').modal('hide');
              Notiflix.Loading.Remove();
              Notiflix.Notify.Success(error.error);
              setTimeout(function() {
                location.reload();
              }, 2000);
            }
          });
        };
      });
    });
  });
</script>