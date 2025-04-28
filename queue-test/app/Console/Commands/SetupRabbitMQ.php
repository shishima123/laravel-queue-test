<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupRabbitMQ extends Command
{
    protected $signature = 'rabbitmq:setup';
    protected $description = 'Setup RabbitMQ exchanges and queues';

    public function handle()
    {
        $connection = app('queue')->connection('rabbitmq');
        $channel = $connection->getChannel();

        // Khai báo Exchange
        $channel->exchangeDeclare(
            exchange: 'app_events',
            type: 'topic',
            durable: true,
            autoDelete: false
        );

        $channel->exchangeDeclare(
            exchange: 'app_dlx',
            type: 'direct',
            durable: true,
            autoDelete: false
        );

        // Khai báo Queues
        $channel->queueDeclare(
            queue: 'log_queue',
            durable: true,
            autoDelete: false,
            arguments: [
                'x-dead-letter-exchange' => ['S', 'app_dlx'],
                'x-dead-letter-routing-key' => ['S', 'log.dlq'],
                'x-max-length' => ['I', 100000],
            ]
        );

        $channel->queueDeclare(
            queue: 'mail_queue',
            durable: true,
            autoDelete: false,
            arguments: [
                'x-dead-letter-exchange' => ['S', 'app_dlx'],
                'x-dead-letter-routing-key' => ['S', 'mail.dlq'],
                'x-max-length' => ['I', 10000],
            ]
        );

        $channel->queueDeclare(
            queue: 'log_dlq',
            durable: true,
            autoDelete: false
        );

        $channel->queueDeclare(
            queue: 'mail_dlq',
            durable: true,
            autoDelete: false
        );

        // Bind queues
        $channel->queueBind('log_queue', 'app_events', 'log.*');
        $channel->queueBind('mail_queue', 'app_events', 'mail.*');
        $channel->queueBind('log_dlq', 'app_dlx', 'log.dlq');
        $channel->queueBind('mail_dlq', 'app_dlx', 'mail.dlq');

        $this->info('RabbitMQ setup completed successfully.');
    }
}
