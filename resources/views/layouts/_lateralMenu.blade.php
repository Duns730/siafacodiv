<div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="/" class="site_title"><i class="fa fa-cubes"></i> <span>Dist. Autana Car</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="{{ config('app.url', 'Laravel') }}images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Bienvenido,</span>
                <h2>{{ Auth::user()->name }}</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li>
                    <a href="{{ route('dashboard') }}">
                      <i class="fa fa-dashboard"></i> Tablero 
                    </a>
                  </li>
                  <li>
                    <a>
                      <i class="fa fa-bookmark"></i> Ventas <span class="fa fa-chevron-down"></span>
                    </a>
                    <ul class="nav child_menu">
                     
                      @can('clients.index')
                      <li>
                        <a href="{{ route('clients.index') }}">
                          <i class="fa fa-users"></i> Clientes 
                        </a>
                      </li>
                      @endcan
                      
                       @can('products.index')
                      <li>
                        <a href="{{ route('products.index') }}">
                          <i class="fa fa-cube"></i> Productos 
                        </a>
                      </li>
                      @endcan
                      @can('proformas.index')
                      <li>
                        <a href="{{ route('proformas.index') }}">
                          <i class="fa fa-file-text-o"></i> Proformas 
                        </a>
                      </li>
                      @endcan

                      <li>
                        <a>
                          <i class="fa fa-bookmark"></i>
                          Provisional <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                          @can('purchases.index')
                          <li class="sub_menu">
                            <a href="{{ route('purchases.index') }}">Compras</a>
                          </li>
                          @endcan
                          @can('products.controlquantity')
                          <li>
                            <a href="{{ route('controlquantity') }}">Control de Cantidades</a>
                          </li>
                          @endcan
                        </ul>
                      </li>
                      @can('negotiations.index')
                      <li>
                        <a href="{{ route('negotiations.index') }}">
                          <i class="fa fa-briefcase"></i> Negociaciones 
                        </a>
                      </li>
                      @endcan
                      @can('sellers.index')
                      <li>
                        <a href="{{ route('sellers.index') }}">
                          <i class="fa fa-users"></i> Vendedores 
                        </a>
                      </li>
                      @endcan
                    </ul>
                  </li>


                  


                  <li>
                    <a>
                      <i class="fa fa-bookmark"></i> Cobranza <span class="fa fa-chevron-down"></span>
                    </a>
                    <ul class="nav child_menu">
                      @can('payments.index')
                      <li>
                        <a href="{{ route('payments.index') }}">
                          <i class="fa fa-dollar"></i> Pagos
                        </a>
                      </li>
                      @endcan
                      @can('creditnotes.index')
                      <li>
                        <a href="{{ route('creditnotes.index') }}">
                          <i class="fa fa-file-o"></i> Notas de Crédito
                        </a>
                      </li>
                      @endcan
                    </ul>
                  </li>


                  <li>
                    <a>
                      <i class="fa fa-bookmark"></i> Despacho y Transporte <span class="fa fa-chevron-down"></span>
                    </a>
                    <ul class="nav child_menu">
                      @can('transports.index')
                      <li>
                        <a href="{{ route('transports.index') }}">
                          <i class="fa fa-truck"></i> Transportes
                        </a>
                      </li>
                      @endcan
                      @can('transports.index')
                      <li>
                        <a href="{{ route('transports.index') }}">
                          <i class="fa fa-truck"></i> Transportes
                        </a>
                      </li>
                      @endcan
                      @can('transports.index')
                      <li>
                        <a href="{{ route('transports.index') }}">
                          <i class="fa fa-truck"></i> Transportes
                        </a>
                      </li>
                      @endcan
                      @can('transports.index')
                      <li>
                        <a href="{{ route('transports.index') }}">
                          <i class="fa fa-truck"></i> Transportes
                        </a>
                      </li>
                      @endcan
                    </ul>
                  </li>


                  <li>
                    <a>
                      <i class="fa fa-bookmark"></i> Reportes  <span class="fa fa-chevron-down"></span>
                    </a>
                    <ul class="nav child_menu">
                      <li>
                        <a>
                          <i class="fa fa-file-text-o"></i>
                          Ventas <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                          <li class="sub_menu">
                            <a href="{{ route('reports.sales') }}">Facturas</a>
                          </li>
                          <li>
                            <a href="{{ route('reports.sales.byclients') }}">Por Clientes</a>
                          </li>
                          <li>
                            <a href="{{ route('reports.sales.bylist') }}">Por Lista</a>
                          </li>
                          <li>
                            <a href="{{ route('reports.negotiations.percentage.payment.method') }}">% de Forma de Pago</a>
                          </li>
                          <li>
                            <a href="{{ route('reports.negotiations.waste') }}">Desperdicio</a>
                          </li>
                        </ul>
                      </li>

                      <li>
                        <a>
                          <i class="fa fa-file-text-o"></i>
                          Cobranza <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                          <li class="sub_menu">
                            <a href="{{ route('reports.pending.ivas') }}">IVA's por Cobrar</a>
                          </li>
                          <li>
                            <a href="{{ route('reports.accounts.receivable') }}">Cuentas por Cobrar</a>
                          </li>
                          <li class="sub_menu">
                            <a href="{{ route('reports.charges.bydate') }}">Cobros</a>
                          </li>
                          <li>
                            <a href="{{ route('reports.clients.collection.commission') }}">Comisión por Cobranza</a>
                          </li>
                           <li>
                            <a href="{{ route('reports.negotiations.credit.time') }}">Credito/Tiempo</a>
                          </li>
                        </ul>
                      </li>
                      
                    </ul>
                  </li>
                </ul>
              </div>

              <div class="menu_section">
                <h3>Administrador</h3>
                <ul class="nav side-menu">
                  <li>
                    <a>
                      <i class="fa fa-cogs"></i> Configuraciones <span class="fa fa-chevron-down"></span>
                    </a>
                    <ul class="nav child_menu">
                      @can('users.index')
                      <li>
                        <a href="{{ route('users.index') }}">
                          <i class="fa fa-users"></i> Usuarios 
                        </a>
                      </li>
                      @endcan
                      @can('banks.index')
                      <li>
                        <a href="{{ route('banks.index') }}">
                          <i class="fa fa-bank"></i> Bancos 
                        </a>
                      </li>
                      @endcan
                      @can('configurations.index')
                      <li>
                        <a href="{{ route('configurations.index') }}">
                          <i class="fa fa-bank"></i> Set Configuraciones 
                        </a>
                      </li>
                      @endcan
                    </ul>
                  </li>
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="fa fa-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="fa fa-arrows-alt" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="fa fa-eye-slash" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Salir"
                        href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                    <span class="fa fa-power-off" aria-hidden="true"></span>
              </a>
              
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>