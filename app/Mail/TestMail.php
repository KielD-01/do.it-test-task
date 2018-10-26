<?php

namespace App\Mail;

use Cmfcmf\OpenWeatherMap;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Class TestMail
 * @package App\Mail
 * @property string message
 */
class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $text = 'No message has been provided';
    private $location;

    /**
     * Create a new message instance.
     *
     * @param string|null $text
     * @param string|null $location
     */
    public function __construct(string $text = null, string $location = null)
    {
        Log::info("Constructor : " . $text);
        $this->text = $text;
        $this->location = $location;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->weatherSignature();
        return $this->view('emails.github.test')
            ->with('text', $this->text)
            ->with('location', $this->location)
            ->with('weatherSignature', $this->weatherSignature());
    }

    private function weatherSignature()
    {
        try {
            $weather = new OpenWeatherMap(env('OPENWEATHER_API_KEY'));
            $weather = $weather->getWeather($this->location, 'metric');
            return $weather->temperature;
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return [];
        }
    }
}
