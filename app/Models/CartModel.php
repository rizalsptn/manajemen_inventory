namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
protected $table = 'carts';
protected $primaryKey = 'id';
protected $allowedFields = ['user_id', 'product_id', 'quantity', 'created_at'];
protected $useTimestamps = true;
protected $createdField = 'created_at';
}