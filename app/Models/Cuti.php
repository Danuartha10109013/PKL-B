<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Cuti extends Model
{
    use HasFactory;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'cuti';
    protected $fillable = [
        'title', 'start', 'end','alasan_cuti','status','keterangan','user_id','jenis_cuti','bukti','score'
    ];
}
