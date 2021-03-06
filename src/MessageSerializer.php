<?php
declare(strict_types=1);

namespace Tomaj\Hermes;

class MessageSerializer implements SerializerInterface
{
    /**
     * {@inheritdoc}
     */
    public function serialize(MessageInterface $message): string
    {
        return json_encode([
            'message' => [
                'id' => $message->getId(),
                'type' => $message->getType(),
                'created' => $message->getCreated(),
                'payload' => $message->getPayload(),
                'execute_at' => $message->getExecuteAt(),
                'retries' => $message->getRetries(),
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize(string $string): MessageInterface
    {
        $data = json_decode($string, true);
        $message = $data['message'];
        $executeAt = null;
        if (isset($message['execute_at'])) {
            $executeAt = floatval($message['execute_at']);
        }
        $retries = 0;
        if (isset($message['retries'])) {
            $retries = intval($message['retries']);
        }
        return new Message($message['type'], $message['payload'], $message['id'], $message['created'], $executeAt, $retries);
    }
}
