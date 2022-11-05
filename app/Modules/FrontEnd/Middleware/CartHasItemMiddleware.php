<?php

namespace App\Modules\FrontEnd\Middleware;

use App\Libs\Cart;
use App\Models\PromotionCampaign;
use App\Models\SpecialOffers;
use Closure;

class CartHasItemMiddleware
{
    public $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $cartInfo = $this->cart->toArray();
        if ($this->cart->isEmpty() || empty($cartInfo['details'])) {
            return redirect()->route('home');
        }

        if (!$this->checkInvalidFS($cartInfo)) {
            return redirect()->route('cart.checkout.cart_complete.error');
        }

        if (!$this->checkInvalidSP($cartInfo)) {
            return redirect()->route('cart.checkout.cart_complete.error');
        }

        return $next($request);
    } // End method

    public function checkInvalidFS($cartInfo): bool
    {
        // Kiểm tra các FS và các KMĐB có bị thay đổi về thông tin hay không
        $flashSaleIds = data_get($cartInfo, 'details.*.flash_sale.id');
        $flashSaleMatch = true; // Biến kiểm tra thông tin FS trong giỏ và thông tin FS trong DB
        $flashSaleIds = array_filter($flashSaleIds);

        if (!empty($flashSaleIds)) {
            $flashSalesData = PromotionCampaign::with('items')->whereIn('id', $flashSaleIds)
                                                ->whereAvailableFlashSale()
                                                ->get();
            if ($flashSalesData->isEmpty()) {
                // FS bị xóa hoặc ẩn => redirect về trang báo lỗi
                $flashSaleMatch = false;
            } else {
                // Kiểm tra xem cái sản phẩm trong giỏ có thuộc FS hay không
                foreach ($cartInfo['details'] as $product) {
                    if (!empty($product['flash_sale'])) {
                        foreach ($flashSalesData as $flashSale) {
                            // 1. Kiểm tra thông tin FS
                            if ($product['flash_sale']['id'] == $flashSale->id) {
                                if ($product['flash_sale']['promote_percent'] != $flashSale->promote_percent) {
                                    $flashSaleMatch = false;
                                }

                                // 2. Kiểm tra sản phẩm có nằm trong FS
                                $productInFSItem = $flashSale->items->filter(function ($flItem) use ($product) {
                                    return $flItem->prd_id == $product['id'];
                                })->first();

                                if (!$productInFSItem) {
                                    $flashSaleMatch = false;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $flashSaleMatch;
    }

    public function checkInvalidSP($cartInfo): bool {
        // Kiểm tra các FS và các KMĐB có bị thay đổi về thông tin hay không
        $activeOfferIds = data_get($cartInfo, 'details.*.active_offers.id');
        $activeOfferMatch = true; // Biến kiểm tra thông tin SP trong giỏ và thông tin SP trong DB
        $activeOfferIds = array_filter($activeOfferIds);
        if (!empty($activeOfferIds)) {
            $activeOfferData = SpecialOffers::with('products:products.id,products.title')->whereIn('id', $activeOfferIds)
                                            ->whereAvailableSP()
                                            ->get();

            if ($activeOfferData->isEmpty()) {
                // FS bị xóa hoặc ẩn => redirect về trang báo lỗi
                $activeOfferMatch = false;
            } else {
                // Kiểm tra xem cái sản phẩm trong giỏ có thuộc FS hay không
                foreach ($cartInfo['details'] as $product) {
                    if (!empty($product['active_offers'])) {
                        foreach ($activeOfferData as $offer) {
                            // 1. Kiểm tra thông tin FS
                            if ($product['active_offers']['id'] == $offer->id) {
                                if ($product['active_offers']['offer_discount_value'] != $offer->offer_discount_value) {
                                    $activeOfferMatch = false;
                                }

                                // 2. Kiểm tra sản phẩm có nằm trong SP
                                $productInSPItem = $offer->products->filter(function ($offerItem) use ($product) {
                                    return $offerItem->id == $product['id'];
                                })->first();

                                if (!$productInSPItem) {
                                    $activeOfferMatch = false;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $activeOfferMatch;
    }
} // End class
