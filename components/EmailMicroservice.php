<?php
namespace app\components;

use yii\httpclient\Client;
use yii\httpclient\CurlTransport;
use yii\base\Component;
use yii\helpers\Console;

/**
 * EmailMicroservice is a Yii component that provides an interface to an external email sending microservice.
 * It allows sending emails by making HTTP requests to the microservice's API endpoints.
 * Methods throw exceptions on failure (following Microsoft Graph sendMail API behavior).
 */
class EmailMicroservice extends Component
{
    public $baseUrl;
    public $apiKey;
    
    public $debug = false; // Enable console debug output
    
    public $connectTimeout = 10; // Connection establishment timeout in seconds
    public $timeout = 30; // Connection timeout in seconds

    private static function is_base64(string $s): bool
    {
        // Check if there are valid base64 characters
        if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s)){
            return false;
        }

        // // Decode the string in strict mode and check the results
        // $decoded = base64_decode($s, true);
        // if(false === $decoded) return false;

        // // Encode the string again
        // if(base64_encode($decoded) != $s) return false;

        return true;
    }

    private function DebugConsole(string $message)
    {
        if ($this->debug) {
            // check for console or web context
            $is_web_context = isset($_SERVER['HTTP_USER_AGENT']);
            if ($is_web_context) {
                // web context, log to browser console
                \Yii::info($message, 'emailComponent');
            } else {
                // console context, output to console
                Console::output("[EmailComponent] " . $message);
            }
        }
    }

    /**
     * Sends an email using the email microservice.
     * @param string $to Recipient email address
     * @param string $subject Email subject
     * @param string $body Email body content
     * @param array $options Additional options (e.g. 'from', 'cc', 'bcc', etc.)
     * @return bool True if the request was accepted (202)
     * @throws \Exception on any failure
     */
    public function sendEmail(string $to, string $subject, string $body, array $options = []): bool
    {
        $this->DebugConsole("Sending email to: {$to}, Subject: {$subject}");
        
        $client = new Client([
            'baseUrl' => $this->baseUrl,
            'transport' => CurlTransport::class,
        ]);
        
        $data = array_merge([
            'to' => $to,
            'subject' => $subject,
            'body' => $body
        ], $options);
        
        $this->DebugConsole("Payload: " . json_encode($data));
        $this->DebugConsole("Connecting to: {$this->baseUrl}/send-email");
        
        try {
            $response = $client->createRequest()
                ->setMethod('POST')
                ->setUrl('/send-email')
                ->setFormat(Client::FORMAT_JSON)
                ->setData($data)
                ->setOptions([
                    CURLOPT_CONNECTTIMEOUT => $this->connectTimeout,
                    CURLOPT_TIMEOUT => $this->timeout,
                ])
                ->addHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->send();
            
            $this->DebugConsole("Response status: {$response->statusCode}");
            
            if ($response->isOk) {
                $this->DebugConsole("Email accepted for delivery, status code: {$response->statusCode}");
                return true;
            }
            
            throw new \Exception(
                "HTTP {$response->statusCode}: " . substr($response->content, 0, 200)
            );
        } catch (\Exception $e) {
            $this->DebugConsole("Exception: " . $e->getMessage());
            $this->DebugConsole($e->getTraceAsString());
            \Yii::error('Email microservice error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Sends a MIME-formatted email using the email microservice.
     * This method supports custom headers like List-Unsubscribe that are included in the MIME content.
     * @param string $mimeContent Base64-encoded MIME message content
     * @return bool True if the request was accepted (202)
     * @throws \Exception on any failure (400 for invalid base64, etc.)
     */
    public function sendMimeEmail(string $mimeContent): bool
    {
        $this->DebugConsole("Sending MIME email");
        
        if (!self::is_base64($mimeContent)) {
            throw new \Exception(
                "Invalid base64 string for MIME content"
            );
        }

        $client = new Client([
            'baseUrl' => $this->baseUrl,
            'transport' => CurlTransport::class,
        ]);

        $data = ['mimeContent' => $mimeContent];
        
        $this->DebugConsole("Payload size: " . strlen($mimeContent) . " bytes");
        $this->DebugConsole("Connecting to: {$this->baseUrl}/send-mime");
        
        try {
            $response = $client->createRequest()
                ->setMethod('POST')
                ->setUrl('/send-mime')
                ->setFormat(Client::FORMAT_JSON)
                ->setData($data)
                ->setOptions([
                    CURLOPT_CONNECTTIMEOUT => $this->connectTimeout,
                    CURLOPT_TIMEOUT => $this->timeout,
                ])
                ->addHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->send();
            
            $this->DebugConsole("Response status: {$response->statusCode}");
            
            if ($response->isOk) {
                $this->DebugConsole("MIME email accepted for delivery, status code: {$response->statusCode}");
                return true;
            }
            
            throw new \Exception(
                "HTTP {$response->statusCode}: " . substr($response->content, 0, 200)
            );
        } catch (\Exception $e) {
            $this->DebugConsole("Exception: " . $e->getMessage());
            $this->DebugConsole($e->getTraceAsString());
            \Yii::error('Email microservice MIME error: ' . $e->getMessage());
            throw $e;
        }
    }
}