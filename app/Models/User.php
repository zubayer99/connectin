<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function education()
    {
        return $this->hasMany(Education::class);
    }

    public function sentConnections()
    {
        return $this->hasMany(Connection::class, 'sender_id');
    }

    public function receivedConnections()
    {
        return $this->hasMany(Connection::class, 'receiver_id');
    }

    public function pendingReceivedConnections()
    {
        return $this->hasMany(Connection::class, 'receiver_id')->where('status', 'pending');
    }

    public function connections()
    {
        // This is a bit complex to return a Relation object for proper pagination on "My Network"
        // But for a simple getter:
        return $this->sentConnections()->where('status', 'accepted')
            ->get()
            ->merge($this->receivedConnections()->where('status', 'accepted')->get());
    }

    public function isConnectedWith(User $user)
    {
        return $this->sentConnections()->where('receiver_id', $user->id)->where('status', 'accepted')->exists()
            || $this->receivedConnections()->where('sender_id', $user->id)->where('status', 'accepted')->exists();
    }

    public function hasPendingRequestFrom(User $user)
    {
        return $this->receivedConnections()->where('sender_id', $user->id)->where('status', 'pending')->exists();
    }
     
    public function hasSentRequestTo(User $user)
    {
        return $this->sentConnections()->where('receiver_id', $user->id)->where('status', 'pending')->exists();
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class);
    }
    
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function savedItems()
    {
        return $this->hasMany(SavedItem::class);
    }

    public function hasSaved($model)
    {
        return $this->savedItems()
            ->where('saveable_id', $model->id)
            ->where('saveable_type', get_class($model))
            ->exists();
    }
}
