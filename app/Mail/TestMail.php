<?php

namespace App\Mail;

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

    /**
     * Create a new message instance.
     *
     * @param string|null $text
     */
    public function __construct(string $text = null)
    {
        Log::info("Constructor : " . $text);
        $this->text = $text;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.github.test')
            ->with('text', $this->text);
    }
}
