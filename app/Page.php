<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Page extends Model
{
    protected $fillable = ['url', 'user_id', 'category_id', 'source_id', 'type'];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    /**
     * Validates the data for a page
     * @param $request
     * @param $id
     *
     * @return array
     */

    public static function validate($request, $id = null)
    {
        $validator = Validator::make($request->input(), [
            'source_id' => 'required',
            'category_id' => 'required',
            'url' => 'required|url|unique:pages,url' . ($id ? ',' . $id : ''),
        ]);

        $source = auth()->user()->sources()->find($request->source_id);

        if (!$source) {
            return [
                'status' => 0,
                'redirection' => back()
            ];
        }

        $validator->after(function ($validator) use ($source, $request) {
            $sourceUrl = parse_url($source->url);
            $pageUrl = parse_url($request->url);
            if (!isset($sourceUrl['host']) || !isset($pageUrl['host']) || $sourceUrl['host'] !== $pageUrl['host']) {
                $validator->errors()->add('url', t('domain_page_mismatch', false));
            }
        });

        if ($validator->fails()) {
            return [
                'status' => 0,
                'errors' => $validator->messages(),
            ];
        }

        return [
            'status' => 1,
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function add()
    {
        $validation = self::validate(request());

        if ($validation['status']) {
            $data = request()->only(['category_id', 'source_id', 'url']);
            $data['type'] = 'page';
            auth()->user()->pages()->create($data);
        }

        return $validation;
    }

    public function modify()
    {
        $request = request();

        $validation = self::validate($request, $this->id);

        if ($validation['status']) {
            $this->update($request->only(['category_id', 'source_id', 'url']));
        }

        return $validation;
    }


}
