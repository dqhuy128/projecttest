const unique = (value, index, self) => {
    return self.indexOf(value) === index
};
var app_prd_detail = new Vue({
    // options content
    el: '#app_prd_detail',
    data: {
        option_color: false,
        prd_id: prd_id,
        prd_alias: prd_alias,
        option_view: option_view,
        // warehouse: warehouse_ ? JSON.parse(warehouse_) : [],
        // st: JSON.parse(store),
        prices: prices,
        filters: JSON.parse(filters),
        combo: combo ? combo : [],
        filter_prices: filter_prices ? filter_prices : [],
        filter_cates: JSON.parse(filter_cates),
        percent: JSON.parse(percent),
        // sale: JSON.parse(sale),
        infoPro: JSON.parse(infoPro),
        customer_gp: JSON.parse(customer_gp),
        combo_after_run: [],
        choosed_item: [],
        choosed_combo: [],
        filter_item: {},
        filter_ids: [],
        combo_ids: [],
        img_filter: [],
        param_ids: [],
        combo_title: '',
        prd_price: 0,
        count_st: 0,
        wh_arr: 0,
        amount: '',
        tit: 'Số Lượng',
        prd_price_strike: 0,
        quantity: 1,
        status_text: 'Còn hàng',
        status_storage: 1,// 1: còn hàng, 0: Liên hệ
        error_msg: '',
        des_up_jscar: false,
    },
    beforeMount() {
        var vm = this;
        var url = new URL(window.location.href);
        var fpid = url.searchParams.get("fpid");
        var cpid = url.searchParams.get("cpid");
        if (fpid) {
            fpid = fpid.split(',');
            $.each(vm.filters, function (key, value) {
                for (var i = 0; i < fpid.length; i++) {
                    if (fpid[i] == value.id) {
                        if (cpid) {
                            cpid = cpid.split(',');
                            vm.combo_after_run = [];
                            $.each(vm.filter_prices, function (key_kp, value_kp) {
                                for (var j = 0; j < cpid.length; j++) {
                                    if (value.id == value_kp.key_price) {
                                        vm.combo[value_kp.combo_price].choosing_checked = false
                                        vm.combo_after_run.push(vm.combo[value_kp.combo_price]);
                                    }
                                }
                            })

                            // vm.combo_after_run = vm.combo_after_run.filter(unique);
                            // $.each(vm.combo_after_run, function (Key_com, item_com) {
                            //     vm.prices.some(function(items){
                            //         if(items.combo_ids == item_com.id){
                            //             vm.choosed_combo[item_com.id] = items.combo_ids;
                            //         }
                            //     });
                            // })
                            vm.prices.some(function (item) {
                                for (var j = 0; j < cpid.length; j++) {
                                    if (item.filter_ids == value.id && cpid[j] == item.combo_ids) {
                                        $.each(vm.combo_after_run, function (Key_com, item_com) {
                                            if (item_com.id == cpid[j]) {
                                                item_com.choosing_checked = true;

                                            }
                                        })
                                        if (item.image) {
                                            vm.img_filter = item.image;
                                        }
                                        if (item.combo) {
                                            $.each(item.combo, function (key_combo_pr, value_combo_pr) {
                                                vm.combo_title = value_combo_pr.title
                                                vm.choosed_combo[value_combo_pr.id] = item.combo_ids;
                                                vm.combo_ids = vm.choosed_combo.filter(unique);
                                                if (value_combo_pr.parameter.length > 0) {
                                                    $.each(value_combo_pr.parameter, function (key_param_combo, value_combo) {
                                                        var param_combo = {
                                                            'param_title': value_combo.combo_title,
                                                            'param_value': value_combo.combo_values
                                                        }
                                                        vm.param_ids.push(param_combo);
                                                    })
                                                }
                                            })
                                        }
                                        if (item.param) {
                                            $.each(item.param, function (key_param_pr, value_param_pr) {
                                                var param_pr = {
                                                    'param_title': value_param_pr.param_filter_titles,
                                                    'param_value': value_param_pr.param_filter_values
                                                }
                                                vm.param_ids.push(param_pr);
                                            })
                                        }
                                        vm.prd_price = item.price;
                                        vm.prd_price_strike = item.price_strike;
                                        vm.prd_code = item.product_code;
                                        return false
                                    }
                                }
                            });
                            value.choosing_checked = true;
                            vm.choosed_item[value.filter_cate_id] = value.id;
                            vm.filter_ids = vm.choosed_item.filter(unique);
                        }
                        else {
                            if (vm.img_filter.length == 0 && typeof value.image != 'undefined' && value.image != null) {
                                vm.img_filter = value.image;
                            }
                            vm.prices.some(function (item) {
                                if (item.filter_ids == value.id) {
                                    if (item.image) {
                                        vm.img_filter = item.image;
                                    }
                                    if (item.param) {
                                        $.each(item.param, function (key_param_pr, value_param_pr) {
                                            var param_pr = { 'param_title': value_param_pr.param_filter_titles, 'param_value': value_param_pr.param_filter_values }
                                            vm.param_ids.push(param_pr);
                                        })
                                    }
                                    vm.prd_price = item.price;
                                    vm.prd_price_strike = item.price_strike;
                                    vm.prd_code = item.product_code;
                                    return true;
                                }
                            });
                            value.choosing_checked = true;
                            vm.choosed_item[value.filter_cate_id] = value.id;
                            vm.filter_ids = vm.choosed_item.filter(unique);
                        }


                    }
                }
            });

        }
        else if (cpid) {
            cpid = cpid.split(',');
            $.each(vm.combo, function (key_combo, value_combo) {
                for (var k = 0; k < cpid.length; k++) {
                    if (value_combo.id == cpid[k]) {
                        value_combo.choosing_checked = true;
                        vm.combo_title = value_combo.title;
                        if (value_combo.parameter.length > 0) {
                            $.each(value_combo.parameter, function (key_param_cb, value_param_cb) {
                                var param_cb = { 'param_title': value_param_cb.combo_title, 'param_value': value_param_cb.combo_values }
                                vm.param_ids.push(param_cb);
                            })
                        }
                        vm.prd_price = value_combo.price;
                        vm.prd_price_strike = value_combo.price_strike;

                        vm.choosed_combo[value_combo.id] = value_combo.id;
                        vm.combo_ids = vm.choosed_combo.filter(unique);
                    }
                }
            })
        }
        else {
            if (vm.option_view == 1) {
                $.each(vm.combo, function (key_combo, value_combo) {
                    value_combo.choosing_checked = true;
                    vm.combo_title = value_combo.title;
                    if (value_combo.parameter.length > 0) {
                        $.each(value_combo.parameter, function (key_param_cb, value_param_cb) {
                            var param_cb = { 'param_title': value_param_cb.combo_title, 'param_value': value_param_cb.combo_values }
                            vm.param_ids.push(param_cb);
                        })
                    }
                    vm.prd_price = value_combo.price;
                    vm.prd_price_strike = value_combo.price_strike;

                    vm.choosed_combo[value_combo.id] = value_combo.id;
                    vm.combo_ids = vm.choosed_combo.filter(unique);
                    window.history.pushState({}, '', shop.setGetParameter('cpid', vm.combo_ids.join(), true));
                    return false
                })
            }
            else if (vm.option_view == 2) {
                $.each(vm.filter_cates, function (key, item) {
                    $.each(vm.filters, function (key_fil, item_fil) {
                        if (item.id == item_fil.filter_cate_id) {
                            vm.prices.some(function (items) {
                                if (items.filter_ids == item_fil.id) {
                                    vm.choosed_item[item.id] = items.filter_ids;
                                    item_fil.choosing_checked = true;
                                }
                            });
                        }
                        return false;
                    });
                });
                vm.filter_ids = vm.choosed_item.filter(unique);
                vm.prices.some(function (item) {
                    if (vm.filter_ids.includes(item.filter_ids)) {
                        if (item.image) {
                            vm.img_filter = item.image;
                        }
                        if (item.param) {
                            $.each(item.param, function (key_param_pr, value_param_pr) {
                                var param_pr = { 'param_title': value_param_pr.param_filter_titles, 'param_value': value_param_pr.param_filter_values }
                                vm.param_ids.push(param_pr);
                            })
                        }
                        vm.prd_price = item.price;
                        vm.prd_price_strike = item.price_strike;
                        vm.prd_code = item.product_code;
                        return true;
                    }
                });
                window.history.pushState({}, '', shop.setGetParameter('fpid', vm.filter_ids.join(), true));
            }
            else if (vm.option_view == 3) {
                $.each(vm.filter_cates, function (key, item) {
                    $.each(vm.filters, function (key_fil, item_fil) {
                        if (item.id == item_fil.filter_cate_id) {
                            vm.prices.some(function (items) {
                                if (items.filter_ids == item_fil.id) {
                                    vm.choosed_item[item.id] = items.filter_ids;
                                    item_fil.choosing_checked = true;
                                    $.each(vm.filter_prices, function (key_kp, value_kp) {
                                        if (item_fil.id == value_kp.key_price) {
                                            vm.combo_after_run.push(vm.combo[value_kp.combo_price]);
                                        }
                                    })
                                }
                            });
                            vm.combo_after_run = vm.combo_after_run.filter(unique);
                            $.each(vm.combo_after_run, function (Key_com, item_com) {
                                vm.prices.some(function (items) {
                                    if (items.combo_ids == item_com.id) {
                                        vm.choosed_combo[item_com.id] = items.combo_ids;
                                        item_com.choosing_checked = true;
                                    }
                                });
                                return false;
                            })
                        }
                        return false
                    });
                });
                vm.filter_ids = vm.choosed_item.filter(unique);
                vm.combo_ids = vm.choosed_combo.filter(unique);
                vm.prices.some(function (item) {
                    if (item.filter_ids == vm.filter_ids.join() && item.combo_ids == vm.combo_ids.join()) {
                        if (item.image) {
                            vm.img_filter = item.image;
                        }
                        if (item.combo) {
                            $.each(item.combo, function (key_combo_pr, value_combo_pr) {
                                vm.combo_title = value_combo_pr.title
                                if (value_combo_pr.parameter.length > 0) {
                                    $.each(value_combo_pr.parameter, function (key_param_combo, value_combo) {
                                        var param_combo = { 'param_title': value_combo.combo_title, 'param_value': value_combo.combo_values }
                                        vm.param_ids.push(param_combo);
                                    })
                                }
                            })
                        }
                        if (item.param) {
                            $.each(item.param, function (key_param_pr, value_param_pr) {
                                var param_pr = { 'param_title': value_param_pr.param_filter_titles, 'param_value': value_param_pr.param_filter_values }
                                vm.param_ids.push(param_pr);
                            })
                        }
                        vm.prd_price = item.price;
                        vm.prd_price_strike = item.price_strike;
                        vm.prd_code = item.product_code;
                        return false;
                    }
                });
                window.history.pushState({}, '', shop.setGetParameter('fpid', vm.filter_ids.join(), true));
                window.history.pushState({}, '', shop.setGetParameter('cpid', vm.combo_ids.join(), true));
            }
        }
    },
    mounted() {
        // this.loader();
        var vm = this;
        if (Object.keys(this.filter_cates).length <= 0) {
            this.status_text = 'Liên hệ';
            this.status_storage = 0;
        }
        // var arr_money = [];
        // this.prices.forEach(function(item,key){
        //     arr_money.push(item.price);
        // });
        //
        //
        // var min_money = Math.min(...arr_money);
        // this.prices.some(function(item){
        //     if(min_money == item.price) {
        //         vm.prd_price = item.price;
        //         vm.prd_price_strike = item.price_strike;
        //         return true;
        //     }
        // });


    },
    computed: {
        percentPro: function () {
            return 100 - Math.round(this.prd_price / this.prd_price_strike * 100);
        }
    },

    methods: {
        loader: function () {
            setTimeout(function () {
                if ($('#pb_loader').length > 0) {
                    $('#pb_loader').removeClass('show');
                }
            }, 700);
        },
        show_loader: function () {
            if ($('#pb_loader').length > 0) {
                $('#pb_loader').addClass('show');
            }
        },
        hide_loader: function () {
            if ($('#pb_loader').length > 0) {
                $('#pb_loader').removeClass('show');
            }
        },
        up_quan: function (e) {
            e.preventDefault();
            this.quantity = this.quantity + 1;
        },
        down_quan: function (e) {
            e.preventDefault();
            this.quantity = this.quantity > 1 ? this.quantity - 1 : 1;
        },
        choose_this: function (e, filter) {
            e.target.checked = true;
            var vm = this;
            if (vm.option_view == 2) {
                vm.choosed_item[filter.filter_cate_id] = filter.id;
                vm.filter_ids = vm.choosed_item.filter(unique);

                vm.prices.some(function (items) {
                    if (items.filter_ids == vm.filter_ids.join()) {
                        if (items.image) {
                            vm.img_filter = items.image;
                        }
                        vm.param_ids = [];

                        if (items.param) {
                            $.each(items.param, function (key_param_pr, value_param_pr) {
                                var param_pr = { 'param_title': value_param_pr.param_filter_titles, 'param_value': value_param_pr.param_filter_values }
                                vm.param_ids.push(param_pr);
                            })
                        }
                        vm.des_up_jscar = true;
                        vm.update_slide(vm.img_filter)
                        vm.prd_price = items.price;
                        vm.prd_price_strike = items.price_strike;
                        vm.prd_code = items.product_code;
                        window.history.pushState({}, '', shop.setGetParameter('fpid', vm.filter_ids.join(), true));
                        // return location.reload();
                        detailAccesscory.initPrdPrice(items.price);
                    }
                    return false

                });
            } else if (vm.option_view == 3) {
                vm.combo_after_run = [];
                vm.prices.some(function (items) {
                    if (items.filter_ids == filter.id) {
                        vm.choosed_item[filter.filter_cate_id] = filter.id;
                        vm.filter_ids = vm.choosed_item.filter(unique);
                        window.history.pushState({}, '', shop.setGetParameter('fpid', vm.filter_ids.join(), true));

                        // return location.reload();
                        if (vm.filter_prices) {
                            $.each(vm.filter_prices, function (key_kp, value_kp) {
                                if (filter.id == value_kp.key_price) {
                                    vm.combo[value_kp.combo_price].choosing_checked = false;
                                    vm.combo_after_run.push(vm.combo[value_kp.combo_price]);
                                }
                            })
                        }

                    }
                });
                vm.combo_after_run = vm.combo_after_run.filter(unique);
                vm.prices.some(function (items) {
                    $.each(vm.combo_after_run, function (key_com, value_com) {
                        if (items.filter_ids == vm.filter_ids.join() && items.combo_ids == value_com.id) {
                            vm.choosed_combo = [];
                            value_com.choosing_checked = true;
                            vm.choosed_combo[value_com.id] = items.combo_ids;
                            vm.combo_ids = vm.choosed_combo.filter(unique);

                            if (items.image) {
                                vm.img_filter = items.image;
                            }
                            vm.param_ids = [];
                            if (items.combo) {
                                $.each(items.combo, function (key_combo_pr, value_combo_pr) {
                                    vm.combo_title = value_combo_pr.title
                                    if (value_combo_pr.parameter.length > 0) {
                                        $.each(value_combo_pr.parameter, function (key_param_combo, value_combo) {
                                            var param_combo = { 'param_title': value_combo.combo_title, 'param_value': value_combo.combo_values }
                                            vm.param_ids.push(param_combo);
                                        })
                                    }
                                })
                            }
                            if (items.param) {
                                $.each(items.param, function (key_param_pr, value_param_pr) {
                                    var param_pr = { 'param_title': value_param_pr.param_filter_titles, 'param_value': value_param_pr.param_filter_values }
                                    vm.param_ids.push(param_pr);
                                })
                            }
                            vm.des_up_jscar = true;
                            vm.update_slide(vm.img_filter)
                            vm.prd_price = items.price;
                            vm.prd_price_strike = items.price_strike;
                            vm.prd_code = items.product_code;
                            window.history.pushState({}, '', shop.setGetParameter('cpid', vm.combo_ids.join(), true));
                            
                            // return location.reload();
                            detailAccesscory.initPrdPrice(items.price);
                        }
                        return false
                    })

                });
                return false;
            }
        },
        choose_combo: function (e, combo) {
            e.target.checked = true;
            var vm = this;
            var url = new URL(window.location.href);
            vm.choosed_combo[combo.id] = combo.id;
            vm.combo_ids = vm.choosed_combo.filter(unique);

            if (vm.option_view == 3) {
                var fpid = url.searchParams.get("fpid");
                if (fpid) {
                    fpid = fpid.split(',');
                    $.each(vm.combo_after_run, function (key_caf, value_af) {
                        value_af.choosing_checked = false;
                    })
                    for (var z = 0; z < fpid.length; z++) {
                        vm.prices.some(function (items) {
                            if (items.filter_ids == fpid[z] && combo.id == items.combo_ids) {
                                vm.choosed_combo = [];
                                combo.choosing_checked = true;
                                vm.choosed_combo[combo.id] = items.combo_ids;
                                vm.combo_ids = vm.choosed_combo.filter(unique);

                                if (items.image) {
                                    vm.img_filter = items.image;
                                }
                                vm.param_ids = [];
                                if (items.combo) {
                                    $.each(items.combo, function (key_combo_pr, value_combo_pr) {
                                        vm.combo_title = value_combo_pr.title
                                        if (value_combo_pr.parameter.length > 0) {
                                            $.each(value_combo_pr.parameter, function (key_param_combo, value_combo) {
                                                var param_combo = { 'param_title': value_combo.combo_title, 'param_value': value_combo.combo_values }
                                                vm.param_ids.push(param_combo);
                                            })
                                        }
                                    })
                                }
                                if (items.param) {
                                    $.each(items.param, function (key_param_pr, value_param_pr) {
                                        var param_pr = { 'param_title': value_param_pr.param_filter_titles, 'param_value': value_param_pr.param_filter_values }
                                        vm.param_ids.push(param_pr);
                                    })
                                }
                                vm.des_up_jscar = true;
                                vm.update_slide(vm.img_filter)
                                vm.prd_price = items.price;

                                detailAccesscory.initPrdPrice(items.price);

                                vm.prd_price_strike = items.price_strike;
                                vm.prd_code = items.product_code;
                                window.history.pushState({}, '', shop.setGetParameter('cpid', vm.combo_ids.join(), true));

                                // return location.reload();
                            }
                        });
                    }

                }
            }
            else if (vm.option_view == 1) {
                $.each(vm.combo, function (key_caf, value_combo) {
                    if (combo.id == value_combo.id) {
                        value_combo.choosing_checked = true;
                        vm.combo_title = value_combo.title;
                        if (value_combo.parameter.length > 0) {
                            vm.param_ids = [];
                            $.each(value_combo.parameter, function (key_param_cb, value_param_cb) {
                                var param_cb = { 'param_title': value_param_cb.combo_title, 'param_value': value_param_cb.combo_values }
                                vm.param_ids.push(param_cb);
                            })
                        }
                        vm.prd_price = value_combo.price;

                        detailAccesscory.initPrdPrice(value_combo.price);

                        vm.prd_price_strike = value_combo.price_strike;
                        vm.choosed_combo = [];
                        vm.choosed_combo[value_combo.id] = value_combo.id;
                        vm.combo_ids = vm.choosed_combo.filter(unique);
                        window.history.pushState({}, '', shop.setGetParameter('cpid', vm.combo_ids.join(), true));
                        // window.location.reload();
                    } else {
                        value_combo.choosing_checked = false;
                    }
                })
            }

        },
        checked_input: function (item) {
            console.log(this.filter_ids.indexOf(item.id) > -1);
            // console.log(this.filter_ids);
            // console.log(this.filter_ids.indexOf(item.id));
            return (this.filter_ids.indexOf(item.id) > -1);
        },
        add_to_cart: function (e) {
            let accessoriesItem = []
            $('.accessory-item').each(function (item) {
                if ($(this).is(':checked')) {
                    accessoriesItem.push($(this).val());
                }
            });
            
            e.preventDefault();
            var vm = this;
            vm.error_msg = '';
            if (Object.keys(vm.choosed_item).length < Object.keys(vm.filter_cates).length) {
                vm.error_msg = 'Hãy chắc chắn rằng bạn đã chọn đủ hạng mục sản phẩm';
            } else {
                if (vm.quantity > 0) {
                    if(!shop.is_exists(shop._store['loading_add_cart'])){
                        shop._store['loading_add_cart'] = 0;
                    }
                    if(shop._store['loading_add_cart'] == 0) {
                        shop._store['loading_add_cart'] = 1;
                        $.ajax({
                            type: 'POST',
                            url: "ajax/cart-add",
                            data: {
                                _token: ENV.token,
                                id: vm.prd_id,
                                filter_key: vm.filter_ids.join(),
                                combo_key: vm.combo_ids.join(),
                                quan: accessoriesItem.length == 0 ?  vm.quantity : 1,
                                type: vm.option_view,
                                special_offer_id: $('.specialOffer:checked').val(),
                                accessories: accessoriesItem
                            },
                            dataType: 'json',
                        }).done(function (json) {
                            if (json.error == 1) {
                                Swal.fire({
                                    title: 'Thông báo',
                                    text: json.msg,
                                    type: 'warning', confirmButtonText: 'Đồng ý', confirmButtonColor: '#f37d26',
                                });
                                shop._store['loading_add_cart'] = 0;
                            } else {
                                $('.counter-cart').text(json.data.number);
                                // Swal.fire({
                                //     title: 'Thông báo',
                                //     text: 'Thêm vào giỏ hàng thành công',
                                //     type: 'success', confirmButtonText: 'Đồng ý', confirmButtonColor: '#f37d26',
                                // }).then((result) => {
                                shop.redirect(json.data['url']);
                                // });
                            }
                        });
                    }
                } else {
                    vm.error_msg = 'Vui lòng chọn ít nhất 1 sản phẩm';
                }
            }
            if (vm.error_msg != '') {
                Swal.fire({
                    title: 'Thông báo',
                    text: vm.error_msg,
                    type: 'warning', confirmButtonText: 'Đồng ý', confirmButtonColor: '#f37d26',
                });
            }
        },

        installment: function (e, index) {
            e.preventDefault();

            var vm = this;
            vm.error_msg = '';
            if (Object.keys(vm.choosed_item).length < Object.keys(vm.filter_cates).length) {
                vm.error_msg = 'Hãy chắc chắn rằng bạn đã chọn đủ hạng mục sản phẩm';
            } else {
                if (vm.quantity > 0) {
                    var msg_ajax = '';
                    $.ajax({
                        type: 'GET',
                        url: 'ajax/installment',
                        data: {
                            _token: ENV.token,
                            index: index,
                            id: vm.prd_id,
                            alias: vm.prd_alias,
                            option_view: vm.option_view,
                            filter_key: vm.filter_ids.join(),
                            combo_key: vm.combo_ids.join(),
                            quan: vm.quantity,
                        },
                        dataType: 'json',
                    }).done(function (json) {
                        if (json.error == 1) {
                            Swal.fire({
                                title: 'Thông báo',
                                text: json.msg,
                                type: 'warning', confirmButtonText: 'Đồng ý', confirmButtonColor: '#f37d26',
                            });
                        } else {
                            shop.redirect(json.data['url']);
                        }
                    });
                } else {
                    vm.error_msg = 'Vui lòng chọn ít nhất 1 sản phẩm';
                }
            }
            if (vm.error_msg != '') {
                Swal.fire({
                    title: 'Thông báo',
                    text: vm.error_msg,
                    type: 'warning', confirmButtonText: 'Đồng ý', confirmButtonColor: '#f37d26',
                });
            }

        },
        formatPrice: function (value) {
            return shop.numberFormat(value);
        },
        update_slide: function (ele) {
            var vm = this;
            if (vm.des_up_jscar !== false) {
                $('#fuckyou').html('<div id="des_up_jscar" data-items="1" data-dots="true" data-arrows="false" data-autoplay="true" class="collection js-carousel owl-carousel owl-theme"></div>');
                $('#des_up_jscar').trigger('destroy.owl.carousel');
                $.each(ele, function (key_ele, value_ele) {
                    var url_origin = ENV.BASE_URL + 'upload/filters_img/original/' + value_ele;
                    var url_thumb_800 = ENV.BASE_URL + 'upload/filters_img/thumb_800x0/' + value_ele;
                    $('#des_up_jscar').append('<div class="product-slide">' +
                        '<div class="product-image">' +
                        '<a data-fancybox="img-slide" href="' + url_origin + '" class="item">' +
                        '<img src="' + url_thumb_800 + '" alt="" class="lazy loaded" data-ll-status="loaded">' +
                        '</a>' +
                        '</div>' +
                        '</div>')
                })
                $('#des_up_jscar').owlCarousel({
                    items: 1,
                    slideSpeed: 2000,
                    nav: false,
                    autoplay: false,
                    dots: true,
                    loop: true,
                    lazyLoad: true,
                    margin: 10,
                    responsiveRefreshRate: 200,
                    navText: ['<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>', '<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'],
                });
                vm.des_up_jscar = false;

            }
        },
    }
});
// var inFoP = new Vue({
//     el: '#info_Product',
//     data: {
//         infoPro: JSON.parse(infoPro),
//     },
// });
// var inFoPmobile = new Vue({
//     el: '#info_Product_mobile',
//     data: {
//         infoPro: JSON.parse(infoPro),
//     },
// });

$(document).ready(function () {
    $('.show-form-rate').click(function () {
        $('.form-rate').slideToggle();
    });

    // $('[data-fancybox="img-slide"]').fancybox({
    //     margin: [44, 0, 22, 0],
    //     thumbs: {
    //         autoStart: true,
    //         axis: 'x'
    //     }
    // })
});


