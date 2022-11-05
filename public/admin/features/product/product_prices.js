    var app_prd_prices = new Vue({
    // options content
    el: '#product-admin-prices',
    data: {

        filter_cate_price: filter_cate_price ? JSON.parse(filter_cate_price) : [],
        filter_prices: filter_prices ? filter_prices : [],
        combo: combo ? combo : [],
        // mount: mount ? JSON.parse(mount) : [],
        warehouse: warehouse_ ? JSON.parse(warehouse_) : [],
        images: [],
        combo_checked: {checked:'', type: ''    },
    },
    beforeMount() {
        // console.log(this.temp_warehouse);
        var temp_warehouse = [];
        for (var i = 0; i < this.filter_prices.length; i++) {
            temp_warehouse = JSON.parse(JSON.stringify(this.warehouse));
            for (var k = 0; k < this.filter_prices[i].storage.length;k++) {
                for (var j = 0; j < temp_warehouse.length; j++) {
                    if(this.filter_prices[i].storage[k].warehouse_id == this.warehouse[j].id) {
                        temp_warehouse[j].amount = this.filter_prices[i].storage[k].amount;
                        break;
                    }
                }
            }
            this.filter_prices[i].warehouse = temp_warehouse;
        }

        // for (var i = 0; i < this.filter_prices.length; i++) {
        //     for (var k = 0; k < this.filter_prices[i].storage.length;k++) {
        //         for (var j = 0; j < temp_warehouse.length; j++) {
        //             if(this.filter_prices[i].storage[k].warehouse_id == temp_warehouse[j].id) {
        //                 temp_warehouse[j].amount = this.filter_prices[i].storage[k].amount;
        //                 break;
        //             }
        //             // else {
        //             //     temp_warehouse[j].amount = 0;
        //             // }
        //         }
        //     }
        //     this.filter_prices[i].warehouse = temp_warehouse;
        // }

        // console.log(this.filter_prices);
    },
    mounted(){
        this.loader();

    },
    computed: {

    },
    updated: function(){

    },
    filters: {

    },
    methods:{
        uploadImage: function(e) {
            let vm = this;
            var selectedFiles = e.target.files;
            for (let i = 0; i < selectedFiles.length; i++) {
                this.images.push(selectedFiles[i]);
            }

            for (let i = 0; i < this.images.length; i++) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.$refs.image[i].src = reader.result;
                };

                reader.readAsDataURL(this.images[i]);
            }
        },
        remove_img_props: function(e,img,container){
            e.preventDefault();
            sessionStorage.setItem("container", container);
            for (var i =0; i < container.length; i++) {
                if (container[i] == img) {
                    container.splice(i, 1);
                    break;
                }
            }

        },
        removeImage: function(e, key) {
            e.preventDefault();
            let vm = this;
            vm.images.some(function (key) {
                return vm.images.splice(key, 1)
            })
            // if(vm.images[index] === item) {
            //     vm.images.splice(index, 1)
            // } else {
            //     let found = vm.images.indexOf(item)
            //     vm.images.splice(found, 1)
            // }
            // console.log(item);
            // vm.$delete(vm.images, key)
            // vm.images.splice(vm.images.indexOf(item), 1)
            // for (var i =0; i < arr_img.length; i++) {
            //     if (arr_img[i].lastModified == key.lastModified) {
            //         arr_img.splice(i, 1);
            //         console.log(arr_img[i])
            //         break;
            //     }
            // }

            // var arrayImages = this.images;
            // var index = arrayImages.indexOf(arrayImages[i]);
            // arrayImages.splice(index, i);

        },
        loader: function() {
            setTimeout(function() {
                if($('#product-admin-prices .pb_loader').length > 0) {
                    $('#product-admin-prices .pb_loader').removeClass('show');
                }
            }, 700);
        },
        show_loader: function() {
            if($('#product-admin-prices .pb_loader').length > 0) {
                $('#product-admin-prices .pb_loader').addClass('show');
            }
        },
        hide_loader: function() {
            if($('#product-admin-prices .pb_loader').length > 0) {
                $('#product-admin-prices .pb_loader').removeClass('show');
            }
        },
        addLine: function (key_price) {
            this.isShow = true;
            return this.filter_prices[key_price].param_filter.push({});
        },
        trashLine: function (key_price, topic_props,index) {
            if(this.filter_prices[key_price].param_filter.length > 1) {
                this.filter_prices[key_price].param_filter.splice(index, 1);
            }else {
                this.filter_prices[key_price].param_filter.splice(index, 1);
                return this.filter_prices[key_price].param_filter.push();
            }
        },
        filter_click:function(e) {
            e.preventDefault();
            var vm = this.app_prd_prices;
            var obj = [];
            var obj_combo = [];
            var temp = {};
            var key_price = '';
            var combo_price = '';
            var base_price = $('#base_price').val();
            var base_priceStrike = $('#base_priceStrike').val();
            var option_view = $('#option_view').val();


            if (option_view == 3){
                this.filter_cate_price.forEach(function(item,key){
                    if(item.checked > 0) {
                        item.filters.forEach(function (o,k) {
                            if(o.id == item.checked) {
                                key_price += key_price == '' ? o.id : ',' + o.id;
                                return obj.push({id:o.id, title:o.title});
                            }
                        });
                    }
                });
                if (this.combo_checked.checked > 0){
                    var vm = this;
                    vm.combo.forEach(function (item_com, key_com) {
                        if (item_com.id == vm.combo_checked.checked){
                            combo_price = item_com.id;
                            return obj_combo.push({id_combo: item_com.id, title_combo:item_com.title});
                        }
                    })
                }
                if(obj.length > 0) {
                    if (obj_combo.length > 0){
                        temp = {
                            image_filter:[],
                            param_filter:[{param_filter_titles: '',param_filter_values: ''}],
                            key_price: key_price,
                            combo_price: combo_price,
                            obj: obj,
                            obj_combo: obj_combo,
                            price: base_price,
                            price_strike: base_priceStrike,
                            warehouse: this.warehouse,
                        }
                        var existed = 0;
                        if(app_prd_prices.filter_prices.length > 0) {
                            for (var i = 0; i < app_prd_prices.filter_prices.length; i++) {
                                if (app_prd_prices.filter_prices[i].key_price == temp.key_price && app_prd_prices.filter_prices[i].combo_price == temp.combo_price) {
                                    existed = 1;
                                    break;
                                }
                            }
                            if(existed == 0) {
                                app_prd_prices.filter_prices.push(temp);
                            }
                        }else {
                            app_prd_prices.filter_prices.push(temp);
                        }
                    }
                }
            }else if (option_view == 2){
                this.filter_cate_price.forEach(function(item,key){
                    if(item.checked > 0) {
                        item.filters.forEach(function (o,k) {
                            if(o.id == item.checked) {
                                key_price += key_price == '' ? o.id : ',' + o.id;
                                return obj.push({id:o.id, title:o.title});
                            }
                        });
                    }
                });
                if(obj.length > 0) {
                    temp = {
                        image_filter:[],
                        param_filter:[{param_filter_titles: '',param_filter_values: ''}],
                        key_price: key_price,
                        obj: obj,
                        price: base_price,
                        price_strike: base_priceStrike,
                        warehouse: this.warehouse,
                    }
                    var existed = 0;
                    if(app_prd_prices.filter_prices.length > 0) {
                        for (var i = 0; i < app_prd_prices.filter_prices.length; i++) {
                            if (app_prd_prices.filter_prices[i].key_price == temp.key_price) {
                                existed = 1;
                                break;
                            }
                        }
                        if(existed == 0) {
                            app_prd_prices.filter_prices.push(temp);
                        }
                    }else {
                        app_prd_prices.filter_prices.push(temp);
                    }
                }
            }


        },
        remove_price: function(e, ele){
            e.preventDefault();
            for (var i =0; i < app_prd_prices.filter_prices.length; i++) {
                if (app_prd_prices.filter_prices[i].key_price == ele.key_price) {
                    app_prd_prices.filter_prices.splice(i, 1);
                    break;
                }
            }
        },
    }
});