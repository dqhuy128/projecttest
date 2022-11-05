promotion_campaign = {
    fucking_choosed_items: dit_con_me_nha_may
};

promotion_campaign.serilizeForm = function(page,selector_id_to_fill,selector_form_for_get = 'search_form_ajax',url = 'product/get_products') {
    var formData = document.getElementById(selector_form_for_get);
    formData = $(formData).serialize();//shop.toJSONString(formData);
    // if(typeof formData == 'object') {
        // formData.page = page;
    promotion_campaign.fcking_callback(url,formData,selector_id_to_fill);
        // shop.ajax_popup(url, 'POST', formData, function (json) {
        //     if (json.error == 0) {
        //         document.getElementById(selector_id_to_fill).innerHTML = json.data;
        //     } else {
        //         console.log(json);
        //     }
        // });
    // }
};
promotion_campaign.add_all = function() {
    var item_campaigns = $('.item_campaign');
// alert(item_campaigns.length);
    if(item_campaigns.length > 0) {
        var ids = [];
        $.each(item_campaigns,function(key,ele){
            // console.log($(ele).attr('data-id'));
            var id = $(ele).attr('data-id');
            var check_ele = $('#prd_item_'+id);

            if(check_ele.length <= 0) {
                ids.push(id);
            }
        });

        if(ids.length > 0) {
            shop.ajax_popup('promotioncampaign/get_product_by_id', 'GET', {ids: ids}, function (json) {
                if (json.error == 0) {
                    $.each(json.data,function(key,ele) {
                        var html = '<div class="col-lg-2 text-center p-2" id="prd_item_' + ele.id + '">\n' +
                            '            <a href="" class="d-block" style="min-height:120px"><img class="img-thumbnail" src="' + ele.image + '" alt=""></a>\n' +
                            '            <b class="d-block">' + ele.title + '</b>\n' +
                            '            <b class="d-block">' + ele.price_format + '</b>\n' +
                            '            <b class="d-block" style="text-decoration: line-through;">' + ele.price_strike_format + '</b>\n' +
                            '            <div>\n' +
                            '                <a class="btn btn-outline-danger" href="javascript:void(0);" onclick="promotion_campaign.remove(' + ele.id + ');"><i class="icon-minus"></i> &nbsp;Xóa</a>\n' +
                            '            </div>\n' +
                            '            <input type="hidden" name="list_prd_itema[]" value="' + ele.id + '"/>' +
                            '        </div>';
                        $('#list_prds_choosed').append(html);
                    });
                }
            });
        }
    }
    return false;
};
promotion_campaign.add = function(elem,id) {
    $(elem).addClass('active');
    promotion_campaign.fucking_choosed_items.push(id);
    var check_ele = $('#prd_item_'+id);

    if(check_ele.length <= 0) {
        shop.ajax_popup('promotioncampaign/get_product', 'GET', {id: id}, function (json) {
            if (json.error == 0) {
                var html = '<div class="col-lg-2 text-center p-2" id="prd_item_' + id + '">\n' +
                    '            <a href="" class="d-block" style="min-height:120px"><img class="img-thumbnail" src="'+json.data.image+'" alt=""></a>\n' +
                    '            <b class="d-block">'+json.data.title+'</b>\n' +
                    '            <b class="d-block">'+json.data.price_format+'</b>\n' +
                    '            <b class="d-block" style="text-decoration: line-through;">'+json.data.price_strike_format+'</b>\n' +
                    '            <div>\n' +
                    '                <a class="btn btn-outline-danger" href="javascript:void(0);" onclick="promotion_campaign.remove('+json.data.id+');"><i class="icon-minus"></i> &nbsp;Xóa</a>\n' +
                    '            </div>\n' +
                    '            <input type="hidden" name="list_prd_itema[]" value="'+id+'"/>'+
                    '        </div>';
                $('#list_prds_choosed').append(html);
                // booking.refreshTotalPrice();
            } else {
                alert(json.msg);
            }
        });
    }else {
        alert('Sản phẩm đã được thêm vào trước đó rồi!');
    }
};

promotion_campaign.remove = function(id) {
    $('#prd_item_'+id).remove();
    $('.item_campaign[data-id="'+id+'"]').find('a.btn-outline-success').removeClass('active');

    // booking.refreshTotalPrice();
};

promotion_campaign.remove_all_check = function(id){
    if(confirm('Bạn muốn Xóa Tất Cả SẢN PHẨM ĐÃ THÊM hay không ?')){
        shop.ajax_popup('promotioncampaign/delete_all', 'POST', {id: id}, function(json){
            if(json.error == 0) {
                shop.reload();
            }else{
                alert(json.msg);
            }
        });
    }
}
promotion_campaign.refreshTotalPrice = function() {
    var total = 0;
    var inputs = $('input.quantity');
    if(inputs.length > 0) {
        inputs.each(function(i, obj) {
            total += $(obj).val()*$(obj).attr('data-price-origin')
        });

        $('#totalCart').html(shop.numberFormat(total)+' đ').attr('data-total',total);
        $('#grandTotal').html(shop.numberFormat(total+parseFloat($('#shippingFee').attr('data-shipping')))+' đ')
    }else {
        $('#totalCart').html(0);
        $('#grandTotal').html(0);
    }
};

promotion_campaign.get_ward = function(id,callback) {
    shop.ajax_popup('get-list-wards', 'post', {district_id:id}, function(json) {
        if(json.error == 1){
            alert(json.msg);
        }else {
            var i;
            var html = shop.join('<option value="">--Chọn phường--</option>')();
            for(i in json.data){
                html += shop.join('<option value="'+json.data[i].id+'">'+json.data[i].title+'</option>')();
            }

            $('#ward_id').html(html);
            if (shop.is_exists(callback)) {
                callback();
            }
        }
    });
};

promotion_campaign.fcking_callback = function(url,formData,selector_id_to_fill) {
    shop.ajax_popup(url, 'GET', formData, function (json) {
        if (json.error == 0) {
            document.getElementById(selector_id_to_fill).innerHTML = json.data;
console.log(promotion_campaign.fucking_choosed_items);
            for(var i = 0;i < promotion_campaign.fucking_choosed_items.length;i++) {
                $('.item_campaign[data-id="'+promotion_campaign.fucking_choosed_items[i]+'"]').find('a.btn-outline-success').addClass('active');
            }
        } else {
            console.log(json);
        }
    });
};