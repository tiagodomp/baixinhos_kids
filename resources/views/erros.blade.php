
<section id="erros" class="row justify-content-md-center">
    @if(session('primary'))
    <div class="mt-5 col-md-auto alert alert-primary alert-dismissible fade show" role="alert">
        <p class="mr-4">{{session('primary')}}</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('secondary'))
    <div class="mt-5 col-md-auto alert alert-secondary alert-dismissible fade show" role="alert">
        <p class="mr-4">{{session('secondary')}}</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if(session('success'))
    <div class="mt-5 col-md-auto alert alert-success alert-dismissible fade show" role="alert">
        <p class="mr-4">{{session('success')}}</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if(session('danger'))
    <div class="mt-5 col-md-auto alert alert-danger alert-dismissible fade show" role="alert">
        <p class="mr-4">{{session('danger')}}</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if(session('warning'))
    <div class="mt-5 col-md-auto alert alert-warning alert-dismissible fade show" role="alert">
        <p class="mr-4">{{session('warning')}}</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if(session('info'))
    <div class="mt-5 col-md-auto alert alert-info alert-dismissible fade show" role="alert">
        <p class="mr-4">{{session('info')}}</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if(session('light'))
    <div class="mt-5 col-md-auto alert alert-light alert-dismissible fade show" role="alert">
        <p class="mr-4">{{session('light')}}</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if(session('dark'))
    <div class="mt-5 col-md-auto alert alert-dark alert-dismissible fade show" role="alert">
        <p class="mr-4">{{session('dark')}}</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
</section>
