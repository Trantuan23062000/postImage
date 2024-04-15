<?php

namespace App\Mail;

use Illuminate\Support\Collection;
use App\Models\Photo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class SharePost extends Mailable
{
    use Queueable, SerializesModels;

    protected $photo;

    /**
     * Create a new message instance.
     */
    public function __construct(Photo $photo)
    {
        $this->photo = $photo;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Chia sẽ bài viết',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $postLink = route('viewPost', ['id' => $this->photo->id]); // Giả sử bạn có một route có tên là 'post.show' để hiển thị bài viết
        return (new Content())->view('home.share')->with('postLink', $postLink);
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
