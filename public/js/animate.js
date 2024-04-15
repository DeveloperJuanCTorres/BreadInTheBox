
            $(document).ready(function() {

                $('.footer__link').each(function(index) {
                    item = index
                    $(this).click(function(item) {
                        let toggleState = $(this).parent().find('.footer__sec-list').hasClass('active')
                        if (toggleState) {
                        $(this).parent().find('.footer__sec-list').removeClass('active')
                        
                        let iconUp = $(this).children('.la-angle-up')
                        iconUp.addClass('la-angle-down').removeClass('la-angle-up')
                        } else {
                        $(this).parent().find('.footer__sec-list').addClass('active')
                        
                        let iconDown = $(this).children('.la-angle-down')
                        iconDown.addClass('la-angle-up').removeClass('la-angle-down')
                        }
                    })
                });

                $('#CloseCart').on('click', function () {
                    $('#sidebarCart').removeClass('active');
                    $('.overlay').removeClass('active');
                });
                
                $('.showCart').on('click', function () {
                    if($("#sidebarCart").hasClass("active")){
                        console.log('not active');
                    }else{
                        $('#sidebarCart').addClass('active');
                        $('.overlay').addClass('active');
                    }
                });

                $('#CloseCartMobile').on('click', function () {
                    $('#sidebarCartMobile').removeClass("active");
                    $('.overlay').removeClass('active');
                });


                $(".showCartMobile").on('click', function () {
                    if($("#sidebarCartMobile").hasClass("active")){
                        console.log('not active mobile');
                    }else{
                        $('#sidebarCartMobile').addClass('active');
                        $('.overlay').addClass('active');
                    }
                });

                $("#close_menu_mobile").on("click", function () {
                    $('.overlay').removeClass('active');
                    $(".header-mobile__list").removeClass('active');
                });

                $("#open_menu_mobile").on('click', function () { 
                    if($(".header-mobile__list").hasClass("active")){
                        console.log('not active mobile');
                    }else{
                        $('.header-mobile__list').addClass('active');
                        $('.overlay').addClass('active');
                    }
                });

                $(".add_pack").on('click',function (e) {
                    
                    e.preventDefault();
                    var ele = $(this);
                    var id = ele.attr("data-id");
                    var variation = ele.attr("data-variation");
                    var price = ele.attr("data-price");

                    Swal.fire({
                        title: 'loading...',
                        allowOutsideClick:false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });

                    $.ajax({
                        url: "/add-pack",
                        method: "post",
                        dataType: 'json',
                        data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: id,
                        variation: variation,
                        price: price,
                        },
                        success: function (response) {
                            Livewire.emitTo('header','render');

                            const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                            });
                            Toast.fire({
                            icon: "success",
                            title: "The package was added to the cart",
                            });
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...!!',
                                text: 'Something went wrong!!',
                            })
                        }
                    });
                });
            })
        