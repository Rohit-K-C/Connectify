<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $table = 'users'; // Replace 'your_table_name' with the actual name of your database table.

    protected $fillable = ['user_name']; // Replace 'column_name' with the names of columns you want to allow mass assignment.

    // Add any other model-specific configurations, relationships, or methods as needed.
}
