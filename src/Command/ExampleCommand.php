<?php

namespace App\Command;

use App\Factory\PaymentServiceFactory;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExampleCommand extends Command
{
    protected static string $defaultName = 'app:example';

    private PaymentServiceFactory $paymentServiceFactory;

    public function __construct(PaymentServiceFactory $paymentServiceFactory)
    {
        parent::__construct();
        $this->paymentServiceFactory = $paymentServiceFactory;
    }

    protected function configure()
    {
        $this
            ->setName(self::$defaultName)
            ->setDescription('Process a purchase through Shift4 or ACI')
            ->addArgument('system', InputArgument::REQUIRED, 'The system to use (shift4 or aci)')
            ->addArgument('params', InputArgument::REQUIRED, 'The parameters for the purchase (JSON string)');
    }

    /**
     * @throws \JsonException
     */
    final protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $system = $input->getArgument('system');
        $params = json_decode($input->getArgument('params'), true, 512, JSON_THROW_ON_ERROR);

        try {
            $service = $this->paymentServiceFactory->getService($system);
            $response = $service->makePurchase($params);

            $output->writeln(json_encode($this->unifyResponse($response), JSON_THROW_ON_ERROR));
            return Command::SUCCESS;
        } catch (\InvalidArgumentException $e) {
            $output->writeln('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    #[ArrayShape(['transaction_id' => "mixed", 'amount' => "mixed", 'currency' => "mixed", 'card_number' => "mixed",
        'card_bin' => "string", 'card_exp_month' => "mixed", 'card_exp_year' => "mixed", 'card_cvv' => "mixed",
        'date_of_creating' => "mixed"])]
    private function unifyResponse(array $response): array
    {
        // Unify the response format
        return [
            'transaction_id' => $response['id'] ?? $response['transaction_id'],
            'amount' => $response['amount'],
            'currency' => $response['currency'],
            'card_number' => $response['card']['number'],
            'card_bin' => substr($response['card']['number'], 0, 6),
            'card_exp_month' => $response['card']['expiry_month'],
            'card_exp_year' => $response['card']['expiry_year'],
            'card_cvv' => $response['card']['cvv'],
            'date_of_creating' => $response['created'],
        ];
    }
}
