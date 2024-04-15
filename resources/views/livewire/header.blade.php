<div>
<header class="container-fluid  header__wrapper">

  <div class="top-bar__wrapper">
    <div class="top-bar container">
      <div class="top-bar__left">
        <p class="top-bar__text"><i class="las la-store-alt top-bar__icon "></i>Attention from: Monday to Friday / 07:00 am - 3:00 pm</p>
        <p class="top-bar__text"><i class="las la-phone-volume top-bar__icon "></i> Denver: <a href="tel:015002550">+ 303-502-5502</a></p>
        <p class="top-bar__text"><i class="las la-envelope top-bar__icon"></i>  customer@breadinthebox.com</p> 
      </div> 
      <div class="top-bar__right">
        <div class="top-bar__account">
          @auth
            <form method="POST" action="{{ route('logout') }}" class="top-bar__profile_link">
                @csrf
                <x-jet-dropdown-link href="{{ route('logout') }}"
                        onclick="event.preventDefault(); this.closest('form').submit();" class="py-0">
                        <span class="top-bar__icon las la-door-open"></span> Sign off
                </x-jet-dropdown-link>
            </form>
          @else
            <a href='/login' class="top-bar__text account">
              <span class="top-bar__icon las la-user"></span>
              <p class="top-bar__profile_link">
                Login / Register
              </p>
            </a>
          @endauth
       </div>
      </div>
    </div>
  </div>

  <div class="header container">
    <div class="header__left">
      <a href='/' class="header__box-logo">
        <img src="{{asset('images/logo.webp')}}?v=1993.1.1" width="160px" height="55px" alt="">
      </a>
      <ul class="header__list">
        <li class="header__item">
          <a href="{{route('orden')}}" class="header__link">Order Online</a>
        </li>
        <li class="header__item">
          <a href="{{route('monthly.specialty')}}" class="header__link">Monthly Specialty Breads</a>
        </li>
        <li class="header__item">
          <a href="{{route('contact')}}" class="header__link">Contact us</a>
        </li>
        <li class="header__item">
          <a href="{{route('about')}}" class="header__link">About us</a>
        </li>
      </ul>
    </div>

    <div class="header__right">
      <div class="header__options" >
        @auth
        
        <!-- <div class="group-action " >
          <div class="group-action__left">
            <i class="las la-clipboard-list"></i>
          </div>
          <a href="{{ route('orders.index') }}">
            <div class="group-action__right" >
              <p class="group-action__little sub">My orders</p>
            </div>
          </a>
        </div> -->

        <div class="group-action">
          <div x-data="{ show: false, menu: false }">
              <button class="text-sm text-yellow px-4 py-2 border-0 rounded-md outline-none" x-on:click="show = ! show"><i class="las la-user text-xl"></i> {{Str::limit(Auth::user()->name,12)}} <i class="las la-angle-down"></i></button>
              <div class="relative">
                  <div class="bg-white rounded-md p-3 w-44 top-1 absolute z-10" x-show="show" @click.away="show = false" >
                      <ul >
                          <li class="link-option mt-2 mb-3">
                              <a href="{{route('profile.show')}}" ><i class="las la-user-tie"></i> My porfile</a>
                          </li>
                          <li class="link-option mb-3">
                              <a href="{{route('suscription.index')}}"> <i class="las la-bell"></i> My suscriptions </a>
                          </li>
                          <li class="link-option mb-4">
                              <a href="{{route('orders.index')}}" ><i class="las la-clipboard-list"></i> My orders</a>
                          </li>

                          <li class="link-option mb-2">
                            <form method="POST" action="{{ route('logout') }}" class="top-bar__profile_link">
                                @csrf
                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();" class="py-0">
                                        <i class="las la-door-open"></i> Sign off
                                </x-jet-dropdown-link>
                            </form>
                          </li>
                      </ul>
                  </div>
              </div>
          </div>

          <!-- <div class="group-action__left">
            <i class="las la-user"></i>
          </div> 
          <a href="{{ route('profile.show') }}">
            <div class="group-action__right" id="showModalAddress">
              <p class="group-action__little sub">User</p>
              <p class="group-action__normal">  {{ Str::limit(Auth::user()->name,12) }}</p>
            </div>
          </a>  -->
        </div>

        @endauth
        <div class="group-action">
            <div class="group-action__left showCart" >
              <i class="las la-shopping-bag"></i>
            </div>
            <div class="group-action__right showCart" >
              <p class="group-action__little">Sub Total</p>
              <p class="group-action__normal bold">$
                  <span class="normal-font " >
                  </span>
                  <span class="normal-font" >
                      {{number_format(Cart::getSubTotal(),2)}}
                  </span>
              </p>
            </div>
            <div id="sidebarCart" class="sidebar-cart">
              <div class="sidebar-cart__header">
                <div class="sidebar-cart__box-title">
                  <p class="sidebar-cart__text">Order</p>
                    <span id="CloseCart">
                      <i class="las la-times text-xl"></i>
                    </span>
                </div>
              </div>
              <div class="sidebar-cart__body">
                <div class="item-sidebar" >
                  @if(count(Cart::getContent()) > 0)
                    @foreach(Cart::getContent() as $car)
                    <div class="item-sidebar__center">
                      <div class="item-sidebar__box-img">
                          @isset($car->attributes['image'])
                              <img src="{{config('services.trading.url')}}/uploads/{{$car->attributes->image}}" class="item-sidebar__img" alt="IMAGE">
                          @endisset
                      </div>
                      <div class="item-sidebar__box-detail">
                        <p class="item-sidebar__nombre">{{Str::limit($car->name,80)}}</p>
                        <p class="item-sidebar__extra">
                            <strong>Amount:</strong>
                            <ul class="item-sidebar__extra__list">
                                <li >
                                    <span>{{$car->quantity}} x $ {{number_format($car->price,2)}}</span>
                                </li>
                            </ul>
                        </p>
                        <p class="item-sidebar__precio">$ {{number_format($car->price * $car->quantity,2)}}</p>
                      </div>
                    </div>
                    @endforeach
                    @else
                        <h5>Your cart is still empty</h5>
                    @endif
                  <div class="item-sidebar__right" >
                    <span class="item-sidebar__close"><i class="far fa-trash-alt"></i></span> 
                  </div>
                </div>
              </div>
              <div class="sidebar-cart__footer">
                <div class="box-subtotal">
                  <div class="box-subtotal__top">
                    <p class="sidebar-cart__text">Subtotal</p>
                    <p class="box-subtotal__text">$ {{number_format(Cart::getSubTotal(),2)}}</p>
                  </div>
                  <div class="box-subtotal__bottom">
                    <a href="{{route('shopping-cart')}}" class="box-subtotal__btn btn btn-fluid btn-red">Go to shopping cart</a>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</header>

