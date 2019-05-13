<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ContentPage extends Model
{
    protected $table = 'dcos_content_page';

	protected $fillable = ['picture', 'title', 'content', 'flag_active'];

	public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
