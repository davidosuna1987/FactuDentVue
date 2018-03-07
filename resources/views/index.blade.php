@extends('layouts.web')

@section('content')
  <header class="header appear-parent floating-tooth-background">
    <div class="wrapper">
      <div class="content">
        <h1 class="title is-1 appear-child afade abottom">FactuDent <span class="is-inline-block icon icon-tooth particles-container"><span class="particles-content"><i class="mdi mdi-tooth"></i></span></span></h1>
        <h3 class="subtitle appear-child afade abottom">La forma más sencilla de hacer tus facturas</h3>
        <a href="{{route('register')}}" class="button is-primary is-outlined is-inverted is-rounded appear-child afade abottom">Regístrate ahora</a>
      </div>
    </div>
  </header>

  <section>
    <div class="wrapper">
      <div class="content">
          <div class="columns is-multiline has-text-centered m-b-70">
            <div class="column is-half is-offset-one-quarter appear-parent">
              <h3 class="title appear-child afade abottom">PARA ODONTÓLOGOS</h3>
              <p class="appear-child afade abottom">Sabemos lo engorroso que es tener que hacer todas las facturas a mano, por eso hemos creado esta aplicación para que puedas hacerlo <span class="strong has-text-primary">de forma muy sencilla</span> y tener todas tus facturas y clínicas <span class="strong has-text-primary">bien organizadas</span>.</p>
            </div>
          </div>

          <div class="columns is-centered m-b-100 appear-parent">
            <div class="column is-3">
              <div class="card appear-child afade abottom">
                <div class="card-content has-text-centered">
                  <span class="icon card-icon has-text-primary">
                    <i class="mdi mdi-tooth"></i>
                  </span>
                  <h3 class="title">Dedicación</h3>
                  <p class="m-b-35">En <span class="strong has-text-primary">FactuDent</span> nos enfocamos exclusivamente en los odontólogos porque sabemos que para vosotros es una parte más del trabajo diario.</p>
                </div>
              </div>
            </div>
            <div class="column is-3">
              <div class="card appear-child afade abottom">
                <div class="card-content has-text-centered">
                  <span class="icon card-icon has-text-primary">
                    <i class="fa fa-file-pdf-o"></i>
                  </span>
                  <h3 class="title">Facturas</h3>
                  <p class="m-b-35">Podrás crear, editar y eliminar facturas <span class="strong has-text-primary">muy fácilmente</span> y recuperarlas, enviarlas o guardarlas cuando quieras. ¡Nunca había sido tan fácil!</p>
                </div>
              </div>
            </div>
            <div class="column is-3">
              <div class="card appear-child afade abottom">
                <div class="card-content has-text-centered">
                  <span class="icon card-icon has-text-primary">
                    <i class="mdi mdi-home-outline"></i>
                  </span>
                  <h3 class="title">Clínicas</h3>
                  <p class="m-b-35">También tendrás organizadas todas las <span class="strong has-text-primary">clínicas</span> donde trabajas para poder asignar y enviar tus facturas cuando tu quieras con un solo click.</p>
                </div>
              </div>
            </div>
          </div>

          <div class="hero is-light">
            <div class="hero-body">
              <div class="columns has-text-centered p-t-50 p-b-50">
                <div class="column is-half is-offset-one-quarter appear-parent">
                  <h3 class="title appear-child afade abottom">NO LO PIENSES MÁS</h3>
                  <p class="appear-child afade abottom">¿Ya te ha convencido? Si es así, <span class="strong has-text-primary">no lo dudes</span> y registrate ya para comenzar a <span class="strong has-text-primary">gestionar fácilmente</span> tus facturas y clínicas. Además tenemos una gran noticia y es que las personas que ya estén registradas, podrán disfrutar de todas las ventajas de <span class="strong has-text-primary">FactuDent</span> de forma <span class="strong has-text-primary">gratuita</span>.</p>
                  <a href="{{route('register')}}" class="button is-primary is-rounded m-t-30 appear-child afade abottom">Quiero registrarme</a>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </section>
@endsection