<header class="container-fluid header-mobile__wrapper">
  <div class="header-mobile container">
    <div class="header-mobile__left">
      <div class="header-mobile__box-logo">
        <span class="header-mobile__menu las la-bars" id="open_menu_mobile"></span>
        <a href="/">
          <img src="{{asset('images/logo.webp')}}" width="120px" alt="">
        </a>
      </div>
      <ul class="header-mobile__list">
        <span class="las la-times header-mobile__close" id="close_menu_mobile"></span>
        <div class="header-mobile__bloque">
          <li class="header-mobile__item">
            <a href="/" class="header-mobile__link principal-itm">
              <img src="{{asset('images/logo.webp')}}" width="180px" alt="">
            </a>
          </li>
          <li class="header-mobile__item">
            <a href="{{route('orden')}}" class="header-mobile__link">Order Online</a>
          </li>
          <li class="header-mobile__item">
            <a href="{{route('monthly.specialty')}}" class="header-mobile__link">Monthly Specialty Breads</a>
          </li>
          <li class="header-mobile__item">
            <a href="{{route('contact')}}" class="header-mobile__link">Contact us</a>
          </li>
          <li class="header-mobile__item">
            <a href="{{route('about')}}" class="header-mobile__link">About us</a>
          </li>
        </div>
        @auth
        <div class="mobile-menu-account">
            <form method="POST" action="{{ route('logout') }}" class="my-4" >
                @csrf
                <x-jet-dropdown-link href="{{ route('logout') }}"
                        onclick="event.preventDefault(); this.closest('form').submit();" class="py-0">
                       <span class="mobile-menu-account-login"> <i class="las la-door-open"></i> Sign off</span> 
                </x-jet-dropdown-link>
            </form>
        </div>

        <div class="mobile-menu-account">
          <a class="mobile-menu-account-login" href="{{ route('profile.show') }}">  <i class="las la-user"></i>  User: {{ Str::limit(Auth::user()->name,12) }}</a>
        </div>

        <div class="mobile-menu-account">
          <a class="mobile-menu-account-login" href="{{ route('profile.show') }}">  <i class="las la-clipboard-list"></i> My orders</a>
        </div>

        @else
        <div class="mobile-menu-account">
          <a class="mobile-menu-account-login" href="/login">Login / Register</a>
        </div>
        @endauth

        <div class="top-bar-mobile__wrapper">
          <div class="top-bar-mobile container">
              <div class="top-bar-mobile__left">
                <p class="top-bar-mobile__text"> <i class="las la-store-alt top-bar__icon "></i> Attention from: Monday to Friday / 07:00 am - 3:00 pm</p>
                <p class="top-bar-mobile__text"> <i class="las la-phone-volume top-bar__icon "></i> Denver: <a href="tel:015002550"> + 303-502-5502</a></p>
                <p class="top-bar-mobile__text"> <i class="las la-envelope top-bar__icon"></i>  <a href="mailto:customer@breadinthebox.com">customer@breadinthebox.com</a></p>
              </div>
            <div class="header-mobile__bloque">
        </div>
        </div>
      </div>
      </ul>
    </div>
    <div class="header-mobile__right">
      <div class="header-mobile__options">
        <div class="group-action"  id="showSidebarMobile">

            <div class="group-action__left showCartMobile">
              <i class="las la-shopping-bag"></i>
            </div>

            <div class="group-action__right showCartMobile">
              <p class="group-action__little">Sub total</p>
              <p class="group-action__normal bold" >$
                  <span class="normal-font" > {{number_format(Cart::getSubTotal(),2)}} </span>
            </div>
           

          <div class="sidebar-cart" id="sidebarCartMobile">
            <div class="sidebar-cart__header">
              <div class="sidebar-cart__box-title">
                <p class="sidebar-cart__text">Order</p>
                <span id="CloseCartMobile" class="las la-times"></span>
              </div>
            </div>
            <div class="sidebar-cart__body">
              <div class="item-sidebar" >

              @if(count(Cart::getContent()) > 0)
                    @foreach(Cart::getContent() as $car)
                      <div class="item-sidebar__left">
                        <div class="item-sidebar__box-img">
                          @isset($car->attributes['image'])
                          <img src="{{config('services.trading.url')}}/uploads/{{$car->attributes->image}}" alt="" class="item-sidebar__img">
                          @endisset
                        </div>
                        <div class="item-sidebar__box-detail">
                          <p class="item-sidebar__nombre">{{Str::limit($car->name,80)}}</p>
                          <p class="item-sidebar__extra" >
                            <strong>Amount:</strong>
                          </p>
                          <p class="item-sidebar__extra" >
    
                              <ul class="item-sidebar__extra__list">
                                  <li>
                                    <span>{{$car->quantity}} x $ {{number_format($car->price,2)}}</span>
                                  </li>
                              </ul>
                          </p>
                          
                          <p class="item-sidebar__precio">$ {{number_format($car->price * $car->quantity,2)}}</p>
                        </div>
                      </div>
                      @endforeach
                    @else
                        <h5>Your cart is still empty</h5>
                    @endif
                
                
              </div>
            </div>
            <div class="sidebar-cart__footer">
              <div class="box-subtotal">
                <div class="box-subtotal__top">
                  <p class="sidebar-cart__text">Subtotal</p>
                  <p class="box-subtotal__text">$ {{number_format(Cart::getSubTotal(),2)}}</p>
                </div>
                <div class="box-subtotal__bottom">
                  <a href="{{route('shopping-cart')}}" class="box-subtotal__btn btn btn-fluid btn-red">Go to shopping cart</a>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</header>
</div>
