<?php

namespace App\Http\Livewire\Checkout;

use App\Models\Product;
use Livewire\Component;

class Payment extends Component
{
    public $cart = [];
    public $shippingCost = 0;
    public float $discountAmount = 0.0;
    public string $discountCode = '';


    public $paymentMethods = [
        'cc' => 'Credit Card',
        'paypal' => 'Paypal',
        'iDeal' => 'iDeal',
        'klarna' => 'Klarna',
    ];

    public $paymentMethod = '';
    public $cc_number;
    public $cc_expiry;
    public $cc_cvv;


    public function mount()
    {
        $this->cart = session('cart', []);
        $this->getShippingCost();
    }

    public function applyDiscount()
    {
        // Trim en zet naar hoofdletters
        $code = strtoupper(trim($this->discountCode));

        if (!preg_match('/^[A-Z0-9]{1,20}$/', $code)) {
            $this->addError('discountCode', 'Invalid characters in discount code.');
            return;
        }

        // Controleer de code
        if ($code === 'CARMODS20') {
            $subtotal = collect($this->cart)->sum(fn($i) => $i['price'] * $i['quantity']);
            $this->discountAmount = round($subtotal * 0.2, 2);
            session()->flash('discountMessage', 'Discount code applied: 20% off!');
        } else {
            $this->discountAmount = 0;
            $this->addError('discountCode', 'Invalid or expired discount code.');
        }
    }

    public function submit()
    {
        $rules = [];

        if ($this->paymentMethod === 'cc') {
            $rules = [
                'cc_number' => 'required|numeric',
                'cc_expiry' => 'required',
                'cc_cvv' => 'required|numeric',
            ];
        } elseif ($this->paymentMethod === 'iDeal') {
            $rules = [
                'bank' => 'required',
            ];
        } elseif ($this->paymentMethod === 'klarna') {
            $rules = [
                'birth_date' => 'required|date',
            ];
        }

        $this->validate($rules);

        // Verwerk betaling hier...

        session()->flash('message', 'Order successfully placed!');
    }

    protected function getShippingCost(): void
    {
        $products = Product::whereIn('id', collect($this->cart)->pluck('id'))->get()->keyBy('id');
        $this->shippingCost = collect($this->cart)->sum(fn($item) => $products[$item['id']]->shipping_cost ?? 0);
    }

    public function selectPaymentMethod($method)
    {
        $this->paymentMethod = $method;
    }


    public function getCardTypeProperty()
    {
        $number = preg_replace('/\D/', '', $this->cc_number);

        if (preg_match('/^3[47][0-9]*$/', $number)) {
            return 'amex';
        } elseif (preg_match('/^4[0-9]*$/', $number)) {
            return 'visa';
        } elseif (preg_match('/^5[1-5][0-9]*$/', $number)) {
            return 'mastercard';
        }

        return null;
    }

    public function render()
    {
        return view('livewire.checkout.payment');
    }
}
