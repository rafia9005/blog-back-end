<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use HasFactory;

    protected $table = "contacts";

    protected $fillable = [
        "phone",
        "sosial-link"
    ];

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, "user_id", "id");
    }
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class, "contact_id", "id");
    }
}
