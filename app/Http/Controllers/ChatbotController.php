<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;

class ChatbotController extends Controller
{
    private $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function sendMessage(Request $request): JsonResponse
    {
        // Validate the incoming request
        $request->validate([
            'sender' => 'required|string',
            'message' => 'required|string',
        ]);

        $userMessage = [
            'sender' => $request->input('sender'),
            'message' => $request->input('message'),
        ];

        // Gửi yêu cầu đến Rasa
        $response = $this->httpClient->post('http://localhost:5005/webhooks/rest/webhook', [
            'json' => $userMessage,
        ]);

        if ($response->getStatusCode() === 200) {
            $responseData = json_decode($response->getBody(), true);
            return response()->json($responseData);
        }

        return response()->json(['error' => 'Failed to connect to Rasa server.'], 400);
    }
}
