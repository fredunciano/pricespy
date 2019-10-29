<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'company', 'avatar', 'email', 'password', 'equality_percent', 'after_tax_prices',
        'is_sub', 'main_user_id', 'locale', 'country_id', 'town', 'street', 'postal_code', 'house_number', 'place', 'address'
    ];
    protected $primaryKey = 'id';
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function verifyUser()
    {
        return $this->hasOne(VerifyUser::class, 'user_id', 'id');
    }

    public function permissions()
    {
        return $this->hasOne(Permission::class, 'user_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function options()
    {
        if (auth()->user()->is_sub) {
            return $this->hasMany(Option::class, 'user_id', 'main_user_id');
        } else {
            return $this->hasMany(Option::class, 'user_id', 'id');
        }
    }

    public function products()
    {
        if (auth()->user()->is_sub) {
            return $this->hasMany(Product::class, 'user_id', 'main_user_id');
        } else {
            return $this->hasMany(Product::class, 'user_id', 'id');
        }
    }

    public function ownProducts()
    {
        if (auth()->user()->is_sub) {
            return $this->hasMany(Product::class, 'user_id', 'main_user_id')->whereHas('source', function ($q) {
                return $q->where('is_main', 1);
            });
        } else {
            return $this->hasMany(Product::class, 'user_id', 'id')->whereHas('source', function ($q) {
                return $q->where('is_main', 1);
            });
        }
    }

    public function sources()
    {
        if (auth()->user()->is_sub) {
            return $this->hasMany(Source::class, 'user_id', 'main_user_id');
        } else {
            return $this->hasMany(Source::class, 'user_id', 'id');
        }
    }

    public function competitors()
    {
        if (auth()->user()->is_sub) {
            return $this->hasMany(Source::class, 'user_id', 'main_user_id')->where('is_main', 0);
        } else {
            return $this->hasMany(Source::class, 'user_id', 'id')->where('is_main', 0);
        }
    }

    public function mainSource()
    {
        if (auth()->user()->is_sub) {
            return $this->hasOne(Source::class, 'user_id', 'main_user_id')->where('is_main', 1);
        } else {
            return $this->hasOne(Source::class, 'user_id', 'id')->where('is_main', 1);
        }
    }

    public function mainSources()
    {
        if (auth()->user()->is_sub) {
            return $this->hasMany(Source::class, 'user_id', 'main_user_id')->where('is_main', 1);
        } else {
            return $this->hasMany(Source::class, 'user_id', 'id')->where('is_main', 1);
        }
    }

    public function getEqualityOffset()
    {
        return $this->equality_percent / 100;
    }

    public function getExpensivenessBorder()
    {
        return 1 + $this->getEqualityOffset();
    }

    public function getCheapnessBorder()
    {
        return 1 - $this->getEqualityOffset();
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public static function saveFile($file, $path, $oldFilePath = null)
    {
        $name = $path . '/' . time() . '_' . str_random(8) . '.' . $file->getClientOriginalExtension();

        storage()->put($name, file_get_contents($file->getRealPath()));

        self::deleteFile($oldFilePath);

        return $name;
    }

    public static function deleteFile($path)
    {
        if (!empty($path) && storage()->exists($path)) {
            storage()->delete($path);
        }
    }

    public function getAvatar()
    {
        if ($this->avatar && storage()->exists($this->avatar)) {
            return storage()->url($this->avatar);
        }
        return '/img/user-icon-pricespy.png';
    }

    public function competitorRequests()
    {
        if (auth()->user()->is_sub) {
            return $this->hasMany(CompetitorRequest::class, 'user_id', 'main_user_id');
        } else {
            return $this->hasMany(CompetitorRequest::class, 'user_id', 'id');
        }
    }

    public function pages()
    {
        if (auth()->user()->is_sub) {
            return $this->hasMany(Page::class, 'user_id', 'main_user_id');
        } else {
            return $this->hasMany(Page::class, 'user_id', 'id');
        }
    }

    public function categories()
    {
        if (auth()->user()->is_sub) {
            return $this->hasMany(Category::class, 'user_id', 'main_user_id');
        } else {
            return $this->hasMany(Category::class, 'user_id', 'id');
        }
    }

    public function verification()
    {
        return $this->hasOne(VerifyUser::class, 'user_id');
    }

    public function getUserIdAttribute()
    {
        if (auth()->user()->is_sub) {
            return auth()->user()->main_user_id;
        } else {
            return auth()->user()->id;
        }
    }

    public function getUserSourceIdAttribute()
    {
        return $this->mainSource ? $this->mainSource->id : null;
    }

    public static function requestCheck($route)
    {
        $user = auth()->user();
        if ($user->is_sub == false) {
            return true;
        } else {
            switch ($route) {
                case 'productCreate':
                    $condition = $user->permissions->add_product;
                    break;
                case 'productEdit':
                    $condition = $user->permissions->edit_product;
                    break;
                case 'productDelete':
                    $condition = $user->permissions->delete_product;
                    break;
                case 'competitorCreate':
                    $condition = $user->permissions->add_competitor;
                    break;
                case 'competitorEdit':
                    $condition = $user->permissions->edit_competitor;
                    break;
                case 'competitorDelete':
                    $condition = $user->permissions->delete_competitor;
                    break;
                case 'userCreate';
                    $condition = $user->permissions->add_new_sub_user;
                    break;
                case 'invoicePaymentView':
                    $condition = $user->permissions->view_invoice_and_payment_system;
                    break;
            }

            if ($condition == true) {
                return true;
            } else {
                return false;
            }
        }
    }
}
