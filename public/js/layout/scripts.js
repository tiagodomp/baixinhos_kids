
(function($) {
    "use strict";

    /*================================
    Preloader
    ==================================*/

    var preloader = $('#preloader');
    $(window).on('load', function() {
        preloader.fadeOut('slow', function() { $(this).remove(); });
    });

    /*================================
    sidebar collapsing
    ==================================*/
    $('.nav-btn').on('click', function() {
        $('.page-container').toggleClass('sbar_collapsed');
    });

    /*================================
    Start Footer resizer
    ==================================*/
    var e = function() {
        var e = (window.innerHeight > 0 ? window.innerHeight : this.screen.height) - 5;
        (e -= 67) < 1 && (e = 1), e > 67 && $(".main-content").css("min-height", e + "px")
    };
    $(window).ready(e), $(window).on("resize", e);

    /*================================
    sidebar menu
    ==================================*/
    $("#menu").metisMenu();

    /*================================
    slimscroll activation
    ==================================*/
    $('.menu-inner').slimScroll({
        height: 'auto'
    });
    $('.nofity-list').slimScroll({
        height: '435px'
    });
    $('.timeline-area').slimScroll({
        height: '500px'
    });
    $('.recent-activity').slimScroll({
        height: 'calc(100vh - 114px)'
    });
    $('.settings-list').slimScroll({
        height: 'calc(100vh - 158px)'
    });

    /*================================
    stickey Header
    ==================================*/
    $(window).on('scroll', function() {
        var scroll = $(window).scrollTop(),
            mainHeader = $('#sticky-header'),
            mainHeaderHeight = mainHeader.innerHeight();

        // console.log(mainHeader.innerHeight());
        if (scroll > 1) {
            $("#sticky-header").addClass("sticky-menu");
        } else {
            $("#sticky-header").removeClass("sticky-menu");
        }
    });

    /*================================
    form bootstrap validation
    ==================================*/
    $('[data-toggle="popover"]').popover()

    /*------------- Start form Validation -------------*/
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);

    /*================================
    datatable active
    ==================================*/
    if ($('#dataTable').length) {
        $('#dataTable').DataTable({
            responsive: true
        });
    }
    if ($('#dataTable2').length) {
        $('#dataTable2').DataTable({
            responsive: true
        });
    }
    if ($('#dataTable3').length) {
        $('#dataTable3').DataTable({
            responsive: true
        });
    }


    /*================================
    Slicknav mobile menu
    ==================================*/
    $('ul#nav_menu').slicknav({
        prependTo: "#mobile_menu"
    });

    /*================================
    login form
    ==================================*/
    $('.form-gp input').on('focus', function() {
        $(this).parent('.form-gp').addClass('focused');
    });
    $('.form-gp input').on('focusout', function() {
        if ($(this).val().length === 0) {
            $(this).parent('.form-gp').removeClass('focused');
        }
    });

    /*================================
    slider-area background setting
    ==================================*/
    $('.settings-btn, .offset-close').on('click', function() {
        $('.offset-area').toggleClass('show_hide');
        $('.settings-btn').toggleClass('active');
    });

    /*================================
    Owl Carousel
    ==================================*/
    function slider_area() {
        var owl = $('.testimonial-carousel').owlCarousel({
            margin: 50,
            loop: true,
            autoplay: false,
            nav: false,
            dots: true,
            responsive: {
                0: {
                    items: 1
                },
                450: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1000: {
                    items: 2
                },
                1360: {
                    items: 1
                },
                1600: {
                    items: 2
                }
            }
        });
    }
    slider_area();

    /*================================
    Fullscreen Page
    ==================================*/

    if ($('#full-view').length) {

        var requestFullscreen = function(ele) {
            if (ele.requestFullscreen) {
                ele.requestFullscreen();
            } else if (ele.webkitRequestFullscreen) {
                ele.webkitRequestFullscreen();
            } else if (ele.mozRequestFullScreen) {
                ele.mozRequestFullScreen();
            } else if (ele.msRequestFullscreen) {
                ele.msRequestFullscreen();
            } else {
                console.log('Fullscreen API is not supported.');
            }
        };

        var exitFullscreen = function() {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            } else {
                console.log('Fullscreen API is not supported.');
            }
        };

        var fsDocButton = document.getElementById('full-view');
        var fsExitDocButton = document.getElementById('full-view-exit');

        fsDocButton.addEventListener('click', function(e) {
            e.preventDefault();
            requestFullscreen(document.documentElement);
            $('body').addClass('expanded');
        });

        fsExitDocButton.addEventListener('click', function(e) {
            e.preventDefault();
            exitFullscreen();
            $('body').removeClass('expanded');
        });
    }

    $('#historicoModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botão que acionou o modal
        var url = button.data('url');
        var modal = $(this);
        modal.find('.modal-content form').attr('action', url);
    });

    $('#apagarModalCenter').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botão que acionou o modal
        var url = button.data('url');
        var modal = $(this);
        modal.find('.modal-content form').attr('action', url);
    });

    // $(document).ready(function(){
    //     $('#tell').mask('(00) 0000-0000');
    //     $('#cell').mask('(00) 0.0000-0000');
    //     $('#rg').mask('00.000.000-0');
    //     $('#cpf').mask('000.000.000-00', {reverse: true});
    // });

    // $("#uuidBSelectAjax option:selected").on(function() {
    //     var uuidB = $(this).val();
    //     var url = $(this).data('url');
    //     console.log(url);
    //     $.getJSON(url+'/'+uuidB, function (dados){
    //         if (dados.length > 0){
    //             console.log(uuidB);
    //         }else{
    //             console.log(url);
    //         }
    //      })
    //  });

    $(document).ready(function(){
        $('#uuidBSelectAjax').change(function () {
          if($(this).val()){
            $("#autorizacaoAudiovisualDiv").removeClass('d-none');
            $.ajax({
              url: $(this).find(':selected').data('url'),
              type: 'GET',
              success: function(result){
                  if(result){
                    if(result.autorizacaoAudiovisual == 1){
                        $("#autorizacaoAudiovisual").attr('checked', 'checked');
                    }
                    if($.isEmptyObject(result.fichaCadastro)){
                        $("#fichaCadastroInput").removeClass('d-none');
                    }else{
                        $("a[id='fichaCadastroUrl']").attr('href', result.fichaCadastro.path);
                        $("img[id='fichaCadastroUrl']").attr('src', result.fichaCadastro.path);
                        $("#fichaCadastroImg").removeClass('d-none');
                    }
                  }
              },
              error: function(){
                $("#fichaCadastroInput").removeClass('d-none');
              }
            });
          }else{
            $("#fichaCadastroImg").addClass('d-none');
          }
        })
    });

    $('#delFichaCadastro').click(function(){
        $("#fichaCadastroImg").addClass('d-none');
        $(this).addClass('d-none');
        $("#fichaCadastroInput").removeClass('d-none');
        $("#restFichaCadastro").removeClass('d-none');
        $("#delFichaCadastroInput").val('1');
    });

    $('#restFichaCadastro').click(function(){
        $("#fichaCadastroInput").addClass('d-none');
        $(this).addClass('d-none');
        $("#fichaCadastroImg").removeClass('d-none');
        $("#delFichaCadastro").removeClass('d-none');
        $("#delFichaCadastroInput").val('0');
    });
})(jQuery);

