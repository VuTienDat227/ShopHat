<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsList extends Model
{
  // ...
    
  public static function createNewsList($data)
  {
      return self::create([
          'title' => $data['title'],
          'content' => $data['content'],
      ]);
  }

  public function updateNewsList($data)
  {
      $this->title = $data['title'];
      $this->content = $data['content'];
      $this->save();

      return $this;
  }

  // ...
}
