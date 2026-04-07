<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SiteSetting;
use App\Services\SeoService;
use App\Support\MediaUrl;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function checkout(Request $request, Product $product)
    {
        $stripeEnabled = SiteSetting::get('stripe_enabled', '0');
        if ($stripeEnabled !== '1') {
            abort(404);
        }

        if (! $product->is_purchasable || ! $product->is_active || ! $product->price) {
            abort(404);
        }

        $secretKey = SiteSetting::get('stripe_secret_key', '');
        if (! $secretKey) {
            abort(503, 'Pagos no configurados.');
        }

        Stripe::setApiKey($secretKey);

        $lineItem = ['quantity' => 1];

        if ($product->stripe_price_id) {
            $lineItem['price'] = $product->stripe_price_id;
        } else {
            $lineItem['price_data'] = [
                'currency' => 'usd',
                'unit_amount' => (int) round((float) $product->price * 100),
                'product_data' => [
                    'name' => $product->name,
                    'description' => $product->short_description ?? $product->category?->name,
                    'images' => $product->coverImage
                        ? [MediaUrl::image($product->coverImage->path)]
                        : [],
                ],
            ];
        }

        $checkoutSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [$lineItem],
            'mode' => 'payment',
            'success_url' => route('checkout.success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('catalogo.producto', [
                $product->category->slug,
                $product->slug,
            ]),
            'metadata' => [
                'product_id' => $product->id,
                'product_name' => $product->name,
            ],
        ]);

        return redirect($checkoutSession->url);
    }

    public function success(Request $request)
    {
        $seo = SeoService::applyDefaults([
            'title' => 'Pago exitoso | '.config('app.name'),
            'meta_description' => 'Confirmacion de pago exitoso.',
            'noindex' => true,
            'canonical' => SeoService::canonicalForCurrentRequest(),
        ]);

        return view('pages.checkout.success', compact('seo'));
    }

    public function cancel()
    {
        return redirect()->back()->with('info', 'El pago fue cancelado.');
    }
}
