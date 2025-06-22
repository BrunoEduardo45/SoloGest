<footer class="main-footer text-sm">
  <strong>Copyright &copy; <a href="<?php echo $siteEmpresa ?>"><?php echo $nomeEmpresa ?></a>.</strong>
  Todos os direitos reservados. <div class="float-right d-none d-sm-inline-block">
    <b>Versão</b> <?php echo $versao ?>
  </div>
</footer>


</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- jQuery UI (depende de jQuery) -->
<script src="<?php echo $baseUrl ?>/app/public/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- Popper.js (necessário para Bootstrap 4) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>


<!-- Outros Plugins (dependem de jQuery ou Bootstrap) -->
<script src="<?php echo $baseUrl ?>app/public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/chart.js/Chart.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/notiflix/notiflix-aio-2.7.0.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/icons/js/bootstrap-iconpicker.bundle.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/cropper/cropper.min.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/inputmask/jquery.inputmask.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/js/bootstrap-colorpicker.min.js"></script>

<!-- DataTables e Extensões -->
<script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<!-- FontAwesome -->
<script src="<?php echo $baseUrl ?>app/public/plugins/fontawesome-free/script/c337de081b.js"></script>

<!-- Tour Plugins -->
<script src="<?php echo $baseUrl ?>app/public/plugins/kinetic/kinetic.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/tour/jquery.enjoyhint.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<!-- AdminLTE e Scripts Personalizados -->
<script src="<?php echo $baseUrl ?>app/public/js/adminlte.js"></script>
<script src="<?php echo $baseUrl ?>app/public/js/main.js"></script>

<!-- Firebase -->
<script src="https://www.gstatic.com/firebasejs/10.5.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.5.0/firebase-messaging-compat.js"></script>

<!-- Quill e Summernote -->
<script src="<?php echo $baseUrl ?>app/public/plugins/summernote/summernote-bs4.js"></script>
<script src="<?php echo $baseUrl ?>app/public/plugins/summernote/lang/summernote-pt-BR.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script src="<?php echo $baseUrl ?>app/public/js/adminlte.js"></script>
<script src="<?php echo $baseUrl ?>app/public/js/main.js"></script>

<script> 
     $(document).ready(function() {
        const corPrimaria = '<?php echo $corPrimaria; ?>';
    
        Notiflix.Confirm.Init({
            titleColor: corPrimaria,
            okButtonBackground: corPrimaria,
            okButtonColor: '#fff',
            cancelButtonBackground: '#ccc',
            cancelButtonColor: '#000'
        });
    });
</script>

