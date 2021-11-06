<?php

namespace Octo\Notifications;

use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notification;
use Octo\Concerns\ToSmsProvider;
use Octo\Route;

class HeloDolly extends Notification
{
    use ToSmsProvider;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return $this->to(['database']);
    }

    public function toSms($notifiable)
    {
        return $this->lyrics();
    }

    public function toArray($notifiable)
    {
        return (new \Octo\Notification([
            'title' => "Hello Dolly",
            'description' => $this->lyrics(),
            'route' => (new Route(['name' => 'dashboard']))
        ]))->pusher($this->user)->toArray();
    }

    function lyrics() {
        /*
        Original Name: Hello Dolly
        Plugin URI: http://wordpress.org/plugins/hello-dolly/
        Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from <cite>Hello, Dolly</cite> in the upper right of your admin screen on every page.
        Author: Matt Mullenweg
        Version: 1.7.2
        Author URI: http://ma.tt/
        */
        /** These are the lyrics to Hello Dolly */
        $lyrics = "Hello, Dolly
Well, hello, Dolly
It's so nice to have you back where you belong
You're lookin' swell, Dolly
I can tell, Dolly
You're still glowin', you're still crowin'
You're still goin' strong
I feel the room swayin'
While the band's playin'
One of our old favorite songs from way back when
So, take her wrap, fellas
Dolly, never go away again
Hello, Dolly
Well, hello, Dolly
It's so nice to have you back where you belong
You're lookin' swell, Dolly
I can tell, Dolly
You're still glowin', you're still crowin'
You're still goin' strong
I feel the room swayin'
While the band's playin'
One of our old favorite songs from way back when
So, golly, gee, fellas
Have a little faith in me, fellas
Dolly, never go away
Promise, you'll never go away
Dolly'll never go away again";

        // Here we split it into lines.
        $lyrics = explode( "\n", $lyrics );

        // And then randomly choose a line.
        return $lyrics[ mt_rand( 0, count( $lyrics ) - 1 ) ];
    }
}
