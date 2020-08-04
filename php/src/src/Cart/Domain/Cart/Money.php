<?php

namespace App\Cart\Domain\Cart;

class Money
{
    private $amount;
    private $currency;

    public function __construct(int $amount, string $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function add(self $money): self
    {
        $this->assertCurrency($money);
        return new self(
            $this->amount + $money->amount,
            $this->currency
        );
    }

    public function subtract(self $money): self
    {
        $this->assertCurrency($money);

        return new self(
            $this->amount() - $money->amount(),
            $this->currency
        );
    }

    public function toString(): string
    {
        $amount = (string)$this->amount / 100;

        return $amount . ' ' . $this->currency;
    }

    public function amount(): int
    {
        return $this->amount;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    /**
     * @param Money $money
     * @throws InvalidCurrencyException
     */
    private function assertCurrency(Money $money): void
    {
        if ($money->currency() !== $this->currency) {
            throw new InvalidCurrencyException('Currency is different');
        }
    }

    public function isEquals(Money $totalAmount): bool
    {
        return $this->amount === $totalAmount->amount()
            && $this->currency === $totalAmount->currency;
    }
}
