const detailAccesscory = {
  calcTotalOrder(ele, accessorie_ids = "") {
    let accessories_idsArray = accessorie_ids.split(",");
    if (ele.checked) {
      accessories_idsArray.push(ele.value);
    } else {
      let position = accessories_idsArray.indexOf(ele.value);
      accessories_idsArray.splice(position, 1);
    }

    console.log(accessories_idsArray);
    // accessories_idsArray = accessories_idsArray.filter(item => {
    //     return item.length > 0;
    // });
  },

  getAllUrlParams() {
    let keyPairs = [],
      params = window.location.search.substring(1).split("&");
    for (var i = params.length - 1; i >= 0; i--) {
      keyPairs.push(params[i].split("="));
    }
    return keyPairs;
  },

  buildParamToQueryString(accessories_idsArray) {
    let params = this.getAllUrlParams();
    let objectQuery = {};
    let hasAccessory = false;
    params.forEach((item) => {
      if (item[0].length > 0) {
        if (item[0] == "accessorie_ids") {
          hasAccessory = true;
          objectQuery[item[0]] = accessories_idsArray.join(",");
        } else {
          objectQuery[item[0]] = item[item.length - 1];
        }
      }
    });

    if (!hasAccessory) {
      objectQuery["accessorie_ids"] = accessories_idsArray.join(",");
    }
    console.log(objectQuery);

    return objectQuery;
  },

  addGiaPhuKienVaoTongGiaDetail(ele, giaPhuKien = 0) {
    let tongTienPhuKien = $("#totalAccDisplay").data("totalacc");
    if (ele.checked) {
      tongTienPhuKien = parseInt(tongTienPhuKien) + parseInt(giaPhuKien);
    } else {
      tongTienPhuKien = parseInt(tongTienPhuKien) - parseInt(giaPhuKien);
    }

    return $("#totalAccDisplay")
      .data("totalacc", tongTienPhuKien)
      .text(priceFormat(tongTienPhuKien) + " đ");
  },

  initPrdPrice(totalPriceParam = 0) {
    let totalPrice = totalPriceParam > 0 ? totalPriceParam : $("#optionPrice").val();
    $(".accessories-item--desc .choose input.accessory-item").prop('checked',false);
    $("#totalAccDisplay")
      .text(priceFormat(totalPrice))
      .data("totalacc", totalPrice);
  },
};

$(document).ready(function () {
    detailAccesscory.initPrdPrice();
});