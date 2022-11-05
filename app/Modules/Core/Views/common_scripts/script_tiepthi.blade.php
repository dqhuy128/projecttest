<!-- Google Code dành cho Thẻ tiếp thị lại -->
<script>
    gtag('event', 'view_item', {
        'send_to': 'AW-596347087',
        'value': {{$data['price']}},
        'items': [{
            'id': {{$data['id']}},
            'google_business_vertical': 'retail'
        }]
    });
    gtag('event', 'page_view', {
        'send_to': 'AW-596347087',
        'ecomm_pagetype': 'product',
        'ecomm_prodid': {{$data['id']}},
        'ecomm_totalvalue': {{$data['price']}}
    });

</script>
<script>
    gtag('event', 'view_item', {
        'items': [{
            'id': {{$data['id']}},
            'name': '{!! addslashes($data['title']) !!}',
            'list_name': 'Search Results',
            'brand': 'Lapvip',
            'category': '{!! addslashes($data['cate_title']) !!}',
            'variant': '',
            'list_position': 1,
            'quantity': 1,
            'price': {{$data['price']}}
        }]
    });

</script>
