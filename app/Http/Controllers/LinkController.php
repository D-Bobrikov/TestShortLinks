<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyLinkRequest;
use App\Http\Requests\IndexLinkRequest;
use App\Http\Requests\StoreLinkRequest;
use App\Http\Resources\LinkResource;
use App\Http\Telegraph\SendLogTg;
use App\Models\Link;
use App\Models\Source;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    public SendLogTg $bot;

    public function __construct(SendLogTg $bot)
    {
        $this->bot = $bot;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexLinkRequest $request): AnonymousResourceCollection
    {
        return LinkResource::collection(self::getSource($request)['links']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLinkRequest $request): JsonResponse
    {
        $source = self::getSource($request);

        $checkLink = false;
        $shortReference = '';

        foreach ($source['links'] as $link) {
            if ($request->full_reference === $link->full_reference) {
                $checkLink = true;
                $shortReference = $link->short_reference;
            }
        }

        if (! $checkLink) {
            $shortReference = self::shortLinkGenerator();
            Link::create([
                'full_reference' => $request->full_reference,
                'short_reference' => $shortReference,
                'source_id' => $source['id'],
            ]);

            $this->limitAndNotification($source);
        }

        return response()->json(
            [
                'status' => 'ok',
                'short_reference' => $shortReference,
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyLinkRequest $request): JsonResponse
    {
        Link::find($request->id)->delete();

        return response()->json(
            [
                'status' => 'delete',
            ]
        );
    }

    private static function getSource($request): array
    {
        $source = Source::where('token', $request->token)->firstOrFail();

        return [
            'id' => $source->id,
            'name' => $source->name,
            'links' => $source->links,
        ];
    }

    private static function shortLinkGenerator(): string
    {
        return 'https://'.Str::random(8).'.info';
    }

    public function limitAndNotification($source): void
    {
        $hourAgo = time() - 3600;
        $countLink = Link::where('source_id', $source['id'])
            ->where('created_at', '>', $hourAgo)
            ->count();

        if ($countLink > 10) {
            $this->bot->sendLog('Источник '.$source['name'].' выходит за лимит - '.$countLink.' ссылок сокращены...');
        }

    }
}
