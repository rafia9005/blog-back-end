<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;
    protected $table = "addresses";
    protected $fillable = [
        "streat",
        "city",
        "province",
        "country",
        "postal_code"
    ];

    public function contacts(): BelongsTo
    {
        return $this->belongsTo(Contact::class, "contact_id", "id");
    }
}