<script>
  $(document).ready(function() {

    const body = document.body;

    if (body.firstChild && body.firstChild.nodeType === 3) {
      const conteudo = body.firstChild.nodeValue.trim();

      if (conteudo === "0") {
        body.removeChild(body.firstChild);
        console.log("Zero removido do topo da página");
      }
    }

    $(".nav-item.has-treeview > a").on("click", function(e) {
      let $menuItem = $(this).parent();
      let $submenu = $menuItem.children(".menu-open");
      let $icon = $(this).find(".right");

      if ($menuItem.hasClass("menu-open")) {
        $menuItem.removeClass("menu-open");
        $icon.removeClass("rotate-icon");
      } else {
        $menuItem.addClass("menu-open");
        $icon.addClass("rotate-icon");
      }

      e.preventDefault();
    });
  });

  $(document).ready(function() {

    $.widget.bridge('uibutton', $.ui.button)

    $('#btnGroupDrop1').dropdown('toggle');

    $('[data-widget="pushmenu"]').on('click', function(e) {
      e.preventDefault();
      $('body').toggleClass('sidebar-collapse');
    });


    if ($.fn.inputmask) {
      $(".celular").inputmask("(99) 99999-9999");
      $(".telefone").inputmask("(99) 9999-9999");
      $(".cpf").inputmask("999.999.999-99");
      $(".cnpj").inputmask("99.999.999/9999-9")
      $('.cpf_cnpj').inputmask({
            mask: ['999.999.999-99', '99.999.999/9999-99'],
            keepStatic: true
        });
    }

  });

  if ('Notification' in window) {
    Notification.requestPermission().then(function(permission) {
      if (permission === 'granted') {
        // Permissão concedida, você pode enviar notificações
      } else if (permission === 'denied') {
        // Permissão negada, exibir um modal

        // Pede permissão ao usuário para enviar notificações
        Notification.requestPermission().then(function(permission) {
          if (permission === 'granted') {
            console.log('Permissão para notificações concedida!');
          }
        });
      }
      //alert(permission);
    });
  }

  const firebaseConfig = {
    apiKey: "AIzaSyCSMBHclVlQnUwNdM6zpxAcnvfhoBg1g2E",
    authDomain: "push-fielapp.firebaseapp.com",
    projectId: "push-fielapp",
    storageBucket: "push-fielapp.appspot.com",
    messagingSenderId: "787353718327",
    appId: "1:787353718327:web:c0a74242123aa4774579b2"
  };

  const app = firebase.initializeApp(firebaseConfig)
  const messaging = firebase.messaging()
  messaging.getToken({
    vapidKey: "BJz8S8AcRcxRsBjlYy44G_inNRe4Kq1cMtytK2jPj7WwTSqWUMpwE_ZrvWWy7On1ou8PpZoBuqR-wTvD0fvMZrA"
  }).then((currentToken) => {
    if (currentToken) {
      console.log(currentToken);
      sendTokenToServer(currentToken)
    } else {
      setTokenSentToServer(false);
    }
  }).catch((err) => {
    console.log(err);
    setTokenSentToServer(false);
  });

  function sendTokenToServer(currentToken) {

    if (!isTokenSentToServer()) {
      console.log('Enviando token para o servidor...')

      $.ajax({
        url: '/adicionar-token',
        type: 'POST',
        data: {
          token: currentToken,
          id: <?php echo $IdUser ?>,
          Acao: 'token'
        },
        success: function(response) {
          console.log('Token enviado com sucesso para o servidor');
          setTokenSentToServer(true);
        },
        error: function(error) {
          console.error('Erro ao enviar token para o servidor', error);
        }
      });
      setTokenSentToServer(true)
    } else {
      console.log("Token já disponível no servidor");
      $.ajax({
        url: '/adicionar-token',
        type: 'POST',
        data: {
          token: currentToken,
          id: <?php echo $IdUser ?>,
          Acao: 'token'
        },
        success: function(response) {
          console.log('Token enviado com sucesso para o servidor');
          setTokenSentToServer(true);
        },
        error: function(error) {
          console.error('Erro ao enviar token para o servidor', error);
        }
      });
    }
  };

  function isTokenSentToServer() {
    return window.localStorage.getItem('sentToServer') === '1'
  };

  function setTokenSentToServer(sent) {
    window.localStorage.setItem('sentToServer', sent ? '1' : '0')
  }

  function modalQRCode() {
    $('#modalQRCode').modal('toggle');
    return false;
  };


  $(document).ready(function() {

    $(function() {
      $('[data-toggle="tooltip"]').tooltip();
      $('[data-toggle="popover"]').popover();
    })

    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('busca');

    var table = $('#table').DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json"
      }
    });

    if (status) {
      table.search(status).draw();
    }

  });

  var toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
  var currentTheme = localStorage.getItem('theme');
  var mainHeader = document.querySelector('.main-header');

  if (currentTheme) {
    if (currentTheme === 'dark') {
      if (!document.body.classList.contains('dark-mode')) {
        document.body.classList.add("dark-mode");
      }
      if (mainHeader.classList.contains('navbar-light')) {
        mainHeader.classList.add('navbar-dark');
        mainHeader.classList.remove('navbar-light');
      }
      toggleSwitch.checked = true;
    }
  };

  function switchTheme(e) {
    if (e.target.checked) {
      if (!document.body.classList.contains('dark-mode')) {
        document.body.classList.add("dark-mode");
      }
      if (mainHeader.classList.contains('navbar-light')) {
        mainHeader.classList.add('navbar-dark');
        mainHeader.classList.remove('navbar-light');
      }
      localStorage.setItem('theme', 'dark');
    } else {
      if (document.body.classList.contains('dark-mode')) {
        document.body.classList.remove("dark-mode");
      }
      if (mainHeader.classList.contains('navbar-dark')) {
        mainHeader.classList.add('navbar-light');
        mainHeader.classList.remove('navbar-dark');
      }
      localStorage.setItem('theme', 'light');
    }
  };

  $(document).ready(function() {
    toggleSwitch.addEventListener('change', switchTheme, false);
  });
</script>

</body>

</html>