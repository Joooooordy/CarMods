<?php

namespace App\Livewire\Checkout;

use App\Models\Order;
use App\Models\Product;
use App\Models\Payment as PaymentModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Random\RandomException;

class Payment extends Component
{
    private const DISCOUNT_CODE = 'CARMODS20';
    private const DISCOUNT_RATE = 0.20;
    private const DISCOUNT_CODE_REGEX = '/^[A-Z0-9]{1,20}$/';

    public array $cart = [];
    public int $shippingCost = 0;
    public float $discountAmount = 0.0;
    public string $discountCode = '';

    public array $paymentMethods = [
        'cc' => 'Credit Card',
        'paypal' => 'Paypal',
        'iDeal' => 'iDeal',
        'klarna' => 'Klarna',
    ];

    public string $paymentMethod = '';
    public string $cc_number = '';
    public string $cc_expiry = '';
    public ?int $cc_cvv = null;

    /**
     * Initializes the component state by retrieving the shopping cart from the session.
     * Calculates the shipping cost based on the current cart contents.
     */
    public function mount(): void
    {
        $this->cart = session('cart', []);
        $this->calculateShippingCost();
    }

    /**
     * Calculates and sets the total shipping cost for the items in the cart.
     */
    protected function calculateShippingCost(): void
    {
        $productIds = collect($this->cart)->pluck('id')->filter()->unique()->values();

        if ($productIds->isEmpty()) {
            $this->shippingCost = 0;
            return;
        }

        $productsById = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $this->shippingCost = (int)collect($this->cart)->sum(
            fn(array $item) => (int)($productsById[$item['id']]->shipping_cost ?? 0)
        );
    }

    /**
     * Sets the selected payment method for the current transaction.
     */
    public function selectPaymentMethod(string $method): void
    {
        $this->paymentMethod = $method;
    }

    /**
     * Determines the credit card type based on the card number.
     */
    public function getCardTypeProperty(): ?string
    {
        $number = preg_replace('/\D/', '', $this->cc_number) ?? '';

        $patterns = [
            'amex' => '/^3[47][0-9]*$/',
            'visa' => '/^4[0-9]*$/',
            'mastercard' => '/^5[1-5][0-9]*$/',
        ];

        foreach ($patterns as $type => $pattern) {
            if (preg_match($pattern, $number)) {
                return $type;
            }
        }

        return null;
    }


    /**
     * Returns the validation rules for a given payment method.
     *
     * Depending on the specified payment method, this function provides an array
     * of rules required for validating the input fields associated with that method.
     * Each payment method has its own set of required rules, such as specific fields
     * being mandatory or requiring a specific data type.
     *
     * Supported payment methods and their rules:
     * - 'cc' (Credit Card): Requires `cc_number`, `cc_expiry`, and `cc_cvv` to be provided.
     * - 'iDeal': Requires `bank` to be provided.
     * - 'klarna': Requires `birth_date` to be provided in a valid date format.
     * - Default: Returns an empty array if the method is unsupported or unspecified.
     *
     * @param string $method The payment method for which validation rules are required.
     * @return array The array of validation rules specific to the provided payment method.
     */
    private function rulesForPaymentMethod(string $method): array
    {
        return match ($method) {
            'cc' => [
                'cc_number' => 'required|string',
                'cc_expiry' => 'required',
                'cc_cvv' => 'required|integer',
            ],
            'iDeal' => [
                'bank' => 'required',
            ],
            'klarna' => [
                'birth_date' => 'required|date',
            ],
            default => [],
        };
    }

    /**
     * Calculates the total subtotal of all items in the cart.
     *
     * Iterates through the cart items, summing the product of each item's
     * price and quantity. The result is converted to a floating-point
     * number to ensure precision in monetary calculations.
     *
     * @return float The subtotal of the cart.
     */
    private function cartSubtotal(): float
    {
        return (float)collect($this->cart)->sum(
            fn(array $item) => (float)($item['price'] * $item['quantity'])
        );
    }

    private function cartTotal(): float
    {
        return $this->cartSubtotal() + $this->shippingCost - $this->discountAmount;
    }

    /**
     * Normalizes the discount code by trimming whitespace and converting it to uppercase.
     *
     * This method ensures that the discount code follows a standardized format before
     * performing validation or further operations.
     *
     * @return string The normalized discount code.
     */
    private function normalizedDiscountCode(): string
    {
        return strtoupper(trim($this->discountCode));
    }

    /**
     * Applies a discount to the current cart if a valid discount code is provided.
     *
     * Validates the discount code against a predefined regex pattern and checks
     * if it matches the expected constant. If valid, calculates the discount
     * amount based on the cart subtotal and a predefined discount rate.
     * Otherwise, sets the discount amount to zero and adds an error message.
     *
     * Flash messages are set in the session to notify the user of the discount status.
     *
     * @return void
     */
    public function applyDiscount(): void
    {
        $code = $this->normalizedDiscountCode();

        if (!preg_match(self::DISCOUNT_CODE_REGEX, $code)) {
            $this->addError('discountCode', 'Invalid characters in discount code.');
            return;
        }

        if ($code !== self::DISCOUNT_CODE) {
            $this->discountAmount = 0.0;
            $this->addError('discountCode', 'Invalid or expired discount code.');
            return;
        }

        $this->discountAmount = round($this->cartSubtotal() * self::DISCOUNT_RATE, 2);
        session()->flash('discountMessage', 'Discount code applied: 20% off!');
    }

    /**
     * Submits the order after validating the provided payment method.
     *
     * Ensures the input complies with the validation rules specific to the selected
     * payment method. If validation passes, a success message is set in the session.
     *
     * @return Redirector|RedirectResponse
     */
    public function submit(): Redirector|RedirectResponse
    {
        $this->validate($this->rulesForPaymentMethod($this->paymentMethod));

        try {
            $order = Order::Create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . now()->format('YmdHis') . '-' . rand(100, 999),
                'subtotal' => $this->cartSubtotal(),
                'total' => $this->cartTotal(),
                'status' => 'pending',
            ]);

            $pivotData = [];
            foreach ($this->cart as $item) {
                $pivotData[$item['id']] = [
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'shipping_cost' => $item['shipping_cost'],
                    'discount_amount' => $item['discount_amount'] ?? 0,
                ];
            }
            $order->products()->sync($pivotData); // sync vervangt oude pivot entries

            $payment = PaymentModel::firstOrCreate([
                'user_id' => auth()->id(),
                'order_id' => $order->id,
                'amount' => $this->cartTotal(),
                'currency' => 'EUR',
                'status' => 'pending',
                'payment_method' => $this->paymentMethod,
                'paid_at' => now(),
                'metadata' => json_encode([])
            ]);

            session()->forget('cart');
            session(['recent_order_id' => $order->id]);

            return redirect()->route('order-confirmed');
        } catch (\Exception $e) {
            \Log::error('Order submission failed: ' . $e->getMessage());

            session()->flash('error', 'An error occurred while processing your order. Please try again.');

            return redirect()->back();
        }
    }

    /**
     * Renders the payment view for the checkout process.
     */
    public function render(): View
    {
        return view('livewire.checkout.payment');
    }
}
