 <!-- Créer une interface 
 PaymentInterface avec :
 pay(float $amount): void
 Créer une classe PayPalService avec :
 sendPayment(float $amount): void qui affiche un echo
 Créer une classe PayPalAdapter implémentant PaymentInterface avec :
 Un attribut privé paypal de type PayPalService
 Un constructeur qui initialise paypal
 pay(float $amount): void qui appelle sendPayment() de PayPalService
 Créer une classe PaymentProcessor avec :
 Un attribut privé payment de type PaymentInterface
 Un constructeur qui initialise payment
 processPayment(float $amount): void qui appelle pay()
 Instancier PayPalService, le passer à PayPalAdapter, puis à PaymentProcessor et appeler processPayment() -->

 <?php


    interface PaymentInterface
    {


        public function pay(float $amount): void;
    }



    class PayPalService
    {

        public function sendPayment(float $amount)
        {
            return "amont: " . $amount;
        }
    }


    class PayPalAdapter implements PaymentInterface
    {

        private object $paypal;

        public function __counstruct(PayPalService $paypal)
        {
            $this->paypal = $paypal;
        }

        public function pay(float  $amount): void {
            $this->paypal->sendPayment($amount);
        }
    }

    class PaymentProcessor {
        private $payment;

        public function __construct(PaymentInterface $payment)
        {
            $this->payment = $payment;
        }

        public function processPayment(float $amount): void 
        {
            $this->payment->pay($amount);
        }
    }


$n1 = new PayPalService();
$n2 = new PayPalAdapter($n1);
